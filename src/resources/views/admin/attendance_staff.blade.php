@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance_list.css') }}">
@endsection

@section('content')
<div class="attendance-list__content">

    <div class="attendance-list__text">
        {{ $user->name }}さんの勤怠一覧
    </div>

    <div class="attendance-list__table">

        <div class="month-nav__group">
            <a
                class="month-nav"
                href="?month={{ $month->copy()->subMonth()->format('Y-m') }}"
            >
                ← 前月
            </a>

            <form method="GET" style="display:inline;">
                <input
                    type="month"
                    name="month"
                    value="{{ $month->format('Y-m') }}"
                    onchange="this.form.submit()"
                >
            </form>

            <a
                class="month-nav"
                href="?month={{ $month->copy()->addMonth()->format('Y-m') }}"
            >
                翌月 →
            </a>
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

                @foreach($dates as $date)

                    @php
                        $attendance =
                            $attendances[$date->format('Y-m-d')]
                            ?? null;
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
                            <a class="attendance-list__detail-link"
                            href="/admin/attendance/{{ $attendance->id ?? 0 }}?date={{ $date->format('Y-m-d') }}&user_id={{ $user->id }}">
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