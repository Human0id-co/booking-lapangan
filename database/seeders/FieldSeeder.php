<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Field::insert([
            [
                'name' => 'Lapangan Futsal A',
                'location' => 'Jl. Merdeka No. 1',
                'image' => 'lapangan_a.jpg',
                'price_per_hour' => 100000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lapangan Futsal B',
                'location' => 'Jl. Sudirman No. 2',
                'image' => 'lapangan_b.jpg',
                'price_per_hour' => 120000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lapangan Futsal C',
                'location' => 'Jl. Pahlawan No. 3',
                'image' => 'lapangan_c.jpg',
                'price_per_hour' => 140000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
