@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_attendance_list.css') }}">
@endsection

@section('content')
<div class="attendance-list__content">
    <div class="attendance-list__text">
        {{ $currentDate->isoFormat('YYYY年M月D日(ddd)') }}の勤怠
    </div>

    <div class="attendance-list__table">
        <div class="date-nav__group">
            <a class="date-nav" href="?date={{ $prevDate }}">← 前日</a>

            <form method="GET" style="display:inline;">
                <input
                    type="date"
                    name="date"
                    value="{{ $currentDate->toDateString() }}"
                    onchange="this.form.submit()"
                >
            </form>

            <a class="date-nav" href="?date={{ $nextDate }}">翌日 →</a>
        </div>

        <div class="table-wrapper">
            <table class="attendance-list">
                <tr class="attendance-list__group">
                    <th class="attendance-list__title">名前</th>
                    <th class="attendance-list__title">出勤</th>
                    <th class="attendance-list__title">退勤</th>
                    <th class="attendance-list__title">休憩</th>
                    <th class="attendance-list__title">合計</th>
                    <th class="attendance-list__title">詳細</th>
                </tr>

                @foreach($rows as $row)
                    @php
                        $user = $row['user'];
                        $attendance = $row['attendance'];
                    @endphp

                    <tr>
                        <td class="attendance-list__detail">
                            {{ $user->name }}
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
                            @if($attendance)
                                <a class="attendance-list__detail-link" href="/admin/attendance/{{ $attendance->id }}">詳細</a>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
</div>
@endsection