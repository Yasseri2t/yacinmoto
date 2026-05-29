<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YacineMoto - @yield('title', 'Pièces Scooter Algérie')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #ff6b00; --dark: #111; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8f8f8; padding-bottom: 70px; }

        /* NAVBAR */
        .navbar { background: #111 !important; padding: 8px 0; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 15px rgba(0,0,0,0.3); }
        .navbar-brand { display: flex; align-items: center; gap: 10px; }
        .navbar-brand img { height: 52px; filter: invert(1); object-fit: contain; }
        .navbar-brand span { color: white; font-size: 1.4rem; font-weight: 900; letter-spacing: 1px; }
        .navbar-brand span b { color: var(--primary); }
        .nav-link { color: #ccc !important; font-weight: 500; transition: color 0.2s; }
        .nav-link:hover { color: var(--primary) !important; }

        /* MOTO BAR */
        .moto-bar { background: #1a1a1a; padding: 8px 0; border-bottom: 2px solid var(--primary); overflow-x: auto; white-space: nowrap; scrollbar-width: none; }
        .moto-bar::-webkit-scrollbar { display: none; }
        .moto-tag { display: inline-block; color: #aaa; padding: 4px 14px; border-radius: 20px; font-size: 0.82rem; cursor: pointer; text-decoration: none; transition: all 0.2s; border: 1px solid transparent; margin: 0 2px; }
        .moto-tag:hover, .moto-tag.active { color: var(--primary); border-color: var(--primary); background: rgba(255,107,0,0.1); }

        /* SECTIONS NAV */
        .sections-nav { background: white; border-bottom: 1px solid #eee; }
        .sections-nav .nav-link { color: #555 !important; padding: 11px 18px; font-weight: 600; border-bottom: 3px solid transparent; border-radius: 0; font-size: 0.9rem; }
        .sections-nav .nav-link:hover, .sections-nav .nav-link.active { color: var(--primary) !important; border-bottom-color: var(--primary); }

        /* PRODUCT CARD */
        .product-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.07); transition: transform 0.2s, box-shadow 0.2s; position: relative; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
        .badge-exclusive { position: absolute; top: 8px; left: 8px; background: var(--primary); color: white; font-size: 0.65rem; padding: 3px 8px; border-radius: 20px; font-weight: 700; z-index: 1; }
        .no-img { width: 100%; height: 180px; background: linear-gradient(135deg, #1a1a1a, #333); display: flex; align-items: center; justify-content: center; }
        .card-body { padding: 10px 12px 12px; }
        .product-category { font-size: 0.72rem; color: #888; text-transform: uppercase; margin-bottom: 3px; }
        .product-name { font-weight: 700; font-size: 0.88rem; color: #111; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .product-price { color: var(--primary); font-weight: 800; font-size: 0.95rem; }

        /* PIÈCE DU JOUR */
        .piece-du-jour { background: linear-gradient(135deg, #111 0%, #1a1a1a 100%); border-radius: 16px; padding: 28px; color: white; position: relative; overflow: hidden; }
        .piece-du-jour::before { content: ''; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: var(--primary); opacity: 0.08; border-radius: 50%; }
        .badge-jour { background: var(--primary); color: white; padding: 4px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-block; margin-bottom: 10px; }

        /* SECTION TITLES */
        .section-title { font-weight: 800; font-size: 1.1rem; color: #111; display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
        .section-title::after { content: ''; flex: 1; height: 2px; background: #eee; }
        .section-title span { color: var(--primary); }

        /* CART SIDEBAR */
        .cart-sidebar { position: fixed; right: -400px; top: 0; width: 380px; height: 100vh; background: white; box-shadow: -5px 0 30px rgba(0,0,0,0.15); z-index: 9999; transition: right 0.3s ease; display: flex; flex-direction: column; }
        .cart-sidebar.open { right: 0; }
        .cart-header { background: #111; color: white; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; }
        .cart-items { flex: 1; overflow-y: auto; padding: 12px; }
        .cart-item { display: flex; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f0f0f0; align-items: center; }
        .cart-item img { width: 55px; height: 55px; object-fit: contain; border-radius: 8px; background: #f8f8f8; padding: 3px; }
        .cart-item-name { font-weight: 600; font-size: 0.82rem; }
        .cart-item-price { color: var(--primary); font-weight: 700; font-size: 0.85rem; }
        .cart-qty { display: flex; align-items: center; gap: 6px; margin-top: 4px; }
        .cart-qty button { background: #f0f0f0; border: none; width: 22px; height: 22px; border-radius: 50%; cursor: pointer; font-weight: 700; font-size: 0.85rem; }
        .cart-footer { padding: 16px 20px; border-top: 2px solid #f0f0f0; }

        /* FIXED BOTTOM BAR */
        .bottom-bar { position: fixed; bottom: 0; left: 0; right: 0; background: #111; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; z-index: 997; border-top: 2px solid var(--primary); }
        .bottom-bar .cart-summary { color: white; font-size: 0.85rem; }
        .bottom-bar .cart-summary span { color: var(--primary); font-weight: 800; }
        .bottom-bar .btn-cart { background: var(--primary); color: white; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 700; cursor: pointer; }
        .bottom-bar .btn-whatsapp { background: #25d366; color: white; border: none; border-radius: 8px; padding: 8px 16px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 6px; }

        /* OVERLAY */
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998; display: none; }
        .overlay.show { display: block; }

        /* STORE INFO */
        .store-info-card { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); }
        .map-embed { border-radius: 14px; overflow: hidden; }

        footer { background: #111; color: #666; padding: 24px 0; }
        footer .brand { color: white; font-weight: 900; font-size: 1.1rem; }
        footer .brand span { color: var(--primary); }
    </style>
    @yield('styles')
</head>
<body>

<div class="overlay" id="overlay" onclick="closeCart()"></div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="YacinMoto" onerror="this.style.display='none'">
            <span>Yacine<b>Moto</b></span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <i class="bi bi-list text-white fs-3"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('catalog') }}">Catalogue</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#store-info">Notre Boutique</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- MOTO TYPE BAR -->
<div class="moto-bar">
    <div class="container">
        @php
        $motos = \App\Models\MotoType::orderBy('name')->get();
        @endphp
        @foreach($motos as $moto)
        <a href="{{ route('catalog', ['moto' => $moto->slug]) }}" class="moto-tag {{ request('moto') == $moto->slug ? 'active' : '' }}">🛵 {{ $moto->name }}</a>
        @endforeach
        <a href="{{ route('catalog') }}" class="moto-tag {{ !request('moto') ? 'active' : '' }}">✨ Tous</a>
    </div>
</div>

<main>@yield('content')</main>

<!-- CART SIDEBAR -->
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-header">
        <h6 class="mb-0 fw-700"><i class="bi bi-bag me-2"></i>Mon Panier</h6>
        <button onclick="closeCart()" class="btn-close btn-close-white"></button>
    </div>
    <div class="cart-items" id="cartItems">
        <p class="text-muted text-center mt-4 small">Panier vide</p>
    </div>
    <div class="cart-footer">
        <div class="d-flex justify-content-between fw-800 mb-3">
            <span>Total:</span>
            <span style="color:var(--primary)" id="cartTotal">0 DZD</span>
        </div>
        <button onclick="checkout()" class="btn w-100 text-white fw-700 py-2" style="background:var(--primary);border-radius:10px;">
            أطلب الان — Commander
        </button>
    </div>
</div>

<!-- FIXED BOTTOM BAR -->
<div class="bottom-bar">
    <div class="cart-summary">
        🛒 <span id="bottomCount">0</span> article(s) — <span id="bottomTotal">0 DZD</span>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-cart" onclick="openCart()"><i class="bi bi-bag me-1"></i>Panier</button>
        <a href="https://wa.me/213XXXXXXXXX" class="btn-whatsapp" target="_blank">
            <i class="bi bi-whatsapp"></i> WhatsApp
        </a>
    </div>
</div>

<footer class="mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="brand mb-1">Yacine<span>Moto</span></div>
                <p class="mb-0 small">Pièces scooter — Chlef, Algérie</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <p class="mb-0 fw-700" style="color:var(--primary);">الدفع عند الاستلام 🚚</p>
                <p class="mb-0 small">Livraison partout en Algérie</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let cart = JSON.parse(localStorage.getItem('yacinmoto_cart') || '[]');

function addToCart(id, name, price, image) {
    const existing = cart.find(i => i.id === id);
    if (existing) existing.qty++;
    else cart.push({ id, name, price, image, qty: 1 });
    saveCart(); updateCartUI();
    // Flash feedback
    const btn = event.target;
    const orig = btn.innerHTML;
    btn.innerHTML = '✓'; btn.style.background = '#22c55e'; btn.style.color = 'white';
    setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; btn.style.color = ''; }, 800);
}

function removeFromCart(id) { cart = cart.filter(i => i.id !== id); saveCart(); updateCartUI(); }
function updateQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (item) { item.qty += delta; if (item.qty <= 0) removeFromCart(id); else { saveCart(); updateCartUI(); } }
}
function saveCart() { localStorage.setItem('yacinmoto_cart', JSON.stringify(cart)); }

function updateCartUI() {
    const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
    const count = cart.reduce((s, i) => s + i.qty, 0);
    document.getElementById('cartTotal').textContent = total.toLocaleString() + ' DZD';
    document.getElementById('bottomTotal').textContent = total.toLocaleString() + ' DZD';
    document.getElementById('bottomCount').textContent = count;
    const container = document.getElementById('cartItems');
    if (!cart.length) { container.innerHTML = '<p class="text-muted text-center mt-4 small">Panier vide</p>'; return; }
    container.innerHTML = cart.map(i => `
        <div class="cart-item">
            <img src="${i.image || ''}" onerror="this.src=''" alt="">
            <div style="flex:1">
                <div class="cart-item-name">${i.name}</div>
                <div class="cart-item-price">${(i.price * i.qty).toLocaleString()} DZD</div>
                <div class="cart-qty">
                    <button onclick="updateQty(${i.id},-1)">-</button>
                    <span>${i.qty}</span>
                    <button onclick="updateQty(${i.id},1)">+</button>
                    <button onclick="removeFromCart(${i.id})" style="background:#fee;color:#c00;width:auto;padding:0 6px;border-radius:4px;margin-left:4px;">✕</button>
                </div>
            </div>
        </div>`).join('');
}

function openCart() { document.getElementById('cartSidebar').classList.add('open'); document.getElementById('overlay').classList.add('show'); }
function closeCart() { document.getElementById('cartSidebar').classList.remove('open'); document.getElementById('overlay').classList.remove('show'); }
function checkout() { if (cart.length) window.location.href = '/order/checkout'; }

updateCartUI();
</script>
@yield('scripts')
</body>
</html>
