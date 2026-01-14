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
        
        <form method="POST" action="{{ route('leave-requests.store') }}" enctype="multipart/form-data">
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
            
            <!-- MC Document Upload (for Sick Leave) -->
            <div class="mb-6 hidden" id="mc_document_section">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="mc_document">
                    Medical Certificate (MC) <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors">
                    <input 
                        type="file" 
                        name="mc_document" 
                        id="mc_document" 
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="hidden"
                        onchange="updateFileName(this)"
                    >
                    <label for="mc_document" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-semibold text-indigo-600 hover:text-indigo-500">Click to upload</span> or drag and drop
                        </p>
                        <p class="mt-1 text-xs text-gray-500">PDF, JPG, JPEG, PNG (max. 5MB)</p>
                    </label>
                    <p id="file_name" class="mt-2 text-sm text-green-600 font-medium hidden"></p>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    <svg class="inline w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Medical certificate is required for sick leave requests.
                </p>
                @error('mc_document')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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

<script>
    // Show/hide MC document section based on leave type
    document.getElementById('leave_type').addEventListener('change', function() {
        const mcSection = document.getElementById('mc_document_section');
        const mcInput = document.getElementById('mc_document');
        
        if (this.value === 'sick') {
            mcSection.classList.remove('hidden');
            mcInput.setAttribute('required', 'required');
        } else {
            mcSection.classList.add('hidden');
            mcInput.removeAttribute('required');
            mcInput.value = '';
            document.getElementById('file_name').classList.add('hidden');
        }
    });
    
    // Update file name display
    function updateFileName(input) {
        const fileNameDisplay = document.getElementById('file_name');
        if (input.files && input.files[0]) {
            fileNameDisplay.textContent = 'Selected: ' + input.files[0].name;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameDisplay.classList.add('hidden');
        }
    }
    
    // Check if sick leave was previously selected (for validation errors)
    document.addEventListener('DOMContentLoaded', function() {
        const leaveType = document.getElementById('leave_type');
        if (leaveType.value === 'sick') {
            document.getElementById('mc_document_section').classList.remove('hidden');
            document.getElementById('mc_document').setAttribute('required', 'required');
        }
    });
</script>
@endsection