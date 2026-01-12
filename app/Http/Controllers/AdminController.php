<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
}