@extends('layouts.app')
@section('title', 'Commande confirmée')
@section('content')
<div class="container py-5 text-center">
    <div style="font-size:4rem;">✅</div>
    <h2 class="fw-800 mt-3">تم استلام طلبك!</h2>
    <p class="lead text-muted">Merci <strong>{{ $order->customer_name }}</strong>! Votre commande a été reçue.</p>

    <div class="card mx-auto mt-4 border-0 shadow" style="max-width:420px;border-radius:16px;overflow:hidden;">
        <div class="card-header text-white fw-700 py-3" style="background:var(--primary);">
            🛵 طلبك في الطريق إليك!
        </div>
        <div class="card-body text-start p-4">
            <p class="mb-2"><strong>رقم الطلب:</strong> <span class="badge" style="background:var(--primary);font-size:0.9rem;">#{{ $order->id }}</span></p>
            <p class="mb-2"><strong>Total:</strong> <span style="color:var(--primary);font-weight:800;">{{ number_format($order->total, 0) }} DZD</span></p>
            <p class="mb-2"><strong>Wilaya:</strong> {{ $order->wilaya }}</p>
            <p class="mb-2"><strong>Livraison:</strong> {{ $order->delivery_type == 'home' ? '🏠 À domicile' : '🏢 Au bureau' }}</p>
            <p class="mb-0"><strong>Statut:</strong> <span class="badge" style="background:var(--primary);">⏳ En attente</span></p>
        </div>
    </div>

    <p class="mt-4 text-muted">سنتصل بك على الرقم <strong>{{ $order->customer_phone }}</strong> لتأكيد التوصيل</p>

    <a href="{{ route('catalog') }}" class="btn text-white fw-700 mt-2 px-5 py-2" style="background:var(--primary);border-radius:10px;font-size:1rem;">
        ← Continuer les achats
    </a>
</div>
@endsection
@section('scripts')
<script>localStorage.removeItem('yacinmoto_cart');</script>
@endsection
