@extends('layouts.app')

@section('title', 'Attendance Reports')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Attendance Reports</h1>
        
        <!-- Date Filter Form -->
        <form method="GET" action="{{ route('admin.reports') }}" class="grid md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input 
                    type="date" 
                    name="start_date" 
                    value="{{ $startDate }}"
                    class="input-field"
                >
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input 
                    type="date" 
                    name="end_date" 
                    value="{{ $endDate }}"
                    class="input-field"
                >
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">
                    🔍 Filter
                </button>
            </div>
            
            <div class="flex items-end">
                <a href="{{ route('admin.export.pdf') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="btn-danger w-full text-center">
                    📄 Export PDF
                </a>
            </div>
        </form>
    </div>
    
    <!-- Statistics -->
    <div class="grid md:grid-cols-4 gap-6">
        <div class="card bg-blue-50 border border-blue-200">
            <p class="text-sm text-blue-600 font-semibold mb-1">Total Records</p>
            <p class="text-3xl font-bold text-blue-700">{{ $stats['total'] }}</p>
        </div>
        
        <div class="card bg-green-50 border border-green-200">
            <p class="text-sm text-green-600 font-semibold mb-1">Present</p>
            <p class="text-3xl font-bold text-green-700">{{ $stats['present'] }}</p>
        </div>
        
        <div class="card bg-yellow-50 border border-yellow-200">
            <p class="text-sm text-yellow-600 font-semibold mb-1">Late</p>
            <p class="text-3xl font-bold text-yellow-700">{{ $stats['late'] }}</p>
        </div>
        
        <div class="card bg-red-50 border border-red-200">
            <p class="text-sm text-red-600 font-semibold mb-1">Absent</p>
            <p class="text-3xl font-bold text-red-700">{{ $stats['absent'] }}</p>
        </div>
    </div>
    
    <!-- Attendance Table -->
    <div class="card">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Attendance Records</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendances as $attendance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                {{ $attendance->date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $attendance->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $attendance->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $attendance->user->employee_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $attendance->status === 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $attendance->status === 'absent' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                @if($attendance->check_in && $attendance->check_out)
                                    @php
                                        $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                        $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                        $duration = $checkIn->diff($checkOut);
                                    @endphp
                                    {{ $duration->h }}h {{ $duration->i }}m
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No attendance records found for the selected period
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $attendances->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection