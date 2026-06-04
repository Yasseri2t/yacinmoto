@extends('layouts.app')
@section('title', 'Accueil')
@section('content')

    <!-- SECTIONS NAV — links go to catalog page with filter applied -->
    <div class="sections-nav">
        <div class="container">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalog') }}">🔧 Tout le catalogue</a>
                </li>
                @foreach($sections as $section)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalog', ['section' => $section['slug']]) }}">
                        @if($section['slug'] == 'pieces')
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:-2px;"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
                        @elseif($section['slug'] == 'carenage')
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:-2px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        @elseif($section['slug'] == 'moteur')
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:-2px;"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        @else
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:-2px;"><circle cx="12" cy="12" r="10"/></svg>
                        @endif
                        {{ $section['name'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="container py-4">

        <!-- STORE INFO + MAP FIRST -->
        <div id="store-info" class="row g-4 mb-5">
            <div class="col-md-5">
                <div class="store-info-card h-100">
                    <h5 class="fw-800 mb-3"><i class="bi bi-shop me-2" style="color:var(--primary)"></i>Notre Boutique</h5>
                    <p class="mb-2">
                        <i class="bi bi-geo-alt me-2 text-danger"></i><strong>Adresse:</strong>
                        <a href="https://maps.app.goo.gl/gkDFCH4SBSNdnfrM7" target="_blank"
                            style="color:var(--primary);text-decoration:none;">
                            YacineMoto, Chlef, Algérie <i class="bi bi-box-arrow-up-right" style="font-size:0.75rem;"></i>
                        </a>
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-telephone me-2" style="color:var(--primary)"></i><strong>Téléphone:</strong>
                        <a href="tel:+213554164465" style="color:inherit;text-decoration:none;">+213 554 16 44 65</a>
                    </p>
                    <p class="mb-2"><i class="bi bi-clock me-2"
                            style="color:var(--primary)"></i><strong>Horaires:</strong> Sam–Jeu 8h–18h</p>
                    <p class="mb-3"><i class="bi bi-truck me-2"
                            style="color:var(--primary)"></i><strong>Livraison:</strong> Partout en Algérie</p>
                    <div class="p-3 rounded text-center mb-3" style="background:#fff8f5;border:2px dashed var(--primary);">
                        <span style="color:var(--primary);font-weight:800;font-size:1.1rem;">الدفع عند الاستلام</span><br>
                        <small class="text-muted">Cash à la livraison uniquement</small>
                    </div>
                    <a href="https://wa.me/213554164465" target="_blank"
                        class="btn w-100 fw-700 text-white"
                        style="background:#25d366;border-radius:10px;font-size:0.95rem;">
                        <i class="bi bi-whatsapp me-2"></i>Contacter sur WhatsApp
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="map-embed h-100" style="min-height:260px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3305.4!2d1.33239!3d36.15977!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12840f126d1c6097%3A0x94847109dc12df7a!2sYacineMoto!5e0!3m2!1sfr!2sdz!4v1620000000000!5m2!1sfr!2sdz"
                        width="100%" height="100%" style="border:0;border-radius:14px;min-height:260px;"
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

        <!-- PIÈCE DU JOUR -->
        @if ($pieceOfDay)
            <div class="piece-du-jour mb-5">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="badge-jour"><svg width="20" height="20" viewBox="0 0 40 40" fill="none"><polygon points="20,6 24,15 34,16 27,23 29,33 20,28 11,33 13,23 6,16 16,15" stroke="#E85D04" stroke-width="2" stroke-linejoin="round"/></svg> Pièce du Jour</div>
                        <h2 class="fw-800 mb-2">{{ $pieceOfDay->name }}</h2>
                        @if ($pieceOfDay->description)
                            <p class="mb-3" style="color:#ccc;">{{ Str::limit($pieceOfDay->description, 120) }}</p>
                        @endif
                        @if ($pieceOfDay->compatible_models)
                            <p class="small" style="color:#ff6b00;"><i class="bi bi-check-circle me-1"></i>Compatible:
                                {{ $pieceOfDay->compatible_models }}</p>
                        @endif
                        <div class="d-flex align-items-center gap-3 mt-3 flex-wrap">
                            <span class="fs-3 fw-800"
                                style="color:var(--primary)">{{ number_format($pieceOfDay->price, 0) }} DZD</span>
                            <button
                                onclick="addToCart({{ $pieceOfDay->id }}, '{{ addslashes($pieceOfDay->name) }}', {{ $pieceOfDay->price }}, '{{ $pieceOfDay->image ?? '' }}')"
                                class="btn btn-outline-light fw-600 px-3"><i class="bi bi-plus-lg"></i></button>
                            <button
                                onclick="addToCart({{ $pieceOfDay->id }}, '{{ addslashes($pieceOfDay->name) }}', {{ $pieceOfDay->price }}, '{{ $pieceOfDay->image ?? '' }}'); setTimeout(()=>window.location='/order/checkout',100);"
                                class="btn text-white fw-700 px-4" style="background:var(--primary);border-radius:10px;">
                                أطلب الان
                            </button>
                        </div>
                    </div>
                    @if ($pieceOfDay->image)
                        <div class="col-md-5 text-center mt-3 mt-md-0">
                            <img src="{{ $pieceOfDay->image }}"
                                style="max-height:220px;border-radius:12px;object-fit:contain;background:rgba(255,255,255,0.05);padding:10px;"
                                class="img-fluid">
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- FEATURED PRODUCTS -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="section-title mb-0">Nouveautés <span>exclusives</span></div>
            <a href="{{ route('catalog') }}" class="text-decoration-none fw-600" style="color:var(--primary)">Voir tout <i
                    class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-3 mb-5">
            @forelse($featured as $product)
                <div class="col-6 col-md-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @empty
                <p class="text-muted">Aucun produit disponible.</p>
            @endforelse
        </div>

        <!-- SECTIONS -->
        @foreach ($sections as $section)
            @if ($section['products']->count())
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="section-title mb-0">{{ $section['icon'] }} <span>{{ $section['name'] }}</span></div>
                        <a href="{{ route('catalog', ['section' => $section['slug']]) }}"
                            class="text-decoration-none fw-600" style="color:var(--primary)">Voir tout <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                    <div class="row g-3">
                        @foreach ($section['products'] as $product)
                            <div class="col-6 col-md-3">
                                @include('partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

    </div>
@endsection
