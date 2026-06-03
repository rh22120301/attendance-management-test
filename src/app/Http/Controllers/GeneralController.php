<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\AttendanceRequest;
use App\Models\AttendanceRequestBreaktime;
use App\Http\Requests\AttendanceCorrectRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class GeneralController extends Controller
{
    public function attendance()
    {
        $attendance = Attendance::with('breaktimes')
            ->where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        $status = 'before_work';

        if ($attendance) {
            if ($attendance->clock_out) {
                $status = 'finished';

            } elseif ($attendance->breaktimes()->whereNull('break_end')->exists()) {
                $status = 'on_break';

            } else {
                $status = 'working';
            }
        }

        return view('general.attendance', compact('attendance', 'status'));
    }

    public function clockIn()
    {
        Attendance::create([
            'user_id' => auth()->id(),
            'work_date' => today(),
            'clock_in' => now(),
        ]);

        return redirect()->back();
    }

    public function clockOut()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        $attendance->update([
            'clock_out' => now(),
        ]);

        return redirect()->back();
    }

    public function breakStart()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();
        
        Breaktime::create([
            'attendance_id'=>$attendance->id,
            'break_start'=>now(),
        ]);

        return redirect()->back();
    }

    public function breakEnd()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();
        
        $breaktime = Breaktime::where('attendance_id', $attendance->id)
            ->whereNull('break_end')
            ->latest()
            ->first();
        
        $breaktime->update([
            'break_end'=>now(),
        ]);

        return redirect()->back();
    }



public function attendanceList(Request $request)
{
    $currentMonth = $request->input('month', now()->format('Y-m'));

    $month = Carbon::createFromFormat('Y-m', $currentMonth);

    $startMonth = $month->copy()->startOfMonth();
    $endMonth = $month->copy()->endOfMonth();

    // その月の勤怠
    $attendances = Attendance::with('breaktimes')
        ->where('user_id', auth()->id())
        ->whereBetween('work_date', [$startMonth, $endMonth])
        ->get()
        ->keyBy(function ($attendance) {
            return Carbon::parse($attendance->work_date)
                ->format('Y-m-d');
        });

    // 月の日付一覧
    $period = CarbonPeriod::create($startMonth, $endMonth);

    $rows = collect();

    foreach ($period as $date) {
        $key = $date->format('Y-m-d');

        $rows->push([
            'date' => $date,
            'attendance' => $attendances[$key] ?? null,
        ]);
    }

    $prevMonth = $month->copy()->subMonth()->format('Y-m');
    $nextMonth = $month->copy()->addMonth()->format('Y-m');

    return view('general.attendance_list', compact(
        'rows',
        'currentMonth',
        'prevMonth',
        'nextMonth'
    ));
}

    public function showDetail($id, Request $request)
    {
        if ($id == 0) {
            $date = $request->date;
            return view('general.attendance_detail_empty', compact('date'));
        }

        $attendance = Attendance::with('breaktimes','user')->findOrFail($id);

        return view('general.attendance_detail', compact('attendance'));
    }


    public function correction(AttendanceCorrectRequest $request, $attendanceId)
    {
        $attendance = Attendance::with('attendanceRequests')->findOrFail($attendanceId);

        if ($attendance->attendanceRequests()->where('status', 'pending')->exists()) {
            return back()->withErrors(['修正申請が承認待ちのため、申請できません。']);
        }

        AttendanceRequest::create([
            'attendance_id' => $attendanceId,
            'user_id' => auth()->id(),
            'request_clock_in' => $request->request_clock_in,
            'request_clock_out' => $request->request_clock_out,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('message', '修正申請を送信しました');
    }


    public function stampCorrectionRequest(Request $request)
    {
        $tab = $request->get('tab', 'pending');
        $requests = AttendanceRequest::with(['attendance', 'attendance.breaktimes'])
        ->where('user_id', auth()->id())
        ->where('status', $tab)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('general.stamp_correction_request', compact('requests', 'tab'));
    }

 
}
