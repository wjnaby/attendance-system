@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600">Employee ID: {{ auth()->user()->employee_id }}</p>
        <p class="text-gray-600">Today is {{ now()->format('l, F j, Y') }}</p>
    </div>
    
    <!-- Today's Attendance Status -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <h3 class="text-lg font-semibold mb-2">Check-In Time</h3>
            <p class="text-3xl font-bold">
                {{ $todayAttendance && $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : 'Not Checked In' }}
            </p>
        </div>
        
        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <h3 class="text-lg font-semibold mb-2">Check-Out Time</h3>
            <p class="text-3xl font-bold">
                {{ $todayAttendance && $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') : 'Not Checked Out' }}
            </p>
        </div>
        
        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <h3 class="text-lg font-semibold mb-2">Status</h3>
            <p class="text-3xl font-bold capitalize">
                {{ $todayAttendance ? $todayAttendance->status : 'Absent' }}
            </p>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <a href="{{ route('qr.show') }}" class="btn-primary text-center py-4 text-lg">
                📱 Show My QR Code
            </a>
            <a href="{{ route('qr.scan') }}" class="btn-success text-center py-4 text-lg">
                📷 Scan QR Code
            </a>
        </div>
    </div>
    
    <!-- Recent Attendance -->
    <div class="card">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Attendance</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentAttendances as $attendance)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No attendance records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('history') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                View Full History →
            </a>
        </div>
    </div>
</div>
@endsection