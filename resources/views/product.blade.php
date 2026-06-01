@extends('layouts.app')
@section('title', $product->name)
@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:var(--primary)">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalog') }}" style="color:var(--primary)">Catalogue</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
        <div class="row g-4">
            <div class="col-md-5">
                @if ($product->image)
                    <img src="{{ $product->image }}" id="mainImage" class="img-fluid rounded shadow"
                        style="width:100%;max-height:420px;object-fit:contain;background:#f8f8f8;padding:10px;"
                        alt="{{ $product->name }}">
                @else
                    <div class="rounded d-flex align-items-center justify-content-center"
                        style="height:350px;background:#f0f0f0;">
                        <i class="bi bi-image text-secondary" style="font-size:4rem;"></i>
                    </div>
                @endif

                @if ($product->images->count())
                    <div class="d-flex gap-2 mt-3 flex-wrap">
                        @if ($product->image)
                            <img src="{{ $product->image }}" onclick="document.getElementById('mainImage').src=this.src"
                                style="width:70px;height:70px;object-fit:contain;border-radius:8px;border:2px solid #ff6b00;background:#f8f8f8;padding:3px;cursor:pointer;">
                        @endif
                        @foreach ($product->images as $img)
                            <img src="{{ $img->url }}" onclick="document.getElementById('mainImage').src=this.src"
                                style="width:70px;height:70px;object-fit:contain;border-radius:8px;border:2px solid #ddd;background:#f8f8f8;padding:3px;cursor:pointer;"
                                onmouseover="this.style.borderColor='#ff6b00'" onmouseout="this.style.borderColor='#ddd'">
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-7">
                <small class="text-muted text-uppercase">{{ $product->category->name }}</small>
                <h2 class="fw-800 mt-1">{{ $product->name }}</h2>
                @php $avgStars = $product->reviews->count() ? round($product->reviews->avg('stars')) : 0; @endphp
                <div class="mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <span style="color:{{ $i <= $avgStars ? '#ffc107' : '#ddd' }};font-size:1.1rem;">★</span>
                    @endfor
                    <small class="text-muted ms-1">({{ $product->reviews->count() }} avis)</small>
                </div>
                <h3 style="color:var(--primary);font-weight:800;">{{ number_format($product->price, 0) }} DZD</h3>

                @if ($product->brand)
                    <p class="mb-1"><strong>Marque:</strong> {{ $product->brand }}</p>
                @endif
                @if ($product->compatible_models)
                    <p class="mb-1"><strong>Compatible:</strong> <span
                            style="color:var(--primary)">{{ $product->compatible_models }}</span></p>
                @endif
                @if ($product->description)
                    <p class="mt-3 text-muted">{{ $product->description }}</p>
                @endif

                <div class="alert mt-3 mb-3" style="background:#fff8f5;border:1px solid var(--primary);border-radius:10px;">
                    <i class="bi bi-truck me-1" style="color:var(--primary)"></i> Livraison partout en Algérie &nbsp;|&nbsp;
                    <strong style="color:var(--primary)">الدفع عند الاستلام</strong>
                </div>

                <div class="d-flex gap-2">
                    <button
                        onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ?? '' }}')"
                        class="btn btn-outline-secondary fw-600 px-3" style="border-radius:10px;">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <button
                        onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ?? '' }}'); setTimeout(()=>window.location='/order/checkout',100);"
                        class="btn text-white fw-700 flex-grow-1 py-3"
                        style="background:var(--primary);border-radius:10px;font-size:1rem;">
                        <i class="bi bi-bag-check me-2"></i>أطلب الان — Commander
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-md-7">
                <h5 class="fw-800 mb-3">Avis <span style="color:var(--primary)">clients</span></h5>
                @if ($product->reviews->count())
                    @foreach ($product->reviews as $review)
                        <div class="card mb-3 border-0 shadow-sm" style="border-radius:12px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong>{{ $review->name }}</strong>
                                    <div>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span style="color:{{ $i <= $review->stars ? '#ffc107' : '#ddd' }};">★</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted mb-1">{{ $review->comment }}</p>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-muted p-4 text-center bg-white rounded-3 shadow-sm">
                        <i class="bi bi-chat-dots fs-2 d-block mb-2"></i>
                        Aucun avis pour ce produit. Soyez le premier!
                    </div>
                @endif
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <h6 class="fw-700 mb-3">✍️ Laisser un avis</h6>
                        @if (session('success'))
                            <div class="alert alert-success py-2">✅ {{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('review.store', $product) }}">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Votre nom" required
                                    style="border-radius:8px;">
                            </div>
                            <div class="mb-3">
                                <select name="stars" class="form-select" required style="border-radius:8px;">
                                    <option value="">Note ★</option>
                                    <option value="5">★★★★★ Excellent</option>
                                    <option value="4">★★★★☆ Bien</option>
                                    <option value="3">★★★☆☆ Moyen</option>
                                    <option value="2">★★☆☆☆ Mauvais</option>
                                    <option value="1">★☆☆☆☆ Très mauvais</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea name="comment" class="form-control" rows="4" placeholder="Votre commentaire..." required
                                    style="border-radius:8px;"></textarea>
                            </div>
                            <button class="btn w-100 text-white fw-600"
                                style="background:var(--primary);border-radius:8px;">
                                Publier l'avis
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function addToCartAndOrder(id, name, price, image) {
            addToCart(id, name, price, image);
            setTimeout(() => window.location = '/order/checkout', 100);
        }
    </script>
@endsection
