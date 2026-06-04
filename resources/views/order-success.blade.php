@extends('layouts.app')
@section('title', 'Commande confirmée')
@section('content')
@php
    $wilayaNames = config('wilayas');
    $wilayaName = $wilayaNames[$order->wilaya] ?? $order->wilaya;
@endphp
<div class="container py-5 text-center">
    <div style="font-size:4rem;">✅</div>
    <h2 class="fw-800 mt-3">!تم استلام طلبك</h2>
    <p class="lead text-muted">Merci <strong>{{ $order->customer_name }}</strong>! Votre commande a été reçue.</p>

    <div class="card mx-auto mt-4 border-0 shadow" style="max-width:460px;border-radius:16px;overflow:hidden;">
        <div class="card-header text-white fw-700 py-3" style="background:var(--primary);">
            🛵 طلبك في الطريق إليك!
        </div>
        <div class="card-body text-start p-4">
            <p class="mb-2"><strong>Wilaya:</strong> {{ $order->wilaya }} — {{ $wilayaName }}</p>
            <p class="mb-2"><strong>Livraison:</strong> {{ $order->delivery_type == 'home' ? '🏠 À domicile' : '🏢 Au bureau' }}</p>
            <p class="mb-3"><strong>Statut:</strong> <span class="badge" style="background:var(--primary);">⏳ En attente</span></p>

            {{-- Order items --}}
            <div class="border-top pt-3">
                <p class="fw-700 mb-2 small text-muted">🛒 طلبك:</p>
                @foreach($order->items as $item)
                <div class="d-flex align-items-center gap-3 mb-2">
                    @if($item->product && $item->product->image)
                    <img src="{{ $item->product->image }}"
                        style="width:48px;height:48px;object-fit:contain;border-radius:8px;background:#f8f8f8;border:1px solid #eee;padding:2px;flex-shrink:0;">
                    @endif
                    <div class="flex-grow-1">
                        <div class="fw-600 small">{{ $item->product->name ?? 'Produit' }}</div>
                        <div class="small text-muted">x{{ $item->quantity }} — {{ number_format($item->price * $item->quantity, 0) }} DZD</div>
                    </div>
                </div>
                @endforeach
                <div class="border-top pt-2 mt-2 d-flex justify-content-between fw-800">
                    <span>Total:</span>
                    <span style="color:var(--primary);">{{ number_format($order->total, 0) }} DZD</span>
                </div>
            </div>
        </div>
    </div>

    <p class="mt-4 text-muted">سنتصل بك على الرقم <strong>{{ $order->customer_phone }}</strong> لتأكيد التوصيل</p>

    <a href="{{ route('catalog') }}" class="btn text-white fw-700 mt-2 px-5 py-2"
        style="background:var(--primary);border-radius:10px;font-size:1rem;">
        ← Continuer les achats
    </a>
</div>
@endsection
@section('scripts')
<script>localStorage.removeItem('yacinmoto_cart');</script>
@endsection
