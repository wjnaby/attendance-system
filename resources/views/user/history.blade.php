@extends('layouts.app')

@section('title', 'Attendance History')

@section('content')
<div class="card">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Attendance History</h1>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($attendances as $attendance)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $attendance->date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $attendance->date->format('l') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $attendance->status === 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $attendance->status === 'absent' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            @if($attendance->check_in && $attendance->check_out)
                                @php
                                    $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                    $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                    $duration = $checkIn->diff($checkOut);
                                @endphp
                                {{ $duration->h }}h {{ $duration->i }}m
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No attendance records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $attendances->links() }}
    </div>
</div>
@endsection