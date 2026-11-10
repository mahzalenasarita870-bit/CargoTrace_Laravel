@extends('layouts.app')
@section('content')
<div class="stats">
@foreach([['Total Shipment',$stats['total']],['In Transit',$stats['in_transit']],['Delivered',$stats['delivered']],['Delayed',$stats['delayed']],['Open Exceptions',$stats['open_exceptions']]] as $item)
<div class="card"><div class="muted">{{ $item[0] }}</div><div class="stat">{{ $item[1] }}</div></div>
@endforeach
</div>
<div class="card"><div class="top"><div><h3 style="margin:0">Recent Shipments</h3><div class="muted">Ringkasan pengiriman terbaru</div></div><a class="btn" href="{{ route('shipments.create') }}">+ New Shipment</a></div>
<table><thead><tr><th>Shipment Number</th><th>Carrier</th><th>Route</th><th>Status</th><th>Expected Arrival</th><th></th></tr></thead><tbody>
@forelse($shipments as $s)<tr><td><strong>{{ $s->shipment_number }}</strong></td><td>{{ $s->carrier->name ?? '-' }}</td><td>{{ $s->origin->city ?? '-' }} → {{ $s->destination->city ?? '-' }}</td><td><span class="badge">{{ $s->status }}</span></td><td>{{ $s->expected_arrival?->format('d M Y H:i') }}</td><td><a href="{{ route('shipments.show',$s) }}">View</a></td></tr>@empty<tr><td colspan="6">Belum ada shipment.</td></tr>@endforelse
</tbody></table>{{ $shipments->links() }}</div>
@endsection
