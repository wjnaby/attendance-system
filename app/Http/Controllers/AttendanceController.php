<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Setting;
use App\Models\AuditLog;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', Carbon::today())
            ->first();
            
        $recentAttendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();
        
        // Calculate monthly statistics
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $monthlyStats = [
            'present' => Attendance::where('user_id', $user->id)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'present')
                ->count(),
            'late' => Attendance::where('user_id', $user->id)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'late')
                ->count(),
            'leave' => LeaveRequest::where('user_id', $user->id)
                ->where('status', 'approved')
                ->where(function($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('start_date', $currentMonth)
                          ->whereYear('start_date', $currentYear);
                })
                ->count(),
        ];
        
        return view('user.dashboard', compact('todayAttendance', 'recentAttendances', 'monthlyStats'));
    }
    
    /**
     * Show the attendance confirmation page
     */
    public function showConfirmation(Request $request)
    {
        $action = session('attendance_action', 'check_in');
        $time = session('attendance_time', now()->format('h:i A'));
        $status = session('attendance_status', 'present');
        
        return view('user.attendance-confirmation', compact('action', 'time', 'status'));
    }
    
    public function scanQr()
    {
        return view('user.scan-qr');
    }
    
    /**
     * Process check-in/check-out from workplace QR code scan
     */
    public function processCheckIn(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);
        
        try {
            $data = decrypt($request->qr_data);
            
            // Verify this is a workplace QR code (not user-specific)
            if (!isset($data['workplace_code']) || $data['workplace_code'] !== true) {
                return response()->json(['error' => 'Invalid workplace QR code'], 400);
            }
            
            // Verify the QR code is for today (daily refresh security)
            $qrDate = Carbon::parse($data['date'])->format('Y-m-d');
            $today = Carbon::today()->format('Y-m-d');
            
            if ($qrDate !== $today) {
                return response()->json(['error' => 'QR code expired. Please scan today\'s QR code.'], 400);
            }
            
            // Verify timestamp (QR valid for 5 minutes for replay attack prevention)
            if (now()->timestamp - $data['timestamp'] > 300) {
                return response()->json(['error' => 'QR code expired. Please ask admin to refresh the QR code.'], 400);
            }
            
            $user = auth()->user();
            
            // Check if user is authorized (not admin)
            if ($user->isAdmin()) {
                return response()->json(['error' => 'Admins cannot check-in using this system'], 400);
            }
            
            $attendance = Attendance::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'date' => $today,
                ],
                [
                    'status' => 'absent',
                ]
            );
            
            $now = Carbon::now();
            
            // Get check-in time from settings
            $checkInTime = Setting::get('check_in_time', '09:00');
            $lateThreshold = Setting::get('late_threshold_minutes', 15);
            
            if (!$attendance->check_in) {
                $attendance->check_in = $now->format('H:i:s');
                
                // Check if late
                $expectedCheckIn = Carbon::parse($checkInTime);
                $actualCheckIn = Carbon::parse($attendance->check_in);
                
                if ($actualCheckIn->gt($expectedCheckIn->addMinutes($lateThreshold))) {
                    $attendance->status = 'late';
                } else {
                    $attendance->status = 'present';
                }
                
                $attendance->save();
                
                AuditLog::log(
                    'check_in',
                    'Checked in at ' . $now->format('h:i A'),
                    $attendance
                );
                
                // Store in session for confirmation page
                session([
                    'attendance_action' => 'check_in',
                    'attendance_time' => $now->format('h:i A'),
                    'attendance_status' => $attendance->status,
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Check-in successful!',
                    'action' => 'check_in',
                    'time' => $now->format('h:i A'),
                    'status' => $attendance->status,
                    'redirect_url' => route('attendance.confirmation'),
                ]);
            } elseif (!$attendance->check_out) {
                $attendance->check_out = $now->format('H:i:s');
                $attendance->save();
                
                AuditLog::log(
                    'check_out',
                    'Checked out at ' . $now->format('h:i A'),
                    $attendance
                );
                
                // Store in session for confirmation page
                session([
                    'attendance_action' => 'check_out',
                    'attendance_time' => $now->format('h:i A'),
                    'attendance_status' => 'completed',
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Check-out successful!',
                    'action' => 'check_out',
                    'time' => $now->format('h:i A'),
                    'redirect_url' => route('attendance.confirmation'),
                ]);
            } else {
                return response()->json(['error' => 'You have already checked in and out for today'], 400);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid or corrupted QR code. Please try again.'], 400);
        }
    }
    
    public function history()
    {
        $attendances = Attendance::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->paginate(15);
            
        return view('user.history', compact('attendances'));
    }
}