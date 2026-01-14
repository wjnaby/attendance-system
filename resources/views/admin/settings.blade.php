@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8" id="settings-app">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 mb-1">System Settings</h1>
                <p class="text-gray-500 text-sm">Manage attendance system configuration</p>
            </div>
            <div class="flex gap-2">
                <button @click="resetToDefaults" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                    Reset to Defaults
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <button @click="setWorkingHours('09:00', '17:00')" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-left transition-all duration-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 text-sm">Standard Hours</h3>
                    <p class="text-xs text-gray-500">9:00 AM - 5:00 PM</p>
                </div>
            </div>
        </button>

        <button @click="setWorkingHours('08:00', '16:00')" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-left transition-all duration-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 text-sm">Early Shift</h3>
                    <p class="text-xs text-gray-500">8:00 AM - 4:00 PM</p>
                </div>
            </div>
        </button>

        <button @click="setLateThreshold(15)" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-left transition-all duration-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 text-sm">Quick Grace</h3>
                    <p class="text-xs text-gray-500">15 min threshold</p>
                </div>
            </div>
        </button>
    </div>

    <!-- Main Settings Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Working Hours Configuration</h2>
        
        <form method="POST" action="{{ route('admin.settings.update') }}" @submit="handleSubmit">
            @csrf
            
            <div class="space-y-6">
                <!-- Check-in Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="check_in_time">
                        Official Check-In Time
                    </label>
                    <input 
                        type="time" 
                        name="check_in_time" 
                        id="check_in_time" 
                        v-model="checkInTime"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-900"
                        required
                    >
                    <p class="text-xs text-gray-500 mt-1.5">Expected arrival time for employees</p>
                </div>
                
                <!-- Check-out Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="check_out_time">
                        Official Check-Out Time
                    </label>
                    <input 
                        type="time" 
                        name="check_out_time" 
                        id="check_out_time" 
                        v-model="checkOutTime"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-900"
                        required
                    >
                    <p class="text-xs text-gray-500 mt-1.5">Expected departure time for employees</p>
                </div>
                
                <!-- Late Threshold -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="late_threshold_minutes">
                        Late Threshold (Minutes)
                    </label>
                    <div class="flex items-center gap-4">
                        <input 
                            type="range" 
                            v-model="lateThreshold"
                            min="0"
                            max="120"
                            step="5"
                            class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600"
                        >
                        <input 
                            type="number" 
                            name="late_threshold_minutes" 
                            id="late_threshold_minutes" 
                            v-model="lateThreshold"
                            class="w-24 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-900 text-center"
                            min="0"
                            max="120"
                            required
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1.5">Grace period before marking as late (0-120 minutes)</p>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="mt-6 bg-gradient-to-br from-slate-50 to-gray-50 border border-gray-200 rounded-lg p-5">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 text-sm mb-2">Configuration Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-600">Check-in:</span>
                                <span class="font-medium text-gray-900">@{{ checkInTime }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-600">Check-out:</span>
                                <span class="font-medium text-gray-900">@{{ checkOutTime }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-600">Late after:</span>
                                <span class="font-medium text-gray-900">@{{ lateAfterTime }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-600">Grace period:</span>
                                <span class="font-medium text-gray-900">@{{ lateThreshold }} min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="mt-6 flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Settings
                </button>
                <button type="button" @click="cancelChanges" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            checkInTime: '{{ $settings["check_in_time"] }}',
            checkOutTime: '{{ $settings["check_out_time"] }}',
            lateThreshold: {{ $settings['late_threshold_minutes'] }},
            originalSettings: {
                checkInTime: '{{ $settings["check_in_time"] }}',
                checkOutTime: '{{ $settings["check_out_time"] }}',
                lateThreshold: {{ $settings['late_threshold_minutes'] }}
            }
        };
    },
    computed: {
        lateAfterTime() {
            if (!this.checkInTime) return '--:--';
            const [hours, minutes] = this.checkInTime.split(':').map(Number);
            const totalMinutes = hours * 60 + minutes + parseInt(this.lateThreshold);
            const newHours = Math.floor(totalMinutes / 60) % 24;
            const newMinutes = totalMinutes % 60;
            return `${String(newHours).padStart(2, '0')}:${String(newMinutes).padStart(2, '0')}`;
        }
    },
    methods: {
        setWorkingHours(checkIn, checkOut) {
            this.checkInTime = checkIn;
            this.checkOutTime = checkOut;
        },
        setLateThreshold(minutes) {
            this.lateThreshold = minutes;
        },
        resetToDefaults() {
            if (confirm('Reset to default settings (9:00 AM - 5:00 PM, 15 min grace)?')) {
                this.checkInTime = '09:00';
                this.checkOutTime = '17:00';
                this.lateThreshold = 15;
            }
        },
        cancelChanges() {
            this.checkInTime = this.originalSettings.checkInTime;
            this.checkOutTime = this.originalSettings.checkOutTime;
            this.lateThreshold = this.originalSettings.lateThreshold;
        },
        handleSubmit(e) {
            // Form will submit normally, this is just for potential validation
            return true;
        }
    }
}).mount('#settings-app');
</script>
@endsection