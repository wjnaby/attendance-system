@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100" id="dashboard-app">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Welcome Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-slate-800 mb-1">
                Welcome back, {{ auth()->user()->name }}
            </h1>
            <p class="text-slate-500 text-sm">
                {{ now()->format('l, F j, Y') }} • Employee ID: {{ auth()->user()->employee_id }}
            </p>
        </div>
        
        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Left Column - Attendance Cards -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Today's Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Today's Summary</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Check-In -->
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-600">Check-In</span>
                            </div>
                            <p class="text-2xl font-semibold text-slate-800">
                                {{ $todayAttendance && $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : '--:--' }}
                            </p>
                        </div>
                        
                        <!-- Check-Out -->
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-600">Check-Out</span>
                            </div>
                            <p class="text-2xl font-semibold text-slate-800">
                                {{ $todayAttendance && $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') : '--:--' }}
                            </p>
                        </div>
                        
                        <!-- Status -->
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-violet-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-600">Status</span>
                            </div>
                            <p class="text-2xl font-semibold capitalize
                                {{ $todayAttendance && $todayAttendance->status === 'present' ? 'text-emerald-600' : '' }}
                                {{ $todayAttendance && $todayAttendance->status === 'late' ? 'text-amber-600' : '' }}
                                {{ !$todayAttendance || $todayAttendance->status === 'absent' ? 'text-rose-600' : '' }}
                            ">
                                {{ $todayAttendance ? $todayAttendance->status : 'Absent' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Attendance Table -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-800">Recent Attendance</h2>
                        <a href="{{ route('history') }}" class="text-sm font-medium text-slate-600 hover:text-slate-800 flex items-center gap-1 transition-colors">
                            View all
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Check In</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Check Out</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($recentAttendances as $attendance)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-slate-800">{{ $attendance->date->format('M d, Y') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-slate-600">
                                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-slate-600">
                                                {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                                {{ $attendance->status === 'present' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                                                {{ $attendance->status === 'late' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                                                {{ $attendance->status === 'absent' ? 'bg-rose-50 text-rose-700 border border-rose-200' : '' }}
                                            ">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="mt-3 text-sm text-slate-500">No attendance records found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Quick Actions -->
            <div class="space-y-6">
                <!-- Quick Actions Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Quick Actions</h2>
                    
                    <div class="space-y-3">
                        <!-- Scan QR Button -->
                        <a href="{{ route('qr.scan') }}" class="group block bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg p-4 text-white hover:from-slate-800 hover:to-slate-900 transition-all shadow-sm hover:shadow-md">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium mb-0.5">Scan QR Code</p>
                                    <p class="text-xs text-slate-300">Check in/out at workplace</p>
                                </div>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                        
                        <!-- Leave Request Button -->
                        <a href="{{ route('leave-requests.index') }}" class="group block bg-gradient-to-br from-slate-600 to-slate-700 rounded-lg p-4 text-white hover:from-slate-700 hover:to-slate-800 transition-all shadow-sm hover:shadow-md">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium mb-0.5">Leave Requests</p>
                                    <p class="text-xs text-slate-300">Manage time off requests</p>
                                </div>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                        
                        <!-- View History Button -->
                        <button @click="showHistory = !showHistory" class="group w-full block bg-slate-100 hover:bg-slate-200 rounded-lg p-4 text-slate-700 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-slate-200 group-hover:bg-slate-300 rounded-lg flex items-center justify-center transition-colors">
                                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 text-left">
                                    <p class="font-medium mb-0.5">View History</p>
                                    <p class="text-xs text-slate-500">See full attendance history</p>
                                </div>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </button>
                        

                    </div>
                </div>
                
                <!-- Stats Card -->
                <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl shadow-sm p-6 text-white">
                    <h3 class="text-sm font-medium text-slate-300 mb-4">This Month</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-300">Present Days</span>
                            <span class="text-lg font-semibold">{{ $monthlyStats['present'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-300">Late Arrivals</span>
                            <span class="text-lg font-semibold">{{ $monthlyStats['late'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-300">Leave Taken</span>
                            <span class="text-lg font-semibold">{{ $monthlyStats['leave'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            showHistory: false
        }
    },
    methods: {
        // Add methods here as needed
    }
}).mount('#dashboard-app');
</script>
@endpush
@endsection