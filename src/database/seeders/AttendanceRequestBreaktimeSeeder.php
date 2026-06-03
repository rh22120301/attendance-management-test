<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttendanceRequestBreaktime;

class AttendanceRequestBreaktimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttendanceRequestBreaktime::create([
            'attendance_request_id' => 1,
            'break_start' => today()->subDay(2)->setTime(15,0),
            'break_end' => today()->subDay(2)->setTime(15,30),
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
    }
}
