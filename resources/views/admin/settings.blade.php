@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">System Settings</h1>
        <p class="text-gray-600">Configure attendance system parameters</p>
    </div>
    
    <div class="card">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Working Hours Configuration</h2>
        
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_in_time">
                    Official Check-In Time
                </label>
                <input 
                    type="time" 
                    name="check_in_time" 
                    id="check_in_time" 
                    value="{{ $settings['check_in_time'] }}"
                    class="input-field"
                    required
                >
                <p class="text-sm text-gray-500 mt-1">Employees should check in by this time</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_out_time">
                    Official Check-Out Time
                </label>
                <input 
                    type="time" 
                    name="check_out_time" 
                    id="check_out_time" 
                    value="{{ $settings['check_out_time'] }}"
                    class="input-field"
                    required
                >
                <p class="text-sm text-gray-500 mt-1">Expected check-out time for employees</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="late_threshold_minutes">
                    Late Threshold (Minutes)
                </label>
                <input 
                    type="number" 
                    name="late_threshold_minutes" 
                    id="late_threshold_minutes" 
                    value="{{ $settings['late_threshold_minutes'] }}"
                    class="input-field"
                    min="0"
                    max="120"
                    required
                >
                <p class="text-sm text-gray-500 mt-1">Grace period before marking attendance as late (0-120 minutes)</p>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2">Current Configuration Summary:</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Check-in time: <strong>{{ $settings['check_in_time'] }}</strong></li>
                    <li>• Late after: <strong>{{ \Carbon\Carbon::parse($settings['check_in_time'])->addMinutes($settings['late_threshold_minutes'])->format('H:i') }}</strong></li>
                    <li>• Check-out time: <strong>{{ $settings['check_out_time'] }}</strong></li>
                </ul>
            </div>
            
            <button type="submit" class="btn-primary w-full py-3">
                💾 Save Settings
            </button>
        </form>
    </div>
</div>
@endsection