@extends('layouts.admin')
@php $wilayaNames = config('wilayas'); @endphp
@section('title', 'Commandes')
@section('content')
<div class="stat-card">

    {{-- FILTERS --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">Tous les statuts</option>
                @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="period" class="form-select form-select-sm">
                <option value="">Toutes les périodes</option>
                <option value="today"  {{ request('period') == 'today'  ? 'selected' : '' }}>Aujourd'hui</option>
                <option value="week"   {{ request('period') == 'week'   ? 'selected' : '' }}>Cette semaine</option>
                <option value="month"  {{ request('period') == 'month'  ? 'selected' : '' }}>Ce mois</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Chercher client..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-sm btn-primary w-100">Filtrer</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
        </div>
    </form>

    {{-- BULK CLEAR --}}
    <div class="d-flex justify-content-end mb-2">
        <form method="POST" action="{{ route('admin.orders.bulk-clear') }}"
              onsubmit="return confirm('Supprimer toutes les commandes livrées et annulées ?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">🗑 Vider archivées</button>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Wilaya</th>
                <th>Produits</th>
                <th>Total</th>
                <th>Livraison</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    #{{ $order->id }}
                    @if($order->status == 'pending' && $order->created_at->diffInHours(now()) > 24)
                        <span class="badge bg-danger" style="font-size:0.6rem;">⚠ Urgent</span>
                    @endif
                </td>
                <td>
                    <div class="fw-600">{{ $order->customer_name }}</div>
                    <small class="text-muted">{{ $order->customer_phone }}</small>
                </td>
                <td><small>{{ $wilayaNames[$order->wilaya] ?? $order->wilaya }}</small></td>
                <td><small class="text-muted">{{ $order->items->count() }} article(s)</small></td>
                <td class="fw-700" style="color:var(--primary)">{{ number_format($order->total, 0) }} DZD</td>
                <td><small>{{ $order->delivery_type == 'home' ? '🏠 Domicile' : '🏢 Bureau' }}</small></td>
                <td><small>{{ $order->created_at->format('d/m H:i') }}</small></td>
                <td>
                    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                        @csrf @method('PUT')
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width:110px">
                            @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td class="d-flex gap-1">
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Voir</a>
                    <a href="https://wa.me/213{{ ltrim($order->customer_phone, '0') }}?text=Bonjour%20{{ urlencode($order->customer_name) }}%2C%20votre%20commande%20%23{{ $order->id }}%20est%20en%20cours!"
                       target="_blank" class="btn btn-sm btn-success">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                          onsubmit="return confirm('Supprimer la commande #{{ $order->id }} ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">✕</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->withQueryString()->links() }}
</div>
@endsection
