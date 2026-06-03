@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance_detail.css') }}">
@endsection

@section('content')
<form action="{{ route('admin.attendance.store') }}" method="POST">
    @csrf

    <input type="hidden" name="work_date" value="{{ $date }}">

    <div class="attendance-list__content">
        <div class="attendance-list__text">
            勤怠詳細
        </div>

        <div class="attendance-list__table">
            <div class="table-wrapper">
                <table class="attendance-list">
                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">名前</th>
                        <td class="attendance-list__detail">
                            {{ $user->name }}
                        </td>
                        <td class="attendance-list__detail"></td>
                        <td class="attendance-list__detail"></td>
                    </tr>
                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">日付</th>
                        <td class="attendance-list__detail">
                            {{ \Carbon\Carbon::parse($date)->isoFormat('YYYY年') }}
                        </td>
                        <td class="attendance-list__detail"></td>
                        <td class="attendance-list__detail">
                            {{ \Carbon\Carbon::parse($date)->isoFormat('M月D日') }}
                        </td>
                    </tr>

                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">出勤・退勤</th>
                        <td class="attendance-list__detail">
                            <input type="time" name="clock_in" value="{{ old('clock_in') }}">
                            @error('clock_in')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>
                        <td class="attendance-list__detail">〜</td>
                        <td class="attendance-list__detail">
                            <input type="time" name="clock_out" value="{{ old('clock_out') }}">
                            @error('clock_out')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">休憩</th>
                        <td class="attendance-list__detail">
                            <input type="time" name="break_start[]" value="{{ old('break_start.0') }}">
                            @error('break_start.0')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>
                        <td class="attendance-list__detail">〜</td>
                        <td class="attendance-list__detail">
                            <input type="time" name="break_end[]" value="{{ old('break_end.0') }}">
                            @error('break_end.0')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    <tr class="attendance-list__group">
                        <th class="attendance-list__title">備考</th>
                        <td class="attendance-list__detail" colspan="3">
                            <textarea class="attendance-detail__textarea" name="notes">{{ old('notes') }}</textarea>
                        </td>
                    </tr>

                </table>

                <div class="submit-button">
                    <button class="submit-button__base" type="submit">修正</button>
                </div>

            </div>
        </div>
    </div>
</form>
@endsection
