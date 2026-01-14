@extends('layouts.app')

@section('title', 'Scan QR Code')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">Scan Workplace QR</h1>
                <p class="text-gray-600">Point your camera at the workplace QR code to check in or check out</p>
            </div>
        </div>

        <!-- QR Scanner Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <qr-scanner></qr-scanner>
        </div>
        
        <!-- Today's Status Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Today's Attendance Status
            </h3>
            @php
                $todayAttendance = \App\Models\Attendance::where('user_id', auth()->id())
                    ->where('date', \Carbon\Carbon::today())
                    ->first();
            @endphp
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-500 text-sm mb-1">Check In</p>
                    <p class="text-xl font-semibold {{ $todayAttendance && $todayAttendance->check_in ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $todayAttendance && $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : '--:--' }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-500 text-sm mb-1">Check Out</p>
                    <p class="text-xl font-semibold {{ $todayAttendance && $todayAttendance->check_out ? 'text-red-600' : 'text-gray-400' }}">
                        {{ $todayAttendance && $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') : '--:--' }}
                    </p>
                </div>
            </div>
            @if($todayAttendance && $todayAttendance->check_in && $todayAttendance->check_out)
                <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                    <p class="text-green-700 font-medium">You have completed attendance for today!</p>
                </div>
            @elseif($todayAttendance && $todayAttendance->check_in)
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                    <p class="text-blue-700 font-medium">You're checked in. Scan again to check out.</p>
                </div>
            @else
                <div class="mt-4 bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                    <p class="text-amber-700 font-medium">You haven't checked in yet today.</p>
                </div>
            @endif
        </div>

        <!-- Back to Dashboard -->
        <div class="text-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-medium hover:bg-gray-200 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection