<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attendance::create([
            'user_id' => 2,
            'work_date' => today()->subDay(), 
            'clock_in' => today()->subDay()->setTime(9,0),
            'clock_out' => today()->subDay()->setTime(18,0),
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
        Attendance::create([
            'user_id' => 2,
            'work_date' => today()->subDay(2), 
            'clock_in' => today()->subDay(2)->setTime(9,15),
            'clock_out' => today()->subDay(2)->setTime(18,30),
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
        Attendance::create([
            'user_id' => 2,
            'work_date' => today()->subDay(3), 
            'clock_in' => today()->subDay(3)->setTime(9,0),
            'clock_out' => today()->subDay(3)->setTime(18,0),
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
    }
}
