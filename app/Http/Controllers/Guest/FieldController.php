<?php

namespace App\Http\Controllers\Guest;

use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::with('bookings')->get();
        return view('guest.fields.index', compact('fields'));
    }


    public function show(Field $field)
    {
        $approvedBookings = $field->bookings()
            ->where('status', 'approved')
            ->get();

        $bookingsFormatted = $approvedBookings->map(function ($booking) {
            return [
                'title' => 'Booked',
                'start' => $booking->booking_date . 'T' . $booking->start_time,
                'end' => $booking->booking_date . 'T' . $booking->end_time,
                'color' => '#f87171', // soft red
            ];
        });

        return view('guest.fields.show', [
            'field' => $field,
            'bookings' => $bookingsFormatted,
        ]);
    }


}
