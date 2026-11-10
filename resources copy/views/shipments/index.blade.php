@extends('layouts.app')
@section('content')
<div class="card"><div class="top"><h3>Shipments</h3><a class="btn" href="{{ route('shipments.create') }}">+ Create Shipment</a></div>
<form method="GET" style="display:flex;gap:10px"><input name="search" placeholder="Cari nomor shipment..." value="{{ request('search') }}"><select name="status"><option value="">Semua status</option>@foreach(['CREATED','BOOKED','PICKED_UP','IN_TRANSIT','DELIVERED'] as $st)<option value="{{ $st }}" @selected(request('status')===$st)>{{ $st }}</option>@endforeach</select><button class="btn">Filter</button></form>
<table><thead><tr><th>Shipment Number</th><th>Customer</th><th>Carrier</th><th>Route</th><th>Status</th><th>Actions</th></tr></thead><tbody>
@forelse($shipments as $s)<tr><td>{{ $s->shipment_number }}</td><td>{{ $s->customer->name ?? '-' }}</td><td>{{ $s->carrier->name ?? '-' }}</td><td>{{ $s->origin->city ?? '-' }} → {{ $s->destination->city ?? '-' }}</td><td><span class="badge">{{ $s->status }}</span></td><td><a href="{{ route('shipments.show',$s) }}">Detail</a> · <a href="{{ route('shipments.edit',$s) }}">Edit</a></td></tr>@empty<tr><td colspan="6">Data tidak ditemukan.</td></tr>@endforelse
</tbody></table>{{ $shipments->links() }}</div>
@endsection
