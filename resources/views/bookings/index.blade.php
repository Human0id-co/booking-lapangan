@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">📅 My Booking History</h2>
        <p class="text-gray-500 mt-1">Review all your booked fields here.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('bookings.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Book a Field
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-left text-sm font-medium text-gray-600">
                <tr>
                    <th class="px-6 py-3">Field Name</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Time</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $booking->field->name }}</td>
                        <td class="px-6 py-4">{{ $booking->field->location }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->booking_date)->format('D, d M Y') }}</td>
                        <td class="px-6 py-4">{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' : 
                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                   'bg-red-100 text-red-700') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
