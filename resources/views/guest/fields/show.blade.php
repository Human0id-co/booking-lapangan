@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 py-12 px-4">
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-xl p-8">
        <!-- Judul & Info Lapangan -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $field->name }} Schedule</h1>
            <p class="text-lg text-gray-700">📍 {{ $field->location }}</p>
            <p class="text-md text-gray-600">💰 Rp{{ number_format($field->price_per_hour, 0, ',', '.') }} / hour</p>
        </div>

        <!-- Kalender -->
        <div class="overflow-x-auto">
            <div id="calendar" class="rounded-2xl border border-gray-200 shadow-xl p-4 bg-white"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const bookingsData = @json($bookings);
</script>

@vite(['resources/js/field-calendar.js'])
@endpush

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css' rel='stylesheet' />
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.css' rel='stylesheet' />
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/main.min.css' rel='stylesheet' />
<style>
    .fc-event:hover {
        filter: brightness(1.1);
        cursor: pointer;
    }

    .fc-event-title {
        font-weight: 600;
    }

    .fc-timegrid-now-indicator-line {
        background-color: #10b981;
    }
</style>
@endpush
