<div class="attendance-list__content">
    <div class="attendance-list__table">
        <div class="table-wrapper">
        <table class="attendance-list">
            <tr class="attendance-list__group">
                <th class="attendance-list__title">状態</th>
                <th class="attendance-list__title">名前</th>
                <th class="attendance-list__title">対象日時</th>
                <th class="attendance-list__title">申請理由</th>
                <th class="attendance-list__title">申請日時</th>
                <th class="attendance-list__title">詳細</th>
            </tr>
            @foreach($requests as $request)
            <tr>
                <td class="attendance-list__detail">承認待ち</td>
                <td class="attendance-list__detail">{{ $request->user->name }}</td>
                <td class="attendance-list__detail">{{ $request->attendance->work_date->format('Y/m/d') }}</td>
                <td class="attendance-list__detail">{{ $request->notes }}</td>
                <td class="attendance-list__detail">{{ $request->created_at->format('Y/m/d') }}</td>
                <td class="attendance-list__detail">
                    <a class="attendance-list__detail-link" href="/admin/stampCorrectionRequest/{{ $request->id }}">詳細</a>
                </td>
            </tr>      
        @endforeach
        </table>
        </div>
    </div>
</div>
