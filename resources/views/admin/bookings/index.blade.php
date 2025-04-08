@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Bookings Management</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded border border-green-300 dark:bg-green-800 dark:text-white">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Form --}}
    <form method="GET" class="mb-4">
        <label for="status" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Status:</label>
        <select name="status" id="status" onchange="this.form.submit()" class="px-3 py-2 rounded border-gray-300 dark:bg-gray-800 dark:text-white">
            <option value="">All</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>

    {{-- Bookings Table --}}
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-200 dark:bg-gray-700 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Field</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Time</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                        <td class="px-6 py-4">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4">{{ $booking->field->name }}</td>
                        <td class="px-6 py-4">{{ $booking->field->location }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->booking_date)->format('D, d M Y') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'approved' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'expired' => 'bg-gray-100 text-gray-800',
                                ];
                            @endphp
                        
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $statusColors[$booking->status] }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($booking->status === 'pending')
                                <form id="approve-form-{{ $booking->id }}" action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <form id="reject-form-{{ $booking->id }}" action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>

                                <button onclick="confirmApprove({{ $booking->id }})" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">
                                    Approve
                                </button>
                                <button onclick="confirmReject({{ $booking->id }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                    Reject
                                </button>

                            @elseif($booking->status === 'approved')
                                {{-- Form Expire --}}
                                <form id="expire-form-{{ $booking->id }}" action="{{ route('admin.bookings.expire', $booking->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <button onclick="confirmExpire({{ $booking->id }})" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 text-xs">
                                    Expire
                                </button>

                            @else
                                <span class="text-gray-500 text-xs italic">No action</span>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $bookings->withQueryString()->links() }}
    </div>
</div>
<script>
    function confirmApprove(id) {
        Swal.fire({
            title: 'Approve Booking?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#16a34a'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`approve-form-${id}`).submit();
            }
        });
    }

    function confirmReject(id) {
        Swal.fire({
            title: 'Reject Booking?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc2626'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`reject-form-${id}`).submit();
            }
        });
    }

    function confirmExpire(id) {
        Swal.fire({
            title: 'Mark as Expired?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes, expire it',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#6b7280'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`expire-form-${id}`).submit();
            }
        });
    }
</script>

@endsection
