@extends('layouts.app')
@section('title', 'Accueil')
@section('content')

    <!-- SECTIONS NAV -->
    <div class="sections-nav">
        <div class="container">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link {{ !request('section') ? 'active' : '' }}"
                        href="{{ route('home') }}">🔧 Tout</a></li>
                <li class="nav-item"><a class="nav-link {{ request('section') == 'pieces' ? 'active' : '' }}"
                        href="{{ route('home', ['section' => 'pieces']) }}">⚙️ Pièces</a></li>
                <li class="nav-item"><a class="nav-link {{ request('section') == 'carenage' ? 'active' : '' }}"
                        href="{{ route('home', ['section' => 'carenage']) }}">🛡️ Carénage</a></li>
                <li class="nav-item"><a class="nav-link {{ request('section') == 'moteur' ? 'active' : '' }}"
                        href="{{ route('home', ['section' => 'moteur']) }}">⚡ Moteur & Électrique</a></li>
            </ul>
        </div>
    </div>

    <div class="container py-4">

        <!-- STORE INFO + MAP FIRST -->
        <div id="store-info" class="row g-4 mb-5">
            <div class="col-md-5">
                <div class="store-info-card h-100">
                    <h5 class="fw-800 mb-3"><i class="bi bi-shop me-2" style="color:var(--primary)"></i>Notre Boutique</h5>
                    <p class="mb-2"><i class="bi bi-geo-alt me-2 text-danger"></i><strong>Adresse:</strong> Chlef, Algérie
                    </p>
                    <p class="mb-2"><i class="bi bi-telephone me-2"
                            style="color:var(--primary)"></i><strong>Téléphone:</strong> +213 XX XX XX XX</p>
                    <p class="mb-2"><i class="bi bi-clock me-2"
                            style="color:var(--primary)"></i><strong>Horaires:</strong> Sam–Jeu 8h–18h</p>
                    <p class="mb-3"><i class="bi bi-truck me-2"
                            style="color:var(--primary)"></i><strong>Livraison:</strong> Partout en Algérie</p>
                    <div class="p-3 rounded text-center" style="background:#fff8f5;border:2px dashed var(--primary);">
                        <span style="color:var(--primary);font-weight:800;font-size:1.1rem;">الدفع عند الاستلام</span><br>
                        <small class="text-muted">Cash à la livraison uniquement</small>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="map-embed h-100" style="min-height:260px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25704.2!2d1.3369!3d36.1655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128fb3b5555555%3A0x555555555!2sChlef%2C%20Algeria!5e0!3m2!1sfr!2sdz!4v1620000000000!5m2!1sfr!2sdz"
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
                        <div class="badge-jour">⭐ Pièce du Jour</div>
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
