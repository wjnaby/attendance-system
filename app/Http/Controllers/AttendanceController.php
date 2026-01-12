<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
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
        
        return view('user.dashboard', compact('todayAttendance', 'recentAttendances'));
    }
    
    public function showQrCode()
    {
        $user = auth()->user();
        $qrData = encrypt([
            'user_id' => $user->id,
            'timestamp' => now()->timestamp,
        ]);
        
        $qrCode = QrCode::size(300)->generate($qrData);
        
        return view('user.qr-code', compact('qrCode'));
    }
    
    public function scanQr()
    {
        return view('user.scan-qr');
    }
    
    public function processCheckIn(Request $request)
{
    $request->validate([
        'qr_data' => 'required|string',
    ]);
    
    try {
        $data = decrypt($request->qr_data);
        
        // Verify timestamp (QR valid for 5 minutes)
        if (now()->timestamp - $data['timestamp'] > 300) {
            return response()->json(['error' => 'QR code expired'], 400);
        }
        
        $user = auth()->user();
        
        if ($data['user_id'] != $user->id) {
            return response()->json(['error' => 'Invalid QR code'], 400);
        }
        
        $today = Carbon::today();
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
            
            return response()->json([
                'success' => true,
                'message' => 'Check-in successful',
                'time' => $now->format('h:i A'),
                'status' => $attendance->status,
            ]);
        } elseif (!$attendance->check_out) {
            $attendance->check_out = $now->format('H:i:s');
            $attendance->save();
            
            AuditLog::log(
                'check_out',
                'Checked out at ' . $now->format('h:i A'),
                $attendance
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Check-out successful',
                'time' => $now->format('h:i A'),
            ]);
        } else {
            return response()->json(['error' => 'Already checked in and out for today'], 400);
        }
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Invalid QR code'], 400);
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