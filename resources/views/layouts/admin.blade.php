<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin YacinMoto — @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #ff6b00; }
        body { background: #f5f5f5; }
        .sidebar { width: 240px; min-width: 240px; min-height: 100vh; background: #111; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .sidebar .brand { padding: 18px 20px; border-bottom: 1px solid #222; display: flex; align-items: center; gap: 10px; }
        .sidebar .brand img { height: 38px; filter: invert(1); }
        .sidebar .brand span { color: white; font-weight: 800; font-size: 1rem; }
        .sidebar .brand span b { color: var(--primary); }
        .sidebar .nav-section { padding: 10px 20px 3px; font-size: 0.68rem; text-transform: uppercase; color: #444; letter-spacing: 1px; }
        .sidebar a { color: #888; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 9px 20px; transition: all 0.2s; font-size: 0.88rem; }
        .sidebar a:hover, .sidebar a.active { color: white; background: rgba(255,107,0,0.15); border-left: 3px solid var(--primary); }
        .main-content { flex: 1; padding: 24px; }
        .topbar { background: white; border-radius: 12px; padding: 14px 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .stat-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .btn-primary { background: var(--primary) !important; border-color: var(--primary) !important; }
        .badge-pending { background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 20px; }
        .badge-confirmed { background: #d1ecf1; color: #0c5460; padding: 4px 10px; border-radius: 20px; }
        .badge-shipped { background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 20px; }
        .badge-delivered { background: #c3e6cb; color: #155724; padding: 4px 10px; border-radius: 20px; }
        .badge-cancelled { background: #f8d7da; color: #721c24; padding: 4px 10px; border-radius: 20px; }
        .table th { font-size: 0.78rem; text-transform: uppercase; color: #888; border: none; }
        .table td { vertical-align: middle; border-color: #f5f5f5; }
    </style>
    @yield('styles')
</head>
<body>
<div class="d-flex">
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="" onerror="this.style.display='none'">
            <span>Yacine<b>Moto</b></span>
        </div>
        <div class="nav-section">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag"></i> Commandes
            @php $pending = \App\Models\Order::where('status','pending')->count(); @endphp
            @if($pending)<span class="badge ms-auto" style="background:var(--primary);border-radius:20px;padding:2px 8px;font-size:0.7rem;">{{ $pending }}</span>@endif
        </a>
        <div class="nav-section">Catalogue</div>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box"></i> Produits
        </a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Catégories
        </a>
        <a href="{{ route('admin.sections.index') }}" class="{{ request()->routeIs('admin.sections.*') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Sections
        </a>
        <a href="{{ route('admin.moto-types.index') }}" class="{{ request()->routeIs('admin.moto-types.*') ? 'active' : '' }}">
            <i class="bi bi-scooter"></i> Types de Moto
        </a>
        <a href="{{ route('admin.delivery.index') }}" class="{{ request()->routeIs('admin.delivery.*') ? 'active' : '' }}">
    <i class="bi bi-truck"></i> Prix Livraison
</a>
        <div class="nav-section">Site</div>
        <a href="{{ route('home') }}" target="_blank"><i class="bi bi-globe"></i> Voir le site</a>
        <a href="{{ route('admin.logout') }}" style="color:#c00;"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </div>
    <div class="main-content">
        <div class="topbar">
            <h6 class="mb-0 fw-700">@yield('title')</h6>
            <small class="text-muted">{{ now()->format('d/m/Y H:i') }}</small>
        </div>
        @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-3"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px;margin-right:4px;"><polyline points="20 6 9 17 4 12"/></svg>{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
