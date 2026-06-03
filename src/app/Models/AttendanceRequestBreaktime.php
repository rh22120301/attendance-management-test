<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRequestBreaktime extends Model
{
    protected $fillable = [
        'attendance_request_id',
        'break_start',
        'break_end',
    ];

    protected $casts = [
        'break_start' => 'datetime',
        'break_end' => 'datetime',
    ];

    public function attendanceRequeset()
    {
        return $this->belongsTo(AttendanceRequest::class);
    }
}
