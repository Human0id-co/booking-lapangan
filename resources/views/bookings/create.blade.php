@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📅 Book a Field</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="field_id" class="block text-sm font-medium text-gray-700">Field</label>
            <select name="field_id" id="field_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <option value="">-- Select Field --</option>
                @foreach($fields as $field)
                    <option value="{{ $field->id }}">{{ $field->name }} ({{ $field->location }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="booking_date" class="block text-sm font-medium text-gray-700">Booking Date</label>
            <input type="date" name="booking_date" id="booking_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="time" name="start_time" id="start_time" max="22:00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="time" name="end_time" id="end_time" max="22:00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
                🚀 Submit Booking
            </button>
        </div>
    </form>
</div>

<script>
    const allBookings = @json($bookings);
    const fieldSelect = document.getElementById('field_id');
    const dateInput = document.getElementById('booking_date');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');

    const CLOSING_TIME = "22:00";

    function isAfterClosingTime(time) {
        return time > CLOSING_TIME;
    }

    function getRelevantBookings() {
        const selectedField = fieldSelect.value;
        const selectedDate = dateInput.value;

        return allBookings.filter(b =>
            b.field_id == selectedField && b.booking_date === selectedDate
        );
    }

    startTimeInput.addEventListener('change', () => {
        const selectedTime = startTimeInput.value;

        if (isAfterClosingTime(selectedTime)) {
            Swal.fire({
                icon: 'warning',
                title: 'Booking terlalu malam!',
                text: 'Lapangan hanya buka sampai jam 22:00.',
                confirmButtonColor: '#d33'
            });
            startTimeInput.value = '';
            return;
        }

        const bookings = getRelevantBookings();
        const conflict = bookings.find(b =>
            selectedTime >= b.start_time && selectedTime < b.end_time
        );

        if (conflict) {
            Swal.fire({
                icon: 'error',
                title: 'Lapangan sudah dibooking!',
                html: `Waktu bentrok: <strong>${conflict.start_time} - ${conflict.end_time}</strong>`,
                confirmButtonColor: '#d33'
            });
            startTimeInput.value = '';
        }
    });

    endTimeInput.addEventListener('change', () => {
        const selectedTime = endTimeInput.value;

        if (isAfterClosingTime(selectedTime)) {
            Swal.fire({
                icon: 'warning',
                title: 'Booking terlalu malam!',
                text: 'Lapangan hanya buka sampai jam 22:00.',
                confirmButtonColor: '#d33'
            });
            endTimeInput.value = '';
            return;
        }

        const bookings = getRelevantBookings();
        const conflict = bookings.find(b =>
            selectedTime > b.start_time && selectedTime <= b.end_time
        );

        if (conflict) {
            Swal.fire({
                icon: 'error',
                title: 'Lapangan sudah dibooking!',
                html: `Waktu bentrok: <strong>${conflict.start_time} - ${conflict.end_time}</strong>`,
                confirmButtonColor: '#d33'
            });
            endTimeInput.value = '';
        }

        // Validasi minimal 1 jam
        const start = startTimeInput.value;
        if (start && selectedTime) {
            const [startHour, startMinute] = start.split(':').map(Number);
            const [endHour, endMinute] = selectedTime.split(':').map(Number);

            const durationInMinutes = (endHour * 60 + endMinute) - (startHour * 60 + startMinute);

            if (durationInMinutes < 60) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Durasi minimal 1 jam!',
                    text: 'Silakan pilih waktu berakhir yang setidaknya 1 jam setelah waktu mulai.',
                    confirmButtonColor: '#f59e0b'
                });
                endTimeInput.value = '';
            }
        }
    });
</script>
@endsection
