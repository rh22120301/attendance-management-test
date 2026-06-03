<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Breaktime;

class BreaktimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Breaktime::create([
            'attendance_id' => 1,
            'break_start' => today()->subDay()->setTime(12,0),
            'break_end' => today()->subDay()->setTime(13,0),
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
        Breaktime::create([
            'attendance_id' => 1,
            'break_start' => today()->subDay()->setTime(15,0),
            'break_end' => today()->subDay()->setTime(16,0),
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
        Breaktime::create([
            'attendance_id' => 2,
            'break_start' => today()->subDay(2)->setTime(15,0),
            'break_end' => today()->subDay(2)->setTime(15,30),
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
        Breaktime::create([
            'attendance_id' => 3,
            'break_start' => today()->subDay(3)->setTime(12,0),
            'break_end' => today()->subDay(3)->setTime(13,0),
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
    }
}
