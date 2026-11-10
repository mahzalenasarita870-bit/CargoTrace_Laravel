@extends('layouts.app')
@section('content')
<div class="card"><h3>Update Shipment Status</h3><form method="POST" action="{{ route('shipments.update',$shipment) }}">@csrf @method('PUT')
<div class="formrow"><label>Status</label><select name="status">@foreach(['CREATED','BOOKED','PICKED_UP','IN_TRANSIT','DELIVERED'] as $st)<option value="{{ $st }}" @selected($shipment->status===$st)>{{ $st }}</option>@endforeach</select></div>
<div class="formrow"><label>Estimated Arrival</label><input type="datetime-local" name="estimated_arrival" value="{{ $shipment->estimated_arrival?->format('Y-m-d\TH:i') }}"></div><button class="btn">Update</button> <a class="btn secondary" href="{{ route('shipments.show',$shipment) }}">Cancel</a></form></div>
@endsection
