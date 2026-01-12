@extends('layouts.app')

@section('title', 'Leave Requests')

@section('content')
<div class="space-y-6">
    <div class="card">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">My Leave Requests</h1>
            <a href="{{ route('leave-requests.create') }}" class="btn-primary">
                ➕ Request Leave
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leaveRequests as $leave)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    {{ ucfirst($leave->leave_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $leave->start_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $leave->end_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $leave->getDaysCount() }} days</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $leave->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $leave->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $leave->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($leave->status === 'pending')
                                    <form method="POST" action="{{ route('leave-requests.destroy', $leave) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold"
                                                onclick="return confirm('Are you sure you want to cancel this request?')">
                                            Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @if($leave->status === 'rejected' && $leave->admin_notes)
                            <tr>
                                <td colspan="7" class="px-6 py-2 bg-red-50">
                                    <p class="text-sm text-red-700"><strong>Admin Notes:</strong> {{ $leave->admin_notes }}</p>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No leave requests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $leaveRequests->links() }}
        </div>
    </div>
</div>
@endsection