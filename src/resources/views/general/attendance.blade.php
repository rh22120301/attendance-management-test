@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance-content">
    <div class="attendance-status">
        @if ($status ==='before_work')
        <p class="attendance-status__text">勤務外</p>
        @elseif ($status ==='working')
        <p class="attendance-status__text">出勤中</p>
        @elseif ($status ==='on_break')
        <p class="attendance-status__text">休憩中</p>
        @elseif ($status ==='finished')
        <p class="attendance-status__text">退勤済</p>
        @endif
    </div>

    <div class="attendance-date">
        <p class="todays-date">{{ \Carbon\Carbon::now()->locale('ja')->isoFormat('YYYY年M月D日(ddd)') }}</p>
        <p class="current-time">{{ \Carbon\Carbon::now()->format('H:i') }}</p>
    </div>

    <div class="attendance-button__group">
    
        @if ($status === 'before_work')
        <form action="{{ route('attendance.clockIn') }}" method="POST">
            @csrf
            <button class="attendance-button" type="submit">出勤</button>
        </form>

        @elseif ($status ==='working')
        <form action="{{ route('attendance.clockOut') }}" method="POST">
            @csrf
            <button class="attendance-button" type="submit">退勤</button>
        </form>
        <form action="{{ route('attendance.breakStart') }}" method="POST">
            @csrf
            <button class="break-button" type="submit">休憩入</button>
        </form>
        @elseif ($status ==='on_break')
        <form action="{{ route('attendance.breakEnd') }}" method="POST">
            @csrf
            <button class="break-button" type="submit">休憩戻</button>
        </form>
        @elseif ($status === 'finished')
            <p class="finished-text">お疲れ様でした。</p>
        @endif
    </div>
</div>



@endsection