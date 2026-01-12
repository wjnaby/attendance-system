@extends('layouts.app')

@section('title', 'Scan QR Code')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Scan QR Code</h1>
        <p class="text-gray-600 mb-6 text-center">Use your camera to scan the attendance QR code</p>
        
        <qr-scanner></qr-scanner>
        
        <div class="mt-6 text-center">
            <a href="{{ route('dashboard') }}" class="btn-secondary">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection