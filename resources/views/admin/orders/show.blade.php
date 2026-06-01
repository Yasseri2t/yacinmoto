@extends('layouts.admin')
@section('title', 'Commande #' . $order->id)
@section('content')
<div class="row g-3">
    <div class="col-md-5">
        <div class="stat-card">
            <h6 class="fw-700 mb-3"><i class="bi bi-person me-2"></i>Client</h6>
            <p class="mb-1"><strong>Nom:</strong> {{ $order->customer_name }}</p>
            <p class="mb-1"><strong>Tél:</strong> <a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a></p>
            @if($order->customer_phone2)<p class="mb-1"><strong>Tél 2:</strong> {{ $order->customer_phone2 }}</p>@endif
            <p class="mb-1"><strong>Wilaya:</strong> {{ $order->wilaya }}</p>
            <p class="mb-1"><strong>Commune:</strong> {{ $order->commune ?? '—' }}</p>
            <p class="mb-1"><strong>Adresse:</strong> {{ $order->address }}</p>
            <p class="mb-1"><strong>Livraison:</strong> {{ $order->delivery_type == 'home' ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>Domicile' : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><rect x="2" y="3" width="20" height="18" rx="1"/><path d="M8 3v18M16 3v18M2 9h20M2 15h20"/></svg>Bureau' }}</p>
            @if($order->notes)<p class="mb-0"><strong>Notes:</strong> {{ $order->notes }}</p>@endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6 class="fw-700 mb-3"><i class="bi bi-arrow-repeat me-2"></i>Changer Statut</h6>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf @method('PUT')
                <select name="status" class="form-select mb-3">
                    @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary w-100">Mettre à jour</button>
            </form>
            <hr>
            <a href="https://wa.me/213{{ ltrim($order->customer_phone, '0') }}?text=Bonjour%20{{ urlencode($order->customer_name) }}%2C%20votre%20commande%20%23{{ $order->id }}%20est%20confirm%C3%A9e!" target="_blank" class="btn btn-success w-100">
                <i class="bi bi-whatsapp me-2"></i>Contacter sur WhatsApp
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="text-muted small mb-1">Total Commande</div>
            <div class="fw-800 fs-2" style="color:var(--primary)">{{ number_format($order->total, 0) }}</div>
            <div class="text-muted">DZD</div>
            <hr>
            <div class="badge badge-{{ $order->status }} fs-6 px-3 py-2">{{ ucfirst($order->status) }}</div>
            <div class="text-muted small mt-2">{{ $order->created_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>
</div>

<div class="stat-card mt-3">
    <h6 class="fw-700 mb-3"><i class="bi bi-box me-2"></i>Produits commandés</h6>
    <table class="table">
        <thead><tr><th>Produit</th><th>Prix unitaire</th><th>Quantité</th><th>Total</th></tr></thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        @if($item->product->image)
                        <img src="{{ $item->product->image }}" width="40" height="40" style="object-fit:cover;border-radius:6px;">
                        @endif
                        <div>
                            <div class="fw-600">{{ $item->product->name }}</div>
                            <small class="text-muted">{{ $item->product->category->name }}</small>
                        </div>
                    </div>
                </td>
                <td>{{ number_format($item->price, 0) }} DZD</td>
                <td>{{ $item->quantity }}</td>
                <td class="fw-700" style="color:var(--primary)">{{ number_format($item->price * $item->quantity, 0) }} DZD</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><td colspan="3" class="fw-800 text-end">Total:</td><td class="fw-800 fs-5" style="color:var(--primary)">{{ number_format($order->total, 0) }} DZD</td></tr>
        </tfoot>
    </table>
</div>
<a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary mt-3"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>Retour</a>
@endsection
