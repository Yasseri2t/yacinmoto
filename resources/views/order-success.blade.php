@extends('layouts.app')
@section('title', 'Commande confirmée')
@section('content')
@php
$wilayaNames = ['1'=>'Adrar','2'=>'Chlef','3'=>'Laghouat','4'=>'Oum El Bouaghi','5'=>'Batna','6'=>'Béjaïa','7'=>'Biskra','8'=>'Béchar','9'=>'Blida','10'=>'Bouira','11'=>'Tamanrasset','12'=>'Tébessa','13'=>'Tlemcen','14'=>'Tiaret','15'=>'Tizi Ouzou','16'=>'Alger','17'=>'Djelfa','18'=>'Jijel','19'=>'Sétif','20'=>'Saïda','21'=>'Skikda','22'=>'Sidi Bel Abbès','23'=>'Annaba','24'=>'Guelma','25'=>'Constantine','26'=>'Médéa','27'=>'Mostaganem','28'=>"M'Sila",'29'=>'Mascara','30'=>'Ouargla','31'=>'Oran','32'=>'El Bayadh','33'=>'Illizi','34'=>'Bordj Bou Arréridj','35'=>'Boumerdès','36'=>'El Tarf','37'=>'Tindouf','38'=>'Tissemsilt','39'=>'El Oued','40'=>'Khenchela','41'=>'Souk Ahras','42'=>'Tipaza','43'=>'Mila','44'=>'Aïn Defla','45'=>'Naâma','46'=>'Aïn Témouchent','47'=>'Ghardaïa','48'=>'Relizane','49'=>'Timimoun','50'=>'Bordj Badji Mokhtar','51'=>'Ouled Djellal','52'=>'Béni Abbès','53'=>'In Salah','54'=>'In Guezzam','55'=>'Touggourt','56'=>'Djanet','57'=>"El M'Ghair",'58'=>'El Meniaa'];
$wilayaName = $wilayaNames[$order->wilaya] ?? $order->wilaya;
@endphp
<div class="container py-5 text-center">
    <div style="margin-bottom:8px;"><svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#25c16f" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg></div>
    <h2 class="fw-800 mt-3">!تم استلام طلبك</h2>
    <p class="lead text-muted">Merci <strong>{{ $order->customer_name }}</strong>! Votre commande a été reçue.</p>

    <div class="card mx-auto mt-4 border-0 shadow" style="max-width:460px;border-radius:16px;overflow:hidden;">
        <div class="card-header text-white fw-700 py-3" style="background:var(--primary);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>طلبك في الطريق إليك!
        </div>
        <div class="card-body text-start p-4">
            <p class="mb-2"><strong>Wilaya:</strong> {{ $order->wilaya }} — {{ $wilayaName }}</p>
            <p class="mb-2"><strong>Livraison:</strong> {{ $order->delivery_type == 'home' ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>À domicile' : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><rect x="2" y="3" width="20" height="18" rx="1"/><path d="M8 3v18M16 3v18M2 9h20M2 15h20"/></svg>Au bureau' }}</p>
            <p class="mb-3"><strong>Statut:</strong> <span class="badge" style="background:var(--primary);">⏳ En attente</span></p>

            {{-- Order items --}}
            <div class="border-top pt-3">
                <p class="fw-700 mb-2 small text-muted"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>طلبك:</p>
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
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>Continuer les achats
    </a>
</div>
@endsection
@section('scripts')
<script>localStorage.removeItem('yacinmoto_cart');</script>
@endsection
