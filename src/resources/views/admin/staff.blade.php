@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/staff.css') }}">
@endsection

@section('content')
<div class="staff-list__content">
    <div class="staff-list__text">スタッフ一覧</div>
    <div class="staff-list__table">
        <div class="table-wrapper">
        <table class="staff-list">
            <tr class="staff-list__group">
                <th class="staff-list__title">名前</th>
                <th class="staff-list__title">メールアドレス</th>
                <th class="staff-list__title">月次勤怠</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td class="staff-list__detail">{{ $user->name }}</td>
                <td class="staff-list__detail">{{ $user->email }}</td>
                <td class="staff-list__detail">
                    <a class="staff-list__detail-link" href="{{ route('admin.attendance.staff', $user->id) }}">詳細</a>
                </td>
            </tr>      
    @endforeach
        </table>
        </div>
    </div>
</div>
</div>

@endsection