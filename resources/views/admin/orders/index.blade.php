@extends('layouts.admin')
@section('title', 'Commandes')
@section('content')
<div class="stat-card">
    <!-- FILTERS -->
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">Tous les statuts</option>
                @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Chercher client..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-sm btn-primary w-100">Filtrer</button>
        </div>
    </form>

    <table class="table">
        <thead><tr><th>#</th><th>Client</th><th>Wilaya</th><th>Produits</th><th>Total</th><th>Livraison</th><th>Date</th><th>Statut</th><th></th></tr></thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>
                    <div class="fw-600">{{ $order->customer_name }}</div>
                    <small class="text-muted">{{ $order->customer_phone }}</small>
                </td>
                <td>{{ $order->wilaya }}</td>
                <td><small class="text-muted">{{ $order->items->count() }} article(s)</small></td>
                <td class="fw-700" style="color:var(--primary)">{{ number_format($order->total, 0) }} DZD</td>
                <td><small>{{ $order->delivery_type == 'home' ? '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>Domicile' : '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><rect x="2" y="3" width="20" height="18" rx="1"/><path d="M8 3v18M16 3v18M2 9h20M2 15h20"/></svg>Bureau' }}</small></td>
                <td><small>{{ $order->created_at->format('d/m H:i') }}</small></td>
                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Voir</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->withQueryString()->links() }}
</div>
@endsection
