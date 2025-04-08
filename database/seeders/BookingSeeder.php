<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first(); // ambil user pertama
        $fields = Field::all(); // semua lapangan

        foreach ($fields as $field) {
            Booking::create([
                'user_id' => $user->id,
                'field_id' => $field->id,
                'booking_date' => Carbon::today()->format('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'status' => 'approved',
            ]);

            Booking::create([
                'user_id' => $user->id,
                'field_id' => $field->id,
                'booking_date' => Carbon::today()->addDay()->format('Y-m-d'),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'status' => 'approved',
            ]);
        }
    }
}
