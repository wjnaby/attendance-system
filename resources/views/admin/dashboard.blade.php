@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600">Overview of today's attendance - {{ now()->format('l, F j, Y') }}</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid md:grid-cols-4 gap-6">
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80 mb-1">Total Employees</p>
                    <p class="text-4xl font-bold">{{ $totalUsers }}</p>
                </div>
                <div class="text-5xl opacity-80">👥</div>
            </div>
        </div>
        
        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80 mb-1">Present Today</p>
                    <p class="text-4xl font-bold">{{ $presentToday }}</p>
                </div>
                <div class="text-5xl opacity-80">✅</div>
            </div>
        </div>
        
        <div class="card bg-gradient-to-br from-yellow-500 to-yellow-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80 mb-1">Late Today</p>
                    <p class="text-4xl font-bold">{{ $lateToday }}</p>
                </div>
                <div class="text-5xl opacity-80">⏰</div>
            </div>
        </div>
        
        <div class="card bg-gradient-to-br from-red-500 to-red-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80 mb-1">Absent Today</p>
                    <p class="text-4xl font-bold">{{ $absentToday }}</p>
                </div>
                <div class="text-5xl opacity-80">❌</div>
            </div>
        </div>
    </div>
    
    <!-- Attendance Chart -->
    <div class="card">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Attendance Overview</h2>
        <attendance-chart
            :present="{{ $presentToday }}"
            :late="{{ $lateToday }}"
            :absent="{{ $absentToday }}"
        ></attendance-chart>
    </div>
    
    <!-- Today's Attendance List -->
    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Today's Attendance</h2>
            <a href="{{ route('admin.reports') }}" class="btn-primary">
                📊 View Full Reports
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentAttendances as $attendance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ substr($attendance->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $attendance->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $attendance->user->email }}</div>
                                    </div>
                                </div>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No attendance records for today
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection