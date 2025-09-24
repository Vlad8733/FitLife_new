<table class="history-table">
  <thead>
    <tr>
      <th>Date</th>
      <th>Meal</th>
      <th>Food</th>
      <th>Quantity</th>
      <th>Calories</th>
    </tr>
  </thead>
  <tbody>
    @if($mealLogs->isEmpty())
      <tr>
        <td colspan="5" class="no-data">No meal history yet. Start logging your meals!</td>
      </tr>
    @else
      @foreach($mealLogs as $log)
        <tr>
          <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y H:i') }}</td>
          <td>{{ $log->meal }}</td>
          <td>{{ $log->food }}</td>
          <td>{{ $log->quantity }} g/ml</td>
          <td>{{ $log->calories }} kcal</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
@if(!$mealLogs->isEmpty())
  <div class="pagination" data-current-page="{{ $mealLogs->currentPage() }}" data-last-page="{{ $mealLogs->lastPage() }}">
    <a href="{{ route('foods.index', ['page' => max(1, $mealLogs->currentPage() - 1)]) }}" class="{{ $mealLogs->onFirstPage() ? 'disabled' : '' }}">Previous</a>
    @for($i = 1; $i <= $mealLogs->lastPage(); $i++)
      <a href="{{ route('foods.index', ['page' => $i]) }}" class="{{ $mealLogs->currentPage() == $i ? 'current' : '' }}">{{ $i }}</a>
    @endfor
    <a href="{{ route('foods.index', ['page' => min($mealLogs->lastPage(), $mealLogs->currentPage() + 1)]) }}" class="{{ $mealLogs->onLastPage() ? 'disabled' : '' }}">Next</a>
  </div>
@endif