@extends('layouts.app')

@section('title', 'Workplace QR Code')

@section('content')
<div class="min-h-screen bg-gray-50 p-6" id="qrCodeApp">
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 mb-1">Workplace QR Code</h1>
                    <p class="text-gray-500 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $today }}
                    </p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button @click="refreshQrCode" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-left transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 text-sm">Refresh Code</h3>
                        <p class="text-xs text-gray-500">Generate new QR</p>
                    </div>
                </div>
            </button>

            <button @click="downloadQrCode" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-left transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 text-sm">Download</h3>
                        <p class="text-xs text-gray-500">Save as image</p>
                    </div>
                </div>
            </button>

            <button @click="toggleFullscreen" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-left transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 text-sm">Fullscreen</h3>
                        <p class="text-xs text-gray-500">Display mode</p>
                    </div>
                </div>
            </button>

            <button @click="printQrCode" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-left transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 text-sm">Print</h3>
                        <p class="text-xs text-gray-500">Physical copy</p>
                    </div>
                </div>
            </button>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- QR Code Display Card -->
            <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-1">Active QR Code</h2>
                    <p class="text-gray-500 text-sm mb-6">Employees scan this code to mark attendance</p>
                    
                    <!-- QR Code Container -->
                    <div class="bg-gray-50 p-8 rounded-xl inline-block border border-gray-200" id="qr-container">
                        <div class="bg-white p-6 rounded-lg shadow-sm" id="qr-code">
                            {!! $qrCode !!}
                        </div>
                    </div>

                    <!-- Status Bar -->
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-4 py-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full" :class="{'animate-pulse': isActive}"></div>
                            <span class="text-slate-700 text-sm font-medium">@{{ isActive ? 'Active' : 'Expired' }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-amber-50 border border-amber-200 rounded-lg px-4 py-2">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-amber-800 text-sm">Expires: <span class="font-medium">@{{ expiresAt }}</span></span>
                        </div>
                    </div>

                    <!-- Countdown Timer -->
                    <div class="mt-4">
                        <div class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg px-5 py-3">
                            <span class="text-gray-600 text-sm">Time remaining:</span>
                            <span class="font-mono font-semibold text-lg" :class="remainingSeconds <= 60 ? 'text-red-600' : 'text-blue-600'">
                                @{{ formatTime(remainingSeconds) }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex gap-3 justify-center">
                        <button 
                            @click="refreshQrCode" 
                            :disabled="isRefreshing"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white px-6 py-2.5 rounded-lg font-medium transition-colors duration-200">
                            <svg class="w-5 h-5" :class="{'animate-spin': isRefreshing}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            @{{ isRefreshing ? 'Refreshing...' : 'Refresh Code' }}
                        </button>
                        <button 
                            @click="autoRefreshEnabled = !autoRefreshEnabled"
                            class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Auto: @{{ autoRefreshEnabled ? 'ON' : 'OFF' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Side Panel -->
            <div class="space-y-6">
                <!-- Security Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900">Security Features</h3>
                    </div>
                    <ul class="space-y-2.5">
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Daily rotation prevents unauthorized access</span>
                        </li>
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Encrypted timestamp validation</span>
                        </li>
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>5-minute expiration window</span>
                        </li>
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Complete audit trail logging</span>
                        </li>
                    </ul>
                </div>

                <!-- Statistics -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Today's Activity</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Scans</span>
                            <span class="font-semibold text-gray-900">@{{ stats.totalScans }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Successful</span>
                            <span class="font-semibold text-green-600">@{{ stats.successful }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Failed</span>
                            <span class="font-semibold text-red-600">@{{ stats.failed }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructions Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                How to Use
            </h3>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                        <span class="text-lg font-bold text-blue-600">1</span>
                    </div>
                    <p class="text-gray-900 font-medium text-sm mb-1">Login to System</p>
                    <p class="text-gray-500 text-xs">Access with your employee credentials</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                        <span class="text-lg font-bold text-blue-600">2</span>
                    </div>
                    <p class="text-gray-900 font-medium text-sm mb-1">Navigate to Scanner</p>
                    <p class="text-gray-500 text-xs">Select "Scan QR" from your menu</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                        <span class="text-lg font-bold text-blue-600">3</span>
                    </div>
                    <p class="text-gray-900 font-medium text-sm mb-1">Scan & Confirm</p>
                    <p class="text-gray-500 text-xs">Point camera and confirm attendance</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <transition name="fade">
        <div v-if="toast.show" 
             :class="['fixed bottom-6 right-6 px-6 py-3 rounded-lg shadow-lg text-white font-medium flex items-center gap-2 z-50',
                      toast.type === 'success' ? 'bg-green-600' : 'bg-red-600']">
            <svg v-if="toast.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            @{{ toast.message }}
        </div>
    </transition>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            expiresAt: '{{ $expiresAt }}',
            remainingSeconds: 300,
            isActive: true,
            isRefreshing: false,
            autoRefreshEnabled: false,
            countdownInterval: null,
            stats: {
                totalScans: 0,
                successful: 0,
                failed: 0
            },
            toast: {
                show: false,
                message: '',
                type: 'success'
            }
        };
    },
    methods: {
        formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        },
        startCountdown() {
            this.countdownInterval = setInterval(() => {
                this.remainingSeconds--;
                
                if (this.remainingSeconds <= 0) {
                    this.isActive = false;
                    clearInterval(this.countdownInterval);
                    
                    if (this.autoRefreshEnabled) {
                        this.refreshQrCode();
                    }
                }
            }, 1000);
        },
        async refreshQrCode() {
            this.isRefreshing = true;
            
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
                    document.getElementById('qr-code').innerHTML = data.qr_code;
                    this.expiresAt = data.expires_at;
                    
                    clearInterval(this.countdownInterval);
                    this.remainingSeconds = 300;
                    this.isActive = true;
                    this.startCountdown();
                    
                    this.showToast('QR code refreshed successfully!', 'success');
                } else {
                    this.showToast('Failed to refresh QR code', 'error');
                }
            } catch (error) {
                this.showToast('Network error. Please try again.', 'error');
            } finally {
                this.isRefreshing = false;
            }
        },
        async downloadQrCode() {
            try {
                const qrContainer = document.getElementById('qr-container');
                const canvas = await html2canvas(qrContainer);
                const link = document.createElement('a');
                link.download = `workplace-qr-${new Date().getTime()}.png`;
                link.href = canvas.toDataURL();
                link.click();
                this.showToast('QR code downloaded successfully!', 'success');
            } catch (error) {
                this.showToast('Failed to download QR code', 'error');
            }
        },
        toggleFullscreen() {
            const elem = document.getElementById('qr-container');
            if (!document.fullscreenElement) {
                elem.requestFullscreen().catch(err => {
                    this.showToast('Fullscreen mode unavailable', 'error');
                });
            } else {
                document.exitFullscreen();
            }
        },
        printQrCode() {
            window.print();
        },
        showToast(message, type = 'success') {
            this.toast.message = message;
            this.toast.type = type;
            this.toast.show = true;
            
            setTimeout(() => {
                this.toast.show = false;
            }, 3000);
        },
        loadStats() {
            // Simulated stats - replace with actual API call
            this.stats.totalScans = 47;
            this.stats.successful = 45;
            this.stats.failed = 2;
        }
    },
    mounted() {
        this.startCountdown();
        this.loadStats();
    },
    beforeUnmount() {
        if (this.countdownInterval) {
            clearInterval(this.countdownInterval);
        }
    }
}).mount('#qrCodeApp');
</script>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

@media print {
    body * {
        visibility: hidden;
    }
    #qr-container, #qr-container * {
        visibility: visible;
    }
    #qr-container {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
}
</style>
@endsection