@extends('layouts.app')

@section('title', 'Request Leave')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Request Leave</h1>
        
        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('leave-requests.store') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="leave_type">
                    Leave Type
                </label>
                <select name="leave_type" id="leave_type" class="input-field" required>
                    <option value="">Select Leave Type</option>
                    <option value="sick" {{ old('leave_type') === 'sick' ? 'selected' : '' }}>Sick Leave</option>
                    <option value="vacation" {{ old('leave_type') === 'vacation' ? 'selected' : '' }}>Vacation</option>
                    <option value="personal" {{ old('leave_type') === 'personal' ? 'selected' : '' }}>Personal Leave</option>
                    <option value="emergency" {{ old('leave_type') === 'emergency' ? 'selected' : '' }}>Emergency Leave</option>
                    <option value="other" {{ old('leave_type') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">
                        Start Date
                    </label>
                    <input 
                        type="date" 
                        name="start_date" 
                        id="start_date" 
                        value="{{ old('start_date') }}"
                        min="{{ date('Y-m-d') }}"
                        class="input-field"
                        required
                    >
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="end_date">
                        End Date
                    </label>
                    <input 
                        type="date" 
                        name="end_date" 
                        id="end_date" 
                        value="{{ old('end_date') }}"
                        min="{{ date('Y-m-d') }}"
                        class="input-field"
                        required
                    >
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="reason">
                    Reason (minimum 10 characters)
                </label>
                <textarea 
                    name="reason" 
                    id="reason" 
                    rows="4"
                    class="input-field"
                    required
                    minlength="10"
                >{{ old('reason') }}</textarea>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="btn-primary flex-1">
                    Submit Request
                </button>
                <a href="{{ route('leave-requests.index') }}" class="btn-secondary flex-1 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection