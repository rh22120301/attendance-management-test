@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance_detail.css') }}">
@endsection

@section('content')
<form action="/attendanceList/{{ $attendance->id }}/correction" method="POST">
    @csrf

    <div class="attendance-list__content">
        <div class="attendance-list__text">勤怠詳細</div>

        <div class="attendance-list__table">
            <div class="table-wrapper">
                <table class="attendance-list">

                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">名前</th>
                        <td class="attendance-list__detail">
                            {{ $attendance->user->name }}
                        </td>
                        <td class="attendance-list__detail"></td>
                        <td class="attendance-list__detail"></td>
                    </tr>

                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">日付</th>
                        <td class="attendance-list__detail">
                            {{ $attendance->work_date->isoFormat('YYYY年') }}
                        </td>
                        <td class="attendance-list__detail"></td>
                        <td class="attendance-list__detail">
                            {{ $attendance->work_date->isoFormat('M月D日') }}
                        </td>
                    </tr>

                    {{-- 出勤・退勤 --}}
                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">出勤・退勤</th>

                        <td class="attendance-list__detail">
                            <input
                                type="time"
                                name="request_clock_in"
                                value="{{ old('request_clock_in', $attendance->clock_in->format('H:i')) }}"
                            >

                            @error('request_clock_in')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>

                        <td class="attendance-list__detail">～</td>

                        <td class="attendance-list__detail">
                            <input
                                type="time"
                                name="request_clock_out"
                                value="{{ old('request_clock_out', $attendance->clock_out->format('H:i')) }}"
                            >

                            @error('request_clock_out')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 既存休憩 --}}
                    @foreach($attendance->breaktimes as $index => $breaktime)
                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">休憩{{ $index + 1 }}</th>

                        <td class="attendance-list__detail">
                            <input
                                type="time"
                                name="break_start[]"
                                value="{{ old('break_start.' . $index, $breaktime->break_start->format('H:i')) }}"
                            >

                            @error('break_start.' . $index)
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>

                        <td class="attendance-list__detail">～</td>

                        <td class="attendance-list__detail">
                            <input
                                type="time"
                                name="break_end[]"
                                value="{{ old('break_end.' . $index, $breaktime->break_end->format('H:i')) }}"
                            >

                            @error('break_end.' . $index)
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>
                    @endforeach

                    {{-- 新規休憩 --}}
                    @php
                        $newIndex = $attendance->breaktimes->count();
                    @endphp

                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">休憩{{ $newIndex + 1 }}</th>

                        <td class="attendance-list__detail">
                            <input
                                type="time"
                                name="break_start[]"
                                value="{{ old('break_start.' . $newIndex) }}"
                            >

                            @error('break_start.' . $newIndex)
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>

                        <td class="attendance-list__detail">～</td>

                        <td class="attendance-list__detail">
                            <input
                                type="time"
                                name="break_end[]"
                                value="{{ old('break_end.' . $newIndex) }}"
                            >

                            @error('break_end.' . $newIndex)
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 備考 --}}
                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">備考</th>

                        <td class="attendance-list__detail">
                            <textarea
                                class="attendance-detail__textarea"
                                name="notes"
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>

                        <td class="attendance-list__detail"></td>
                        <td class="attendance-list__detail"></td>
                    </tr>

                </table>

                @if($attendance->attendanceRequests()->where('status', 'pending')->exists())
                    <p class="error-message__pending">*承認待ちのため修正はできません。</p>
                @else
                    <a class="submit-button__base" href="/attendanceList/{{ $attendance->id }}/correction">
                        修正
                    </a>
                @endif

            </div>
        </div>
    </div>
</form>
@endsection