@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance_detail.css') }}">
@endsection

@section('content')
<div class="attendance-list__content">
    <div class="attendance-list__text">
        勤怠詳細
    </div>

    <div class="attendance-list__table">
        <div class="table-wrapper">
            <table class="attendance-list">

                <tr class="attendance-list__group">
                    <th class="attendance-list__title">名前</th>
                    <td class="attendance-list__detail">{{ $requestData->user->name }}</td>
                    <td class="attendance-list__detail"></td>
                    <td class="attendance-list__detail"></td>
                </tr>

                <tr class="attendance-list__group">
                    <th class="attendance-list__title">対象日</th>
                    <td class="attendance-list__detail">
                        {{ $requestData->attendance->work_date->isoFormat('YYYY年') }}
                    </td>
                    <td class="attendance-list__detail"></td>
                    <td class="attendance-list__detail">
                        {{ $requestData->attendance->work_date->isoFormat('M月D日') }}
                    </td>
                </tr>

                <tr class="attendance-list__group">
                    <th class="attendance-list__title">修正前（出勤・退勤）</th>
                    <td class="attendance-list__detail">
                        {{ $requestData->attendance->clock_in?->format('H:i') }}
                    </td>
                    <td class="attendance-list__detail">
                        ～
                    </td>
                    <td class="attendance-list__detail">
                        {{ $requestData->attendance->clock_out?->format('H:i') }}
                    </td>
                </tr>

                <tr class="attendance-list__group">
                    <th class="attendance-list__title">修正後（申請内容）</th>
                    <td class="attendance-list__detail">
                        {{ $requestData->request_clock_in->format('H:i') }}
                    </td>
                    <td class="attendance-list__detail">
                        ～
                    </td>
                    <td class="attendance-list__detail">
                        {{ $requestData->request_clock_out->format('H:i') }}
                    </td>
                </tr>

                <tr class="attendance-list__group">
                    <th class="attendance-list__title">備考</th>
                    <td class="attendance-list__detail">{{ $requestData->notes }}</td>
                    <td class="attendance-list__detail"></td>
                    <td class="attendance-list__detail"></td>
                </tr>

            </table>

            <div class="submit-button">
                @if ($requestData->status === 'pending')
                    <form action="/admin/request/{{ $requestData->id }}/approve" method="POST">
                        @csrf
                        <button class="submit-button__base" type="submit">承認</button>
                    </form>
                @else
                    <div class="submit-button__approved">承認済み</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
