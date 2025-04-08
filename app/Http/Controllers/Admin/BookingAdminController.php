<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'field']);

        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        $booking->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Booking approved successfully.');
    }

    public function reject(Booking $booking)
    {
        $booking->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Booking rejected successfully.');
    }

    public function expire(Booking $booking)
    {
        $booking->update(['status' => 'expired']);
        return redirect()->back()->with('success', 'Booking marked as expired.');
    }

}
