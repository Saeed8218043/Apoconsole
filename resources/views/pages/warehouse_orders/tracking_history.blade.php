<div class="timeline mt-3">
    @foreach($trackingHistory as $history)
    <div class="timeline-item align-items-start">
        <div class="timeline-badge">
            <i class="fa fa-check"></i> <!-- You can use different icons or just leave the circle -->
        </div>
        <div class="timeline-content">
            <div class="timeline-label">
                {{ \Carbon\Carbon::parse($history['status_date'])->format('d-m-Y h:i:s A') }}
            </div>
            <div class="timeline-details">
                {{ $history['status_details'] }}
            </div>
            @if (!empty($history['location']['city']) || !empty($history['location']['state']))
            <div class="location">
                Location: {{ $history['location']['city'] ?? '' }}, {{ $history['location']['state'] ?? '' }}
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
