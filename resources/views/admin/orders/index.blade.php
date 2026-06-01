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
                <td><small>{{ $order->delivery_type == 'home' ? '🏠 Domicile' : '🏢 Bureau' }}</small></td>
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
