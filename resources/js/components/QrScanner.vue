<template>
    <div class="qr-scanner p-6">
        <div class="mb-6">
            <div class="bg-gray-800 rounded-2xl p-8 flex items-center justify-center" style="min-height: 350px;">
                <div v-if="!scanning" class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-300 mb-4">Click to activate camera</p>
                    <button @click="startScanning" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Start Camera
                    </button>
                </div>
                
                <div v-else class="w-full relative">
                    <video ref="video" class="w-full rounded-xl" autoplay></video>
                    <canvas ref="canvas" style="display: none;"></canvas>
                    
                    <!-- Scanning overlay -->
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute inset-4 border-2 border-blue-400 rounded-lg opacity-50"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 border-4 border-green-400 rounded-lg animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-if="scanning" class="text-center mb-4">
            <button @click="stopScanning" class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:bg-red-700 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Stop Camera
            </button>
        </div>
        
        <!-- Manual Input -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Or Enter Code Manually
            </h3>
            <div class="flex gap-3">
                <input 
                    v-model="manualQrData" 
                    type="text" 
                    placeholder="Paste QR code data here..."
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                >
                <button @click="processManualInput" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-medium shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                    Submit
                </button>
            </div>
        </div>
        
        <!-- Loading State -->
        <div v-if="isProcessing" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-8 text-center shadow-2xl">
                <div class="w-16 h-16 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                <p class="text-gray-700 font-medium">Processing attendance...</p>
            </div>
        </div>
        
        <!-- Success/Error Messages -->
        <div v-if="message" class="mt-6 p-4 rounded-xl" :class="messageClass">
            <div class="flex items-center gap-3">
                <div v-if="isSuccess" class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div v-else class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">{{ message }}</p>
                    <p v-if="checkTime" class="text-sm mt-1 opacity-75">Time: {{ checkTime }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import jsQR from 'jsqr';

export default {
    name: 'QrScanner',
    data() {
        return {
            scanning: false,
            stream: null,
            manualQrData: '',
            message: '',
            messageClass: '',
            checkTime: '',
            scanInterval: null,
            isProcessing: false,
            isSuccess: false,
        };
    },
    methods: {
        async startScanning() {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: 'environment' } 
                });
                this.$refs.video.srcObject = this.stream;
                this.scanning = true;
                this.message = '';
                
                // Start scanning for QR codes
                this.scanInterval = setInterval(() => {
                    this.captureFrame();
                }, 500);
            } catch (error) {
                this.showMessage('Camera access denied. Please use manual input or enable camera permissions.', 'error');
            }
        },
        
        stopScanning() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            if (this.scanInterval) {
                clearInterval(this.scanInterval);
            }
            this.scanning = false;
        },
        
        captureFrame() {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            
            if (!video || !canvas) return;
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);
            
            if (code) {
                this.stopScanning();
                this.submitAttendance(code.data);
            }
        },
        
        async processManualInput() {
            if (!this.manualQrData) {
                this.showMessage('Please enter QR code data', 'error');
                return;
            }
            
            await this.submitAttendance(this.manualQrData);
        },
        
        async submitAttendance(qrData) {
            this.isProcessing = true;
            this.message = '';
            
            try {
                const response = await fetch('/check-in', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ qr_data: qrData }),
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    this.showMessage(data.message, 'success');
                    this.checkTime = data.time;
                    this.manualQrData = '';
                    
                    // Redirect to confirmation page after short delay
                    setTimeout(() => {
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else {
                            window.location.href = '/attendance-confirmation';
                        }
                    }, 1500);
                } else {
                    this.showMessage(data.error || 'An error occurred. Please try again.', 'error');
                }
            } catch (error) {
                this.showMessage('Network error. Please check your connection and try again.', 'error');
            } finally {
                this.isProcessing = false;
            }
        },
        
        showMessage(msg, type) {
            this.message = msg;
            this.isSuccess = type === 'success';
            this.messageClass = type === 'success' 
                ? 'bg-green-50 border border-green-200 text-green-800'
                : 'bg-red-50 border border-red-200 text-red-800';
        },
    },
    beforeUnmount() {
        this.stopScanning();
    },
};
</script>

<style scoped>
.qr-scanner {
    max-width: 100%;
}
</style>
