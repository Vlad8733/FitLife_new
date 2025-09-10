<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount (ml)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($waterLogs as $log)
            <tr>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $log->amount }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2">No water logs yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $waterLogs->links() }}
</div>
