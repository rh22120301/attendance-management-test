@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp_correction_request.css') }}">
@endsection

@section('content')
<div class="attendance-list__content">

    <div class="attendance-list__text">申請一覧</div>

    <div class="tabs">
        <a href="/stampCorrectionRequest?tab=pending"
           class="tab {{ $tab === 'pending' ? 'active' : '' }}">承認待ち</a>

        <a href="/stampCorrectionRequest?tab=approved"
           class="tab {{ $tab === 'approved' ? 'active' : '' }}">承認済み</a>
    </div>

    <div class="tab-content">
        @if ($tab === 'pending')
            @include('general.tabs.pending')
        @elseif ($tab === 'approved')
            @include('general.tabs.approved')
        @endif
    </div>

</div>
@endsection
