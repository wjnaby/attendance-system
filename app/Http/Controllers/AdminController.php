<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\AuditLog;
use App\Models\Setting;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        
        $totalUsers = User::where('role_id', 2)->count();
        $presentToday = Attendance::where('date', $today)
            ->where('status', 'present')
            ->count();
        $lateToday = Attendance::where('date', $today)
            ->where('status', 'late')
            ->count();
        $absentToday = $totalUsers - $presentToday - $lateToday;
        
        $recentAttendances = Attendance::with('user')
            ->where('date', $today)
            ->orderBy('check_in', 'desc')
            ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'presentToday',
            'lateToday',
            'absentToday',
            'recentAttendances'
        ));
    }
    
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $attendances = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        $stats = [
            'total' => Attendance::whereBetween('date', [$startDate, $endDate])->count(),
            'present' => Attendance::whereBetween('date', [$startDate, $endDate])->where('status', 'present')->count(),
            'late' => Attendance::whereBetween('date', [$startDate, $endDate])->where('status', 'late')->count(),
            'absent' => Attendance::whereBetween('date', [$startDate, $endDate])->where('status', 'absent')->count(),
        ];
        
        return view('admin.reports', compact('attendances', 'stats', 'startDate', 'endDate'));
    }
    
    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $attendances = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('admin.pdf-report', compact('attendances', 'startDate', 'endDate'));
        
        return $pdf->download('attendance-report.pdf');
    }
    
    public function users()
    {
        $users = User::where('role_id', 2)->with('attendances')->paginate(15);
        
        return view('admin.users', compact('users'));
    }

    public function leaveRequests()
    {
        $leaveRequests = LeaveRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.leave-requests', compact('leaveRequests'));
    }

    public function approveLeave(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);
        
        AuditLog::log(
            'leave_approved',
            'Approved leave request for ' . $leaveRequest->user->name,
            $leaveRequest
        );
        
        return back()->with('success', 'Leave request approved');
    }

    public function rejectLeave(Request $request, LeaveRequest $leaveRequest)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string',
        ]);
        
        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);
        
        AuditLog::log(
            'leave_rejected',
            'Rejected leave request for ' . $leaveRequest->user->name,
            $leaveRequest
        );
        
        return back()->with('success', 'Leave request rejected');
    }

    public function analytics()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $attendances = Attendance::whereBetween('date', [$startDate, $endDate])->get();
        
        $stats = [
            'total_days' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
        ];
        
        // Weekly breakdown
        $weeklyData = [];
        for ($i = 0; $i < 4; $i++) {
            $weekStart = $startDate->copy()->addWeeks($i);
            $weekEnd = $weekStart->copy()->endOfWeek();
            
            $weeklyData[] = [
                'week' => 'Week ' . ($i + 1),
                'present' => Attendance::whereBetween('date', [$weekStart, $weekEnd])
                    ->where('status', 'present')->count(),
                'late' => Attendance::whereBetween('date', [$weekStart, $weekEnd])
                    ->where('status', 'late')->count(),
                'absent' => Attendance::whereBetween('date', [$weekStart, $weekEnd])
                    ->where('status', 'absent')->count(),
            ];
        }
        
        return view('admin.analytics', compact('stats', 'weeklyData'));
    }

    /**
     * Show the workplace QR code page for admin
     * QR code changes daily for security
     */
    public function showWorkplaceQrCode()
    {
        $qrCode = $this->generateWorkplaceQrCode();
        $expiresAt = now()->addMinutes(5)->format('h:i A');
        $today = Carbon::today()->format('l, F j, Y');
        
        return view('admin.qr-code', compact('qrCode', 'expiresAt', 'today'));
    }

    /**
     * Refresh the workplace QR code
     */
    public function refreshWorkplaceQrCode()
    {
        $qrCode = $this->generateWorkplaceQrCode();
        $expiresAt = now()->addMinutes(5)->format('h:i A');
        
        AuditLog::log(
            'qr_refresh',
            'Workplace QR code refreshed by admin',
            null
        );
        
        return response()->json([
            'success' => true,
            'qr_code' => $qrCode,
            'expires_at' => $expiresAt,
            'message' => 'QR code refreshed successfully',
        ]);
    }

    /**
     * Generate workplace QR code with security features
     */
    private function generateWorkplaceQrCode()
    {
        $qrData = encrypt([
            'workplace_code' => true,
            'date' => Carbon::today()->toDateString(),
            'timestamp' => now()->timestamp,
            'security_hash' => hash('sha256', config('app.key') . Carbon::today()->toDateString()),
        ]);
        
        return QrCode::size(350)
            ->backgroundColor(255, 255, 255)
            ->color(30, 64, 175)
            ->margin(2)
            ->generate($qrData);
    }
}
