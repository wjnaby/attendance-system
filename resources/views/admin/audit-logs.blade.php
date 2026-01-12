@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="space-y-6">
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Audit Logs</h1>
        <p class="text-gray-600">Track all system activities and changes</p>
    </div>
    
    <!-- Filters -->
    <div class="card">
        <form method="GET" action="{{ route('admin.audit-logs') }}" class="grid md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Action Type</label>
                <select name="action" class="input-field">
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
                    class="input-field"
                >
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input 
                    type="date" 
                    name="end_date" 
                    value="{{ request('end_date') }}"
                    class="input-field"
                >
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">
                    🔍 Filter
                </button>
            </div>
        </form>
    </div>
    
    <!-- Logs Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->created_at->format('M d, Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->user)
                                    <div class="text-sm font-medium text-gray-900">{{ $log->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $log->user->employee_id }}</div>
                                @else
                                    <span class="text-gray-400">System</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ str_contains($log->action, 'check_in') ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ str_contains($log->action, 'check_out') ? 'bg-green-100 text-green-800' : '' }}
                                    {{ str_contains($log->action, 'leave') ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ str_contains($log->action, 'settings') ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ str_contains($log->action, 'approved') ? 'bg-green-100 text-green-800' : '' }}
                                    {{ str_contains($log->action, 'rejected') ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->ip_address }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No audit logs found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection