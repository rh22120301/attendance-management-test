<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttendanceRequest;

class AttendanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttendanceRequest::create([
            'user_id' => 2,
            'attendance_id' => 1,
            'request_clock_in' => today()->subDay(2)->setTime(9,0),
            'request_clock_out' => today()->subDay(2)->setTime(18,0),
            'status' => 'pending',
            'notes' => '電車遅延のため',
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
    }
}
