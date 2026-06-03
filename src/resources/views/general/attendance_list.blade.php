@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance_list.css') }}">
@endsection

@section('content')
<div class="attendance-list__content">
    <div class="attendance-list__text">勤怠一覧</div>

    <div class="attendance-list__table">
        <div class="month-nav__group">
            <a class="month-nav" href="?month={{ $prevMonth }}">← 前月</a>

            <form method="GET" style="display:inline;">
                <input
                    type="month"
                    name="month"
                    value="{{ $currentMonth }}"
                    onchange="this.form.submit()"
                >
            </form>

            <a class="month-nav" href="?month={{ $nextMonth }}">翌月 →</a>
        </div>

        <div class="table-wrapper">
            <table class="attendance-list">
                <tr class="attendance-list__group">
                    <th class="attendance-list__title">日付</th>
                    <th class="attendance-list__title">出勤</th>
                    <th class="attendance-list__title">退勤</th>
                    <th class="attendance-list__title">休憩</th>
                    <th class="attendance-list__title">合計</th>
                    <th class="attendance-list__title">詳細</th>
                </tr>

                @foreach($rows as $row)
                @php
                    $attendance = $row['attendance'];
                    $date = $row['date']; // ← これで毎行の date が取れる
                @endphp
                <tr>
                    <td class="attendance-list__detail">
                        {{ $date->isoFormat('MM/DD(ddd)') }}
                    </td>

                    <td class="attendance-list__detail">
                        {{ $attendance?->clock_in?->format('H:i') ?? '' }}
                    </td>

                    <td class="attendance-list__detail">
                        {{ $attendance?->clock_out?->format('H:i') ?? '' }}
                    </td>

                    <td class="attendance-list__detail">
                        {{ $attendance?->break_formatted ?? '' }}
                    </td>

                    <td class="attendance-list__detail">
                        {{ $attendance?->work_formatted ?? '' }}
                    </td>

                    <td class="attendance-list__detail">
                        <a class="attendance-list__detail-link" href="/attendanceList/{{ $attendance->id ?? 0 }}?date={{ $date->format('Y-m-d') }}">
                            詳細
                        </a>
                    </td>
                </tr>

            @endforeach


            </table>
        </div>
    </div>
</div>
@endsection