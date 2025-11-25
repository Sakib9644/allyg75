<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class event extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop 100 times to create 100 events
        for ($i = 1; $i <= 100; $i++) {
            DB::table('event')->insert([
                'title'      => 'Event ' . $i,  // unique title
                'date'       => now()->addDays(rand(0, 30)), // random date in next 30 days
                'start_time' => now()->format('H:i:s'),
                'end_time'   => now()->addHours(2)->format('H:i:s'),
                'address'    => 'Address ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
