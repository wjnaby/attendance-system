@extends('layouts.app')

@section('title', 'Attendance Confirmed')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-xl mx-auto">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 text-center">
            <!-- Success Animation -->
            <div class="relative mb-6">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-xl animate-bounce-slow">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="absolute inset-0 w-24 h-24 mx-auto bg-green-400 rounded-full animate-ping opacity-20"></div>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                @if($action === 'check_in')
                    Check-In Successful!
                @else
                    Check-Out Successful!
                @endif
            </h1>
            
            <p class="text-gray-600 mb-6">
                @if($action === 'check_in')
                    You have successfully checked in for today.
                @else
                    You have successfully checked out. Have a great day!
                @endif
            </p>

            <!-- Time and Status Info -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Time</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $time }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Status</p>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                            @if($status === 'present' || $status === 'completed')
                                bg-green-100 text-green-700
                            @elseif($status === 'late')
                                bg-amber-100 text-amber-700
                            @else
                                bg-gray-100 text-gray-700
                            @endif
                        ">
                            @if($status === 'present')
                                On Time
                            @elseif($status === 'late')
                                Late Arrival
                            @elseif($status === 'completed')
                                Day Completed
                            @else
                                {{ ucfirst($status) }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Date Info -->
            <div class="flex items-center justify-center gap-2 text-gray-500 mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ now()->format('l, F j, Y') }}</span>
            </div>

            <!-- Confirmation Button -->
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-3 w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl font-semibold shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 transform hover:scale-[1.02] group">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Got it! Go to Dashboard</span>
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 grid grid-cols-2 gap-4">
            <a href="{{ route('history') }}" class="bg-white rounded-xl shadow-md p-4 border border-gray-100 hover:shadow-lg transition-all duration-200 group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">View History</p>
                        <p class="text-xs text-gray-500">See all records</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('leave-requests.index') }}" class="bg-white rounded-xl shadow-md p-4 border border-gray-100 hover:shadow-lg transition-all duration-200 group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Leave Requests</p>
                        <p class="text-xs text-gray-500">Manage leaves</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Employee Info -->
        <div class="mt-6 bg-white rounded-xl shadow-md p-4 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500">{{ auth()->user()->employee_id ?? 'Employee' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}
.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
}
</style>
@endsection
