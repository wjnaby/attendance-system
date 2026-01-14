@extends('layouts.app')

@section('title', 'Workplace QR Code')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 p-6" id="qrCodeApp">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        Workplace QR Code
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $today }}
                    </p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- QR Code Display Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Scan for Attendance</h2>
                <p class="text-gray-600 mb-6">Display this QR code on the workplace screen for employees to scan</p>
                
                <!-- QR Code Container -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl inline-block shadow-inner" id="qr-container">
                    <div class="bg-white p-6 rounded-xl shadow-lg" id="qr-code">
                        {!! $qrCode !!}
                    </div>
                </div>

                <!-- Expiry Timer -->
                <div class="mt-6 flex items-center justify-center gap-3">
                    <div class="flex items-center gap-2 bg-amber-50 border border-amber-200 rounded-full px-4 py-2">
                        <svg class="w-5 h-5 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-amber-800 font-medium">Expires at: <span id="expires-at">{{ $expiresAt }}</span></span>
                    </div>
                </div>

                <!-- Countdown Timer -->
                <div class="mt-4">
                    <p class="text-gray-500 text-sm">Time remaining: <span id="countdown" class="font-mono font-semibold text-indigo-600">05:00</span></p>
                </div>

                <!-- Refresh Button -->
                <div class="mt-6">
                    <button onclick="refreshQrCode()" id="refresh-btn" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" id="refresh-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span id="refresh-text">Refresh QR Code</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Security Information -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Security Features</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            QR code changes daily to prevent unauthorized access
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Timestamp-based encryption prevents replay attacks
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            5-minute expiration with manual refresh option
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Each scan is logged in the audit trail
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Instructions Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Instructions for Employees
            </h3>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <p class="text-gray-700 font-medium">Login to Account</p>
                    <p class="text-gray-500 text-sm mt-1">Access the attendance system with your credentials</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-blue-600">2</span>
                    </div>
                    <p class="text-gray-700 font-medium">Navigate to Scan</p>
                    <p class="text-gray-500 text-sm mt-1">Go to the "Scan QR" option from the menu</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-blue-600">3</span>
                    </div>
                    <p class="text-gray-700 font-medium">Scan & Confirm</p>
                    <p class="text-gray-500 text-sm mt-1">Point camera at QR code and confirm attendance</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let countdownInterval;
    let remainingSeconds = 300; // 5 minutes

    function startCountdown() {
        updateCountdownDisplay();
        countdownInterval = setInterval(() => {
            remainingSeconds--;
            updateCountdownDisplay();
            
            if (remainingSeconds <= 0) {
                clearInterval(countdownInterval);
                document.getElementById('countdown').textContent = 'EXPIRED';
                document.getElementById('countdown').classList.add('text-red-600');
                document.getElementById('countdown').classList.remove('text-indigo-600');
            }
        }, 1000);
    }

    function updateCountdownDisplay() {
        const minutes = Math.floor(remainingSeconds / 60);
        const seconds = remainingSeconds % 60;
        document.getElementById('countdown').textContent = 
            String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
    }

    async function refreshQrCode() {
        const btn = document.getElementById('refresh-btn');
        const icon = document.getElementById('refresh-icon');
        const text = document.getElementById('refresh-text');
        
        // Disable button and show loading state
        btn.disabled = true;
        icon.classList.add('animate-spin');
        text.textContent = 'Refreshing...';
        
        try {
            const response = await fetch('{{ route('admin.qr.refresh') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update QR code
                document.getElementById('qr-code').innerHTML = data.qr_code;
                document.getElementById('expires-at').textContent = data.expires_at;
                
                // Reset countdown
                clearInterval(countdownInterval);
                remainingSeconds = 300;
                document.getElementById('countdown').classList.remove('text-red-600');
                document.getElementById('countdown').classList.add('text-indigo-600');
                startCountdown();
                
                // Show success feedback
                showToast('QR code refreshed successfully!', 'success');
            } else {
                showToast('Failed to refresh QR code', 'error');
            }
        } catch (error) {
            showToast('Network error. Please try again.', 'error');
        } finally {
            // Re-enable button
            btn.disabled = false;
            icon.classList.remove('animate-spin');
            text.textContent = 'Refresh QR Code';
        }
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-y-0 ${
            type === 'success' ? 'bg-green-600' : 'bg-red-600'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Start countdown on page load
    document.addEventListener('DOMContentLoaded', startCountdown);
</script>
@endsection
