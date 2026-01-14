@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div id="auditApp" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Audit Logs</h1>
                <p class="mt-1 text-sm text-gray-500">Track all system activities and changes</p>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Quick Actions -->
                <button @click="showQuickFilters = !showQuickFilters" class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Filters
                </button>
                <button @click="exportLogs" class="inline-flex items-center px-4 py-2.5 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Logs
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Filters Dropdown -->
    <div v-show="showQuickFilters" class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <button @click="setTimeRange('today')" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Today
            </button>
            <button @click="setTimeRange('week')" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Last 7 Days
            </button>
            <button @click="setTimeRange('month')" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Last 30 Days
            </button>
            <button @click="setTimeRange('all')" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                All Time
            </button>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Logs</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $logs->total() }}</p>
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
                    <p class="text-sm font-medium text-gray-500 mb-1">Today's Activity</p>
                    <p class="text-3xl font-semibold text-blue-600">
                        @php
                            $todayLogs = $logs->filter(function($log) {
                                return $log->created_at->isToday();
                            })->count();
                        @endphp
                        {{ $todayLogs }}
                    </p>
                </div>
                <div class="bg-blue-50 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Unique Users</p>
                    <p class="text-3xl font-semibold text-violet-600">
                        @php
                            $uniqueUsers = $logs->pluck('user_id')->unique()->count();
                        @endphp
                        {{ $uniqueUsers }}
                    </p>
                </div>
                <div class="bg-violet-50 rounded-full p-3">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Action Types</p>
                    <p class="text-3xl font-semibold text-emerald-600">{{ count($actions) }}</p>
                </div>
                <div class="bg-emerald-50 rounded-full p-3">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('admin.audit-logs') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Action Type</label>
                    <select 
                        name="action" 
                        v-model="selectedAction"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200"
                    >
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $action)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input 
                        type="date" 
                        name="start_date" 
                        value="{{ request('start_date') }}"
                        v-model="startDate"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input 
                        type="date" 
                        name="end_date" 
                        value="{{ request('end_date') }}"
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
            </div>
        </form>
    </div>
    
    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Activity Log</h2>
            <p class="mt-1 text-sm text-gray-500">Comprehensive history of all system activities</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Timestamp</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP Address</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->user)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-9 w-9 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600">{{ strtoupper(substr($log->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $log->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $log->user->employee_id }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-9 w-9 bg-slate-200 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <span class="text-sm text-gray-500">System</span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                    {{ str_contains($log->action, 'check_in') ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                                    {{ str_contains($log->action, 'check_out') ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '' }}
                                    {{ str_contains($log->action, 'leave') ? 'bg-violet-100 text-violet-700 border border-violet-200' : '' }}
                                    {{ str_contains($log->action, 'settings') ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                                    {{ str_contains($log->action, 'approved') ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '' }}
                                    {{ str_contains($log->action, 'rejected') ? 'bg-rose-100 text-rose-700 border border-rose-200' : '' }}
                                    {{ !str_contains($log->action, 'check_in') && !str_contains($log->action, 'check_out') && !str_contains($log->action, 'leave') && !str_contains($log->action, 'settings') && !str_contains($log->action, 'approved') && !str_contains($log->action, 'rejected') ? 'bg-gray-100 text-gray-700 border border-gray-200' : '' }}
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700">{{ $log->description }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    {{ $log->ip_address }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button @click="viewLogDetails({{ $log->id }})" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-150">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-4 text-sm font-medium text-gray-900">No audit logs found</p>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your filters to see more results</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $logs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Log Details Modal -->
<div v-show="showLogModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div @click="showLogModal = false" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-6 pt-5 pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Log Details</h3>
                    <button @click="showLogModal = false" class="text-gray-400 hover:text-gray-500 transition-colors duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-gray-500">Detailed information about this audit log entry</p>
            </div>
            <div class="bg-gray-50 px-6 py-3">
                <button @click="showLogModal = false" class="w-full inline-flex justify-center px-4 py-2.5 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            showQuickFilters: false,
            showLogModal: false,
            selectedAction: '{{ request('action') }}',
            startDate: '{{ request('start_date') }}',
            endDate: '{{ request('end_date') }}'
        }
    },
    methods: {
        setTimeRange(range) {
            const today = new Date();
            let start, end;
            
            switch(range) {
                case 'today':
                    start = end = this.formatDate(today);
                    break;
                case 'week':
                    const weekAgo = new Date(today);
                    weekAgo.setDate(today.getDate() - 7);
                    start = this.formatDate(weekAgo);
                    end = this.formatDate(today);
                    break;
                case 'month':
                    const monthAgo = new Date(today);
                    monthAgo.setDate(today.getDate() - 30);
                    start = this.formatDate(monthAgo);
                    end = this.formatDate(today);
                    break;
                case 'all':
                    start = '';
                    end = '';
                    break;
            }
            
            this.startDate = start;
            this.endDate = end;
            this.showQuickFilters = false;
        },
        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
        exportLogs() {
            console.log('Exporting audit logs...');
            alert('Export functionality would be implemented here');
        },
        viewLogDetails(logId) {
            this.showLogModal = true;
            console.log('Viewing details for log:', logId);
        }
    },
    watch: {
        showLogModal(newVal) {
            if (newVal) {
                document.querySelector('[v-show="showLogModal"]').style.display = 'block';
            } else {
                document.querySelector('[v-show="showLogModal"]').style.display = 'none';
            }
        }
    }
}).mount('#auditApp');
</script>
@endsection