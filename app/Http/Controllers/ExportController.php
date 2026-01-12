<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;

class ExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        return Excel::download(
            new AttendanceExport($startDate, $endDate), 
            'attendance-report-' . $startDate . '-to-' . $endDate . '.xlsx'
        );
    }
    
    public function exportCsv(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $attendances = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();
        
        $filename = 'attendance-report-' . $startDate . '-to-' . $endDate . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Date', 'Employee Name', 'Employee ID', 'Check In', 'Check Out', 'Status', 'Duration']);
            
            foreach ($attendances as $attendance) {
                $duration = '-';
                if ($attendance->check_in && $attendance->check_out) {
                    $checkIn = Carbon::parse($attendance->check_in);
                    $checkOut = Carbon::parse($attendance->check_out);
                    $diff = $checkIn->diff($checkOut);
                    $duration = $diff->h . 'h ' . $diff->i . 'm';
                }
                
                fputcsv($file, [
                    $attendance->date->format('Y-m-d'),
                    $attendance->user->name,
                    $attendance->user->employee_id,
                    $attendance->check_in ? Carbon::parse($attendance->check_in)->format('H:i:s') : '-',
                    $attendance->check_out ? Carbon::parse($attendance->check_out)->format('H:i:s') : '-',
                    ucfirst($attendance->status),
                    $duration,
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}