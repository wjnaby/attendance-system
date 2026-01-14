@extends('layouts.app')

@section('title', 'Leave Requests Management')

@section('content')
<div class="space-y-6">
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800">Leave Requests Management</h1>
        <p class="text-gray-600 mt-2">Review and approve employee leave requests</p>
    </div>
    
    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leaveRequests as $leave)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ substr($leave->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $leave->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $leave->user->employee_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    {{ ucfirst($leave->leave_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $leave->getDaysCount() }}</td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700 max-w-xs truncate" title="{{ $leave->reason }}">
                                    {{ $leave->reason }}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($leave->mc_document)
                                    <a href="{{ asset('storage/' . $leave->mc_document) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        View MC
                                    </a>
                                @elseif($leave->leave_type === 'sick')
                                    <span class="inline-flex items-center gap-1 text-amber-600 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        No MC
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $leave->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $leave->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($leave->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.leave.approve', $leave) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 font-semibold">
                                                ✓ Approve
                                            </button>
                                        </form>
                                        
                                        <button 
                                            onclick="showRejectModal({{ $leave->id }})" 
                                            class="text-red-600 hover:text-red-800 font-semibold"
                                        >
                                            ✗ Reject
                                        </button>
                                    </div>
                                @else
                                    <span class="text-gray-400">
                                        {{ $leave->status === 'approved' ? 'Approved' : 'Rejected' }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
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

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Leave Request</h3>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="admin_notes">
                        Reason for Rejection (Optional)
                    </label>
                    <textarea 
                        name="admin_notes" 
                        id="admin_notes" 
                        rows="3"
                        class="input-field"
                        placeholder="Provide a reason for rejection..."
                    ></textarea>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="btn-danger flex-1">
                        Reject Request
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="btn-secondary flex-1">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(leaveId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/leave-requests/${leaveId}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('admin_notes').value = '';
}
</script>
@endsection