@extends('layouts.app')

@section('title', 'Attendance Reports')

@section('content')
<div id="attendanceApp" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <h1 class="text-3xl font-semibold text-gray-900">Attendance Reports</h1>
            <div class="flex items-center space-x-3">
                <!-- Quick Actions -->
                <button @click="showQuickActions = !showQuickActions" class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Actions
                </button>
            </div>
        </div>
        <p class="text-sm text-gray-500">Track and analyze employee attendance records</p>
    </div>

    <!-- Quick Actions Dropdown -->
    <div v-show="showQuickActions" class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <button @click="setDateRange('today')" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Today
            </button>
            <button @click="setDateRange('week')" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                This Week
            </button>
            <button @click="setDateRange('month')" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                This Month
            </button>
            <button @click="setDateRange('year')" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                This Year
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('admin.reports') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input 
                        type="date" 
                        name="start_date" 
                        value="{{ $startDate }}"
                        v-model="startDate"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input 
                        type="date" 
                        name="end_date" 
                        value="{{ $endDate }}"
                        v-model="endDate"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200"
                    >
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Apply Filter
                    </button>
                </div>
                
                <div class="flex items-end">
                    <a href="{{ route('admin.export.pdf') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-slate-700 text-white text-sm font-medium rounded-lg hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Records</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-gray-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Present</p>
                    <p class="text-3xl font-semibold text-emerald-600">{{ $stats['present'] }}</p>
                </div>
                <div class="bg-emerald-50 rounded-full p-3">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Late</p>
                    <p class="text-3xl font-semibold text-amber-600">{{ $stats['late'] }}</p>
                </div>
                <div class="bg-amber-50 rounded-full p-3">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Absent</p>
                    <p class="text-3xl font-semibold text-rose-600">{{ $stats['absent'] }}</p>
                </div>
                <div class="bg-rose-50 rounded-full p-3">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Attendance Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Attendance Records</h2>
            <p class="mt-1 text-sm text-gray-500">Detailed view of all attendance entries</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee ID</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendances as $attendance)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">{{ $attendance->date->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">{{ strtoupper(substr($attendance->user->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $attendance->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $attendance->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700">{{ $attendance->user->employee_id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700">
                                    {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700">
                                    {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                    {{ $attendance->status === 'present' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '' }}
                                    {{ $attendance->status === 'late' ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                                    {{ $attendance->status === 'absent' ? 'bg-rose-100 text-rose-700 border border-rose-200' : '' }}
                                ">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700">
                                    @if($attendance->check_in && $attendance->check_out)
                                        @php
                                            $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                            $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                            $duration = $checkIn->diff($checkOut);
                                        @endphp
                                        {{ $duration->h }}h {{ $duration->i }}m
                                    @else
                                        —
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-4 text-sm font-medium text-gray-900">No attendance records found</p>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your date filter to see more results</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($attendances->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $attendances->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            showQuickActions: false,
            startDate: '{{ $startDate }}',
            endDate: '{{ $endDate }}'
        }
    },
    methods: {
        setDateRange(range) {
            const today = new Date();
            let start, end;
            
            switch(range) {
                case 'today':
                    start = end = this.formatDate(today);
                    break;
                case 'week':
                    const weekStart = new Date(today);
                    weekStart.setDate(today.getDate() - today.getDay());
                    start = this.formatDate(weekStart);
                    end = this.formatDate(today);
                    break;
                case 'month':
                    const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                    start = this.formatDate(monthStart);
                    end = this.formatDate(today);
                    break;
                case 'year':
                    const yearStart = new Date(today.getFullYear(), 0, 1);
                    start = this.formatDate(yearStart);
                    end = this.formatDate(today);
                    break;
            }
            
            this.startDate = start;
            this.endDate = end;
            this.showQuickActions = false;
        },
        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    }
}).mount('#attendanceApp');
</script>
@endsection