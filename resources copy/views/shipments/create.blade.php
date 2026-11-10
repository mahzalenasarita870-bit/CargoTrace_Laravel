@extends('layouts.app')
@section('content')
<div class="card"><h3>Create Shipment</h3><form method="POST" action="{{ route('shipments.store') }}">@csrf
<div class="grid">
<div class="formrow"><label>Customer ID</label><input type="number" name="customer_id" required value="{{ old('customer_id',3) }}"></div>
<div class="formrow"><label>Carrier</label><select name="carrier_id" required>@foreach($carriers as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
<div class="formrow"><label>Origin</label><select name="origin_id" required>@foreach($locations as $l)<option value="{{ $l->id }}">{{ $l->city }}, {{ $l->country }}</option>@endforeach</select></div>
<div class="formrow"><label>Destination</label><select name="destination_id" required>@foreach($locations as $l)<option value="{{ $l->id }}">{{ $l->city }}, {{ $l->country }}</option>@endforeach</select></div>
<div class="formrow"><label>Cargo Type</label><input name="cargo_type" required placeholder="Electronics, Documents..."></div>
<div class="formrow"><label>Weight (kg)</label><input type="number" step=".01" name="weight_kg" required></div>
<div class="formrow"><label>Expected Departure</label><input type="datetime-local" name="expected_departure" required></div>
<div class="formrow"><label>Expected Arrival</label><input type="datetime-local" name="expected_arrival" required></div></div><button class="btn">Save Shipment</button> <a class="btn secondary" href="{{ route('shipments.index') }}">Cancel</a></form></div>
@endsection
