@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="space-y-6">
    <div class="card">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Analytics Dashboard</h1>
        <p class="text-gray-600">Monthly attendance trends and insights</p>
    </div>
    
    <!-- Monthly Statistics -->
    <div class="grid md:grid-cols-4 gap-6">
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <p class="text-sm opacity-80 mb-1">Total Records</p>
            <p class="text-4xl font-bold">{{ $stats['total_days'] }}</p>
        </div>
        
        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <p class="text-sm opacity-80 mb-1">On Time</p>
            <p class="text-4xl font-bold">{{ $stats['present'] }}</p>
            <p class="text-sm opacity-80">{{ $stats['total_days'] > 0 ? round(($stats['present'] / $stats['total_days']) * 100, 1) : 0 }}%</p>
        </div>
        
        <div class="card bg-gradient-to-br from-yellow-500 to-yellow-600 text-white">
            <p class="text-sm opacity-80 mb-1">Late Arrivals</p>
            <p class="text-4xl font-bold">{{ $stats['late'] }}</p>
            <p class="text-sm opacity-80">{{ $stats['total_days'] > 0 ? round(($stats['late'] / $stats['total_days']) * 100, 1) : 0 }}%</p>
        </div>
        
        <div class="card bg-gradient-to-br from-red-500 to-red-600 text-white">
            <p class="text-sm opacity-80 mb-1">Absences</p>
            <p class="text-4xl font-bold">{{ $stats['absent'] }}</p>
            <p class="text-sm opacity-80">{{ $stats['total_days'] > 0 ? round(($stats['absent'] / $stats['total_days']) * 100, 1) : 0 }}%</p>
        </div>
    </div>
    
    <!-- Weekly Breakdown -->
    <div class="card">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Weekly Breakdown</h2>
        <weekly-chart :data='@json($weeklyData)'></weekly-chart>
    </div>
    
    <!-- Detailed Table -->
    <div class="card">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Weekly Statistics</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Week</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Late</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($weeklyData as $week)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $week['week'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold">
                                    {{ $week['present'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold">
                                    {{ $week['late'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-semibold">
                                    {{ $week['absent'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold">
                                {{ $week['present'] + $week['late'] + $week['absent'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection