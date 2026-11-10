@extends('layouts.app')
@section('content')
<div class="grid"><div class="card"><h3>Tracking Timeline</h3><h4>{{ $shipment->shipment_number }}</h4>
@forelse($shipment->trackingEvents as $event)<div style="border-left:3px solid #2563eb;padding:0 0 18px 14px;margin:14px 0"><b>{{ $event->event_type }}</b><div class="muted">{{ $event->occurred_at->format('d M Y H:i') }} • {{ $event->location->city ?? 'Location not set' }}</div><div>{{ $event->description }}</div></div>@empty<p class="muted">Belum ada tracking event.</p>@endforelse</div>
<div class="card"><h3>Add Tracking Event</h3><form method="POST" action="{{ route('tracking.store',$shipment) }}">@csrf
<div class="formrow"><label>Event Type</label><select name="event_type">@foreach(['BOOKED','PICKED_UP','IN_TRANSIT','DELIVERED','CUSTOMS_HOLD','WEATHER_DELAY'] as $ev)<option>{{ $ev }}</option>@endforeach</select></div>
<div class="formrow"><label>Occurred At</label><input type="datetime-local" name="occurred_at" required></div>
<div class="formrow"><label>Location</label><select name="location_id"><option value="">-- select --</option>@foreach($locations as $l)<option value="{{ $l->id }}">{{ $l->city }}, {{ $l->country }}</option>@endforeach</select></div>
<div class="formrow"><label>Description</label><textarea name="description" required></textarea></div><button class="btn">Add Event</button></form></div></div>
@endsection
