@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamp_correction_request.css') }}">
@endsection

@section('content')
<div class="attendance-list__content">
    <div class="attendance-list__text">勤怠一覧</div>

    <div class="tabs">
        <a href="/admin/stampCorrectionRequest?tab=pending"
           class="tab {{ $tab === 'pending' ? 'active' : '' }}">承認待ち</a>

        <a href="/admin/stampCorrectionRequest?tab=approved"
           class="tab {{ $tab === 'approved' ? 'active' : '' }}">承認済み</a>
    </div>

    <div class="tab-content">
        @if ($tab === 'pending')
            @include('admin.tabs.pending')
        @elseif ($tab === 'approved')
            @include('admin.tabs.approved')
        @endif
    </div>

</div>
@endsection