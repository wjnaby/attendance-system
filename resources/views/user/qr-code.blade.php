@extends('layouts.app')

@section('title', 'My QR Code')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Your QR Code</h1>
        <p class="text-gray-600 mb-6">Scan this code to check in or check out</p>
        
        <div class="bg-white p-8 rounded-lg inline-block shadow-lg">
            {!! $qrCode !!}
        </div>
        
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-yellow-800 font-semibold">⚠️ Important</p>
            <p class="text-yellow-700 text-sm mt-2">This QR code is unique to you and expires after 5 minutes. Refresh the page to generate a new code.</p>
        </div>
        
        <div class="mt-6 space-x-4">
            <button onclick="window.location.reload()" class="btn-primary">
                🔄 Refresh QR Code
            </button>
            <a href="{{ route('dashboard') }}" class="btn-secondary">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection