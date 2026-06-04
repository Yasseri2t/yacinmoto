<div class="product-card h-100" style="cursor:pointer;"
    onclick="window.location='{{ route('product.show', $product->slug) }}'">
    @if ($product->is_piece_of_day ?? false)
        <div class="badge-exclusive"><svg width="14" height="14" viewBox="0 0 40 40"><defs><linearGradient id="gold" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FFD700"/><stop offset="50%" stop-color="#FFA500"/><stop offset="100%" stop-color="#FFD700"/></linearGradient></defs><polygon points="20,6 24,15 34,16 27,23 29,33 20,28 11,33 13,23 6,16 16,15" fill="url(#gold)"/></svg> EXCLUSIF</div>
    @endif
    @if ($product->image)
        <img src="{{ $product->image }}" alt="{{ $product->name }}"
            style="width:100%;height:180px;object-fit:contain;background:#f8f8f8;padding:8px;">
    @else
        <div class="no-img"><i class="bi bi-image text-secondary fs-1"></i></div>
    @endif
    <div class="card-body">
        <div class="product-category">{{ $product->category->name }}</div>
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price mb-2">{{ number_format($product->price, 0) }} DZD</div>
        <div class="d-flex gap-2" onclick="event.stopPropagation()">
            <button
                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ?? '' }}')"
                class="btn btn-outline-secondary fw-700"
                style="border-radius:8px;width:40px;padding:0;height:36px;">+</button>
            <button
                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ?? '' }}'); setTimeout(()=>window.location='/order/checkout',100);"
                class="btn text-white fw-600 flex-grow-1"
                style="background:var(--primary);border-radius:8px;font-size:0.8rem;">
                أطلب الان
            </button>
        </div>
    </div>
</div>
