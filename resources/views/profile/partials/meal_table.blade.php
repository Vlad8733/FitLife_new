<div class="table-wrapper">
    @if($mealLogs->isEmpty())
        <p style="text-align:center; padding:1rem; color:#475569;">No meals logged yet.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Meal</th>
                <th>Food</th>
                <th>Quantity (g/ml)</th>
                <th>Calories</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mealLogs as $log)
            <tr>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $log->meal }}</td>
                <td>{{ $log->food }}</td>
                <td>{{ $log->quantity }}</td>
                <td>{{ $log->calories }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper">
        {{ $mealLogs->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
