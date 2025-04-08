<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->latest()->get();
        return view('bookings.index', compact('bookings'));
    }
    
    public function create()
    {
        $fields = Field::all();
        $bookings = Booking::where('status', 'approved')->get();

        return view('bookings.create', compact('fields', 'bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $start = Carbon::createFromFormat('H:i', $request->start_time);
        $end = Carbon::createFromFormat('H:i', $request->end_time);
        $duration = $end->diffInMinutes($start);

        // ❗ Minimal booking 1 jam
        if ($duration < 60) {
            return back()->withErrors('Durasi minimal booking adalah 1 jam.');
        }

        // ❗ Maksimal booking sampai jam 22:00
        $closingTime = Carbon::createFromTime(22, 0, 0);
        if ($end->greaterThan($closingTime)) {
            return back()->withErrors('Lapangan hanya bisa dibooking sampai jam 22.00.');
        }

        // ❗ Cek konflik booking
        $conflict = Booking::where('field_id', $request->field_id)
            ->where('booking_date', $request->booking_date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors('Lapangan sudah ada yang booking di jam tersebut.');
        }

        // ✅ Simpan booking dengan user_id
        Booking::create([
            'user_id' => Auth::id(), // user yang login
            'field_id' => $request->field_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat!');
    }

}
