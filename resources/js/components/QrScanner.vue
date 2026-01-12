<template>
    <div class="qr-scanner">
        <div class="mb-6">
            <div class="bg-gray-800 rounded-lg p-8 flex items-center justify-center" style="min-height: 400px;">
                <div v-if="!scanning" class="text-center">
                    <div class="text-6xl mb-4">📷</div>
                    <button @click="startScanning" class="btn-primary">
                        Start Camera
                    </button>
                </div>
                
                <div v-else class="w-full">
                    <video ref="video" class="w-full rounded-lg" autoplay></video>
                    <canvas ref="canvas" style="display: none;"></canvas>
                </div>
            </div>
        </div>
        
        <div v-if="scanning" class="text-center mb-4">
            <button @click="stopScanning" class="btn-danger">
                Stop Camera
            </button>
        </div>
        
        <!-- Manual Input -->
        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold mb-4">Or Enter QR Code Manually</h3>
            <div class="flex gap-4">
                <input 
                    v-model="manualQrData" 
                    type="text" 
                    placeholder="Paste QR code data here"
                    class="input-field flex-1"
                >
                <button @click="processManualInput" class="btn-primary">
                    Submit
                </button>
            </div>
        </div>
        
        <!-- Success/Error Messages -->
        <div v-if="message" class="mt-4 p-4 rounded-lg" :class="messageClass">
            <p class="font-semibold">{{ message }}</p>
            <p v-if="checkTime" class="text-sm mt-1">Time: {{ checkTime }}</p>
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
                
                // Start scanning for QR codes
                this.scanInterval = setInterval(() => {
                    this.captureFrame();
                }, 500);
            } catch (error) {
                this.showMessage('Camera access denied. Please use manual input.', 'error');
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
                
                if (response.ok) {
                    this.showMessage(data.message, 'success');
                    this.checkTime = data.time;
                    this.manualQrData = '';
                    
                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 2000);
                } else {
                    this.showMessage(data.error || 'An error occurred', 'error');
                }
            } catch (error) {
                this.showMessage('Network error. Please try again.', 'error');
            }
        },
        
        showMessage(msg, type) {
            this.message = msg;
            this.messageClass = type === 'success' 
                ? 'bg-green-100 border border-green-400 text-green-700'
                : 'bg-red-100 border border-red-400 text-red-700';
        },
    },
    beforeUnmount() {
        this.stopScanning();
    },
};
</script>

<style scoped>
.qr-scanner {
    max-width: 500px;
    margin: 50px auto;
}
</style>
