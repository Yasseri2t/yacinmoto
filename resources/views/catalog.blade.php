@extends('layouts.app')
@section('title', 'Catalogue')
@section('content')
<div class="sections-nav">
    <div class="container">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link {{ !request('section') ? 'active' : '' }}" href="{{ route('catalog') }}">🔧 Tout</a></li>
            <li class="nav-item"><a class="nav-link {{ request('section') == 'pieces' ? 'active' : '' }}" href="{{ route('catalog', ['section' => 'pieces']) }}">⚙️ Pièces</a></li>
            <li class="nav-item"><a class="nav-link {{ request('section') == 'carenage' ? 'active' : '' }}" href="{{ route('catalog', ['section' => 'carenage']) }}">🛡️ Carénage</a></li>
            <li class="nav-item"><a class="nav-link {{ request('section') == 'moteur' ? 'active' : '' }}" href="{{ route('catalog', ['section' => 'moteur']) }}">⚡ Moteur & Électrique</a></li>
        </ul>
    </div>
</div>
<div class="container py-4">
    <form method="GET" class="row g-2 mb-4">
        @if(request('section'))<input type="hidden" name="section" value="{{ request('section') }}">@endif
        @if(request('moto'))<input type="hidden" name="moto" value="{{ request('moto') }}">@endif
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="🔍 Rechercher..." value="{{ request('search') }}" style="border-radius:10px;">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select" style="border-radius:10px;">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn w-100 text-white fw-600" style="background:var(--primary);border-radius:10px;">Filtrer</button>
        </div>
    </form>
    <div class="row g-3">
        @forelse($products as $product)
        <div class="col-6 col-md-3">
            @include('partials.product-card', ['product' => $product])
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-search fs-1 text-muted"></i>
            <p class="text-muted mt-2">Aucun produit trouvé.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
</div>
@endsection
