@extends('layouts.app')
@section('title', 'Catalogue')
@section('content')
<div class="sections-nav">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ !request('section') ? 'active' : '' }}" href="{{ route('catalog', array_filter(['moto' => request('moto'), 'search' => request('search'), 'category' => request('category')])) }}"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E85D04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="9" height="9" rx="1"/><rect x="13" y="2" width="9" height="9" rx="1"/><rect x="2" y="13" width="9" height="9" rx="1"/><rect x="13" y="13" width="9" height="9" rx="1"/></svg> Tout</a>
            </li>
            @foreach($sections as $section)
            <li class="nav-item">
                <a class="nav-link {{ request('section') == $section->slug ? 'active' : '' }}"
                    href="{{ route('catalog', array_filter(['section' => $section->slug, 'moto' => request('moto'), 'search' => request('search'), 'category' => request('category')])) }}">
                    {{ $section->icon }} {{ $section->name }}
                </a>
            </li>
            @endforeach
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

    {{-- Active filters display --}}
    @if(request('moto') || request('section') || request('search') || request('category'))
    <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
        <span class="text-muted small">Filtres actifs:</span>
        @if(request('moto'))
            @php $motoName = \App\Models\MotoType::where('slug', request('moto'))->value('name'); @endphp
            <span class="badge rounded-pill" style="background:var(--primary)">🛵 {{ $motoName ?? request('moto') }}
                <a href="{{ request()->fullUrlWithQuery(['moto' => null]) }}" style="color:white;text-decoration:none;margin-left:4px;">✕</a>
            </span>
        @endif
        @if(request('section'))
            <span class="badge rounded-pill bg-secondary">{{ request('section') }}
                <a href="{{ request()->fullUrlWithQuery(['section' => null]) }}" style="color:white;text-decoration:none;margin-left:4px;">✕</a>
            </span>
        @endif
    </div>
    @endif

    <div class="row g-3">
        @forelse($products as $product)
        <div class="col-6 col-md-3">
            @include('partials.product-card', ['product' => $product])
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-search fs-1 text-muted"></i>
            <p class="text-muted mt-2">Aucun produit trouvé.</p>
            <a href="{{ route('catalog') }}" class="btn btn-outline-secondary mt-2">Voir tout le catalogue</a>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
</div>
@endsection
