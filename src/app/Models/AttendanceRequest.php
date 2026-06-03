<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'attendance_id',
        'request_clock_in',
        'request_clock_out',
        'status',
        'notes',
    ];

    protected $casts = [
        'request_clock_in' => 'datetime',
        'request_clock_out' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function attendanceRequestBreaktimes()
    {
        return $this->hasmany(AttendnaceRequestBreaktime::class);
    }
}
