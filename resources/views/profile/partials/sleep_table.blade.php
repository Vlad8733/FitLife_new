<div class="table-wrapper">
    @if($sleepLogs->isEmpty())
        <p style="text-align:center; padding:1rem; color:#475569;">No sleep records yet.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration (h)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sleepLogs as $sleep)
            <tr>
                <td>{{ $sleep->date }}</td>
                <td>{{ $sleep->start_time }}</td>
                <td>{{ $sleep->end_time }}</td>
                <td>{{ round($sleep->duration, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper">
        {{ $sleepLogs->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
