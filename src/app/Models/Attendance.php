<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'work_date',
        'clock_in',
        'clock_out',
    ];

    protected $casts = [
        'work_date' => 'datetime',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breaktimes()
    {
        return $this->hasMany(Breaktime::class);
    }

    public function attendanceRequests()
    {
        return $this->hasMany(AttendanceRequest::class);
    }

    public function getBreakSecondsAttribute()
    {
        return $this->breaktimes->sum(function ($break) {
            return strtotime($break->break_end) - strtotime($break->break_start);
        });
    }

    public function getBreakFormattedAttribute()
    {
        return gmdate('H:i', $this->break_seconds);
    }

    public function getWorkSecondsAttribute()
    {
        return strtotime($this->clock_out) - strtotime($this->clock_in);
    }

    public function getWorkFormattedAttribute()
    {
        return gmdate('H:i', $this->work_seconds - $this->break_seconds);
    }
}
