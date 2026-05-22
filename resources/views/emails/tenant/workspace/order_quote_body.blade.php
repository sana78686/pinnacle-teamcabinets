@php
    $rooms = $payload['rooms'] ?? [];
@endphp
<p><strong>Quote saved:</strong> {{ $payload['quote_name'] ?? $quote->job_name }}</p>
<p><strong>Job:</strong> {{ $quote->job_name }}</p>
@if (! empty($quote->comment))
    <p>{{ $quote->comment }}</p>
@endif
<ul>
    @foreach ($rooms as $room)
        <li>
            <strong>{{ $room['room_name'] ?? 'Room' }}</strong>
            ({{ count($room['products'] ?? []) }} line(s))
        </li>
    @endforeach
</ul>
<p><strong>Estimated total:</strong> ${{ number_format((float) ($quote->grand_total_cost ?? $quote->sub_total_cost ?? $payload['totals']['grand_total_cost'] ?? $payload['totals']['sub_total_cost'] ?? 0), 2) }}</p>
