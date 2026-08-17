<!-- CONTACT -->
<input type="hidden" name="contact_id" value="{{ $contact['contact_id'] }}">
<input type="hidden" name="company_id" value="{{ $contact['company_id'] ?? '' }}">

<!-- ✅ EVENT DATA (SEND IN POST) -->
<input type="hidden" name="event_id" value="{{ $eventinfo->event_id ?? '' }}">
<input type="hidden" name="event_name" value="{{ $eventinfo->name ?? '' }}">
<input type="hidden" name="event_year" value="{{ $eventinfo->year ?? '' }}">
<input type="hidden" name="venue_details" value="{{ $eventinfo->venue_details ?? '' }}">
<input type="hidden" name="start_date" value="{{ $eventinfo->start_date ?? '' }}">
<input type="hidden" name="end_date" value="{{ $eventinfo->end_date ?? '' }}">

{{-- EVENT INFO UI --}}
<div style="padding:16px;border:1px solid #ddd;border-radius:8px;margin-bottom:16px;">

    <h2 style="margin:0 0 10px 0;">
        {{ $eventinfo->name ?? 'Event' }} ({{ $eventinfo->year ?? '' }})
    </h2>

    <p><strong>Event ID:</strong> {{ $eventinfo->event_id ?? '-' }}</p>
    <p><strong>Venue:</strong> {{ $eventinfo->venue_details ?? '-' }}</p>
    <p><strong>Booking Type:</strong> {{ $eventinfo->venue_booking_details ?? '-' }}</p>
    <p><strong>Start Date:</strong> {{ $eventinfo->start_date ?? '-' }}</p>
    <p><strong>End Date:</strong> {{ $eventinfo->end_date ?? '-' }}</p>

    @if(!empty($eventinfo->coordinator))
        <p><strong>Coordinator:</strong> {{ $eventinfo->coordinator }}</p>
    @endif

</div>