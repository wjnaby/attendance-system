<?php
namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    
    public function collection()
    {
        return Attendance::with('user')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->orderBy('date', 'desc')
            ->get();
    }
    
    public function headings(): array
    {
        return [
            'Date',
            'Employee Name',
            'Employee ID',
            'Check In',
            'Check Out',
            'Status',
            'Duration (hours)',
        ];
    }
    
    public function map($attendance): array
    {
        $duration = '-';
        if ($attendance->check_in && $attendance->check_out) {
            $checkIn = Carbon::parse($attendance->check_in);
            $checkOut = Carbon::parse($attendance->check_out);
            $diff = $checkIn->diffInMinutes($checkOut);
            $duration = round($diff / 60, 2);
        }
        
        return [
            $attendance->date->format('Y-m-d'),
            $attendance->user->name,
            $attendance->user->employee_id,
            $attendance->check_in ? Carbon::parse($attendance->check_in)->format('H:i:s') : '-',
            $attendance->check_out ? Carbon::parse($attendance->check_out)->format('H:i:s') : '-',
            ucfirst($attendance->status),
            $duration,
        ];
    }
}