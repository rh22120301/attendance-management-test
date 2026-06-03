<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;
use Carbon\Carbon;
use App\Models\AttendanceRequest;
use App\Http\Requests\AdminAttendanceCorrectionRequest;
use App\Http\Requests\AdminAttendanceStoreRequest;
use Carbon\CarbonPeriod;


class AdminController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'privilege' => 0,
        ];

        if (Auth::attempt($credentials)) {
            return redirect('/admin/attendanceList');
        }

        return back()->withErrors(['email' => '管理者として認証できません']);
    }

    public function attendanceList(Request $request)
    {
        $currentDate = Carbon::parse(
            $request->input('date', now()->toDateString())
        );

        $attendances = Attendance::with(['breaktimes', 'user'])
            ->whereDate('work_date', $currentDate->toDateString())
            ->get()
            ->keyBy('user_id');


        $users = User::orderBy('name')->get();

        $rows = collect();

        foreach ($users as $user) {
            $rows->push([
                'user' => $user,
                'attendance' => $attendances[$user->id] ?? null,
            ]);
        }

        $prevDate = $currentDate->copy()->subDay()->toDateString();
        $nextDate = $currentDate->copy()->addDay()->toDateString();

        return view('admin.attendance_list', compact(
            'rows',
            'currentDate',
            'prevDate',
            'nextDate'
        ));
    }

    public function staff()
    {
        $users = User::all();
        return view('admin.staff', compact('users'));
    }

    public function stampCorrectionRequest(Request $request)
    {
        $tab = $request->get('tab', 'pending');
        $requests = AttendanceRequest::with(['attendance', 'attendance.breaktimes'])
        ->where('status', $tab)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.stamp_correction_request', compact('requests','tab'));
    }

    public function approveConfirmation($id)
    {
        $requestData = AttendanceRequest::with(['attendance', 'user'])->findOrFail($id);

        return view('admin.approve_confirmation', compact('requestData'));
    }

    public function approve($id)
    {
        $requestData = AttendanceRequest::findOrFail($id);

        $requestData->update([
            'status' => 'approved'
        ]);

        return redirect("/admin/stampCorrectionRequest/{$requestData->id}");
        }


    public function staffMonthly(User $user, Request $request)
    {
        $month = $request->month
            ? Carbon::parse($request->month)
            : now();

        $attendances = Attendance::with('breaktimes')
            ->where('user_id', $user->id)
            ->whereYear('work_date', $month->year)
            ->whereMonth('work_date', $month->month)
            ->get()
            ->keyBy(function ($attendance) {
                return $attendance->work_date->format('Y-m-d');
            });

        $dates = CarbonPeriod::create(
            $month->copy()->startOfMonth(),
            $month->copy()->endOfMonth()
        );

        return view(
            'admin.attendance_staff',compact('user', 'attendances', 'dates', 'month'));
    }
    public function exportCsv(Request $request)
    {
        $userId = $request->user_id;
        $month  = $request->month;

        $fileName = "attendance_{$userId}_{$month}.csv";

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($userId, $month) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['日付', '出勤', '退勤', '休憩', '合計']);

            $attendances = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('work_date', substr($month, 0, 4))
                ->whereMonth('work_date', substr($month, 5, 2))
                ->orderBy('work_date')
                ->get();

            foreach ($attendances as $a) {
                fputcsv($handle, [
                    $a->work_date,
                    optional($a->clock_in)->format('H:i'),
                    optional($a->clock_out)->format('H:i'),
                    $a->break_formatted,
                    $a->work_formatted,
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }


        public function showDetail($id, Request $request)
    {
        if ($id == 0) {
            $date = $request->date;
            $user = User::findOrFail($request->user_id);
            return view('admin.attendance_detail_empty', compact('date', 'user'));
        }
        $attendance = Attendance::with('breaktimes','user')->findOrFail($id);

        return view('admin.attendance_detail', compact('attendance'));
    }

    public function store(AdminAttendanceStoreRequest $request)
    {
        $request->validate([
            'work_date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string',
            'break_start.*' => 'nullable|date_format:H:i',
            'break_end.*' => 'nullable|date_format:H:i',
        ]);

        $attendance = Attendance::create([
            'user_id' => $request->user_id ?? auth()->id(),
            'work_date' => $request->work_date,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'notes' => $request->notes,
        ]);

        if ($request->break_start) {
            foreach ($request->break_start as $i => $start) {
                if ($start || $request->break_end[$i]) {
                    $attendance->breaktimes()->create([
                        'break_start' => $start,
                        'break_end' => $request->break_end[$i],
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.attendance.show', $attendance->id)
            ->with('success', '勤怠を新規作成しました');
    }


    public function correction(AdminAttendanceCorrectionRequest $request,$id) 
    {
        $attendance = Attendance::with('breaktimes')
            ->findOrFail($id);

        $attendance->update([
            'clock_in' => $request->request_clock_in,
            'clock_out' => $request->request_clock_out,
            'notes' => $request->notes,
        ]);

        // 既存休憩
        foreach ($attendance->breaktimes as $index => $breaktime) {
            $breaktime->update([
                'break_start' => $request->break_start[$index] ?? null,
                'break_end' => $request->break_end[$index] ?? null,
            ]);
        }

        // 新規休憩
        $count = $attendance->breaktimes->count();

        if (
            !empty($request->break_start[$count]) ||
            !empty($request->break_end[$count])
        ) {
            $attendance->breaktimes()->create([
                'break_start' => $request->break_start[$count],
                'break_end' => $request->break_end[$count],
            ]);
        }

        return redirect()
    ->route('admin.attendance.show', $attendance->id)
    ->with('success', '勤怠情報を更新しました');
    }
    
}