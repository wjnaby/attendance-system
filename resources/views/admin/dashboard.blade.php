@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 p-6" id="dashboardApp">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        Admin Dashboard
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ now()->format('l, F j, Y') }}
                    </p>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-xl shadow-lg">
                        <div class="text-xs opacity-90 mb-1">Active Users</div>
                        <div class="text-2xl font-bold">{{ $presentToday }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                <!-- QR Code Button -->
                <a href="{{ route('admin.qr') }}" class="quick-action-card group flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg hover:border-blue-300 hover:shadow-sm transition-all duration-200">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">QR Code</p>
                        <p class="text-xs text-gray-500 truncate">Attendance scan</p>
                    </div>
                </a>

                <!-- Add User Button -->
                <a href="{{ route('admin.users') }}" class="quick-action-card group flex items-center gap-3 px-4 py-3 bg-white border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Add User</p>
                        <p class="text-xs text-gray-500 truncate">New employee</p>
                    </div>
                </a>

                <!-- View Reports Button -->
                <a href="{{ route('admin.reports') }}" class="quick-action-card group flex items-center gap-3 px-4 py-3 bg-white border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Reports</p>
                        <p class="text-xs text-gray-500 truncate">View analytics</p>
                    </div>
                </a>

                <!-- Manage Leaves Button -->
                <a href="{{ route('admin.leave-requests') }}" class="quick-action-card group flex items-center gap-3 px-4 py-3 bg-white border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Leave Requests</p>
                        <p class="text-xs text-gray-500 truncate">Approve/Reject</p>
                    </div>
                </a>

                <!-- System Settings Button -->
                <a href="{{ route('admin.settings') }}" class="quick-action-card group flex items-center gap-3 px-4 py-3 bg-white border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Settings</p>
                        <p class="text-xs text-gray-500 truncate">Configure system</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Employees Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Employees</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    <p class="text-xs text-gray-500 mt-1">Registered users</p>
                </div>
            </div>
            
            <!-- Present Today Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Present Today</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $presentToday }}</p>
                    <p class="text-xs text-gray-500 mt-1">Active attendance</p>
                </div>
            </div>
            
            <!-- Late Today Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Late Today</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $lateToday }}</p>
                    <p class="text-xs text-gray-500 mt-1">Late arrivals</p>
                </div>
            </div>
            
            <!-- Absent Today Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Absent Today</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $absentToday }}</p>
                    <p class="text-xs text-gray-500 mt-1">Not present</p>
                </div>
            </div>
        </div>
        
        <!-- Attendance Chart -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Attendance Chart</h2>
            <div class="flex items-end justify-center gap-8 h-48">
                <!-- Present Bar -->
                <div class="flex flex-col items-center">
                    <span class="text-sm font-semibold text-gray-700 mb-2">{{ $presentToday }}</span>
                    <div class="w-16 bg-emerald-200 rounded-t-md transition-all duration-500" 
                         style="height: {{ $totalUsers > 0 ? ($presentToday / $totalUsers * 140) : 0 }}px; min-height: 4px;"></div>
                    <span class="text-xs text-gray-500 mt-2">Present</span>
                </div>
                <!-- Late Bar -->
                <div class="flex flex-col items-center">
                    <span class="text-sm font-semibold text-gray-700 mb-2">{{ $lateToday }}</span>
                    <div class="w-16 bg-amber-200 rounded-t-md transition-all duration-500" 
                         style="height: {{ $totalUsers > 0 ? ($lateToday / $totalUsers * 140) : 0 }}px; min-height: 4px;"></div>
                    <span class="text-xs text-gray-500 mt-2">Late</span>
                </div>
                <!-- Absent Bar -->
                <div class="flex flex-col items-center">
                    <span class="text-sm font-semibold text-gray-700 mb-2">{{ $absentToday }}</span>
                    <div class="w-16 bg-red-200 rounded-t-md transition-all duration-500" 
                         style="height: {{ $totalUsers > 0 ? ($absentToday / $totalUsers * 140) : 0 }}px; min-height: 4px;"></div>
                    <span class="text-xs text-gray-500 mt-2">Absent</span>
                </div>
            </div>
        </div>
        
        <!-- Today's Attendance List -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-slate-600 p-5">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-white mb-1">Today's Attendance</h2>
                        <p class="text-slate-300 text-sm">Real-time attendance tracking</p>
                    </div>
                    <a href="{{ route('admin.reports') }}" class="group flex items-center gap-2 bg-white text-slate-600 px-4 py-2 rounded-lg font-medium shadow hover:shadow-md transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        View Full Reports
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Check In</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Check Out</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($recentAttendances as $attendance)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-9 w-9 rounded-lg bg-slate-500 flex items-center justify-center text-white font-medium text-sm">
                                            {{ substr($attendance->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-800">{{ $attendance->user->name }}</div>
                                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $attendance->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-gray-600 bg-gray-100 px-2 py-0.5 rounded">
                                        {{ $attendance->user->employee_id }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                        <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                        <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-medium
                                        {{ $attendance->status === 'present' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $attendance->status === 'late' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $attendance->status === 'absent' ? 'bg-red-100 text-red-700' : '' }}
                                    ">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="bg-gray-100 rounded-full p-4">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-medium text-gray-600 mb-1">No attendance records yet</p>
                                            <p class="text-sm text-gray-400">Attendance records will appear here once employees check in</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Vue.js Enhancement Script -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            stats: {
                present: {{ $presentToday }},
                late: {{ $lateToday }},
                absent: {{ $absentToday }},
                total: {{ $totalUsers }}
            }
        }
    },
    mounted() {
        this.animateCards();
    },
    methods: {
        animateCards() {
            const cards = document.querySelectorAll('.quick-action-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }
    }
}).mount('#dashboardApp');
</script>
@endsection