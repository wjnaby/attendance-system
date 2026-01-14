<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Storage;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.leave-requests.index', compact('leaveRequests'));
    }
    
    public function create()
    {
        return view('user.leave-requests.create');
    }
    
    public function store(Request $request)
    {
        $rules = [
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_type' => 'required|in:sick,vacation,personal,emergency,other',
            'reason' => 'required|string|min:10',
        ];
        
        // Require MC document for sick leave
        if ($request->leave_type === 'sick') {
            $rules['mc_document'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }
        
        $validated = $request->validate($rules);
        
        $validated['user_id'] = auth()->id();
        
        // Handle file upload
        if ($request->hasFile('mc_document')) {
            $file = $request->file('mc_document');
            $filename = 'mc_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('mc_documents', $filename, 'public');
            $validated['mc_document'] = $path;
        }
        
        $leaveRequest = LeaveRequest::create($validated);
        
        AuditLog::log(
            'leave_request_created',
            'Leave request submitted from ' . $leaveRequest->start_date->format('M d') . ' to ' . $leaveRequest->end_date->format('M d'),
            $leaveRequest
        );
        
        return redirect()->route('leave-requests.index')
            ->with('success', 'Leave request submitted successfully');
    }
    
    public function destroy(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->user_id !== auth()->id()) {
            abort(403);
        }
        
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Cannot delete approved/rejected leave requests');
        }
        
        AuditLog::log(
            'leave_request_deleted',
            'Leave request cancelled',
            $leaveRequest
        );
        
        $leaveRequest->delete();
        
        return redirect()->route('leave-requests.index')
            ->with('success', 'Leave request cancelled');
    }
}