@extends('layouts.admin')
@php
$wilayaNames = ['1'=>'Adrar','2'=>'Chlef','3'=>'Laghouat','4'=>'Oum El Bouaghi','5'=>'Batna','6'=>'Béjaïa','7'=>'Biskra','8'=>'Béchar','9'=>'Blida','10'=>'Bouira','11'=>'Tamanrasset','12'=>'Tébessa','13'=>'Tlemcen','14'=>'Tiaret','15'=>'Tizi Ouzou','16'=>'Alger','17'=>'Djelfa','18'=>'Jijel','19'=>'Sétif','20'=>'Saïda','21'=>'Skikda','22'=>'Sidi Bel Abbès','23'=>'Annaba','24'=>'Guelma','25'=>'Constantine','26'=>'Médéa','27'=>'Mostaganem','28'=>"M'Sila",'29'=>'Mascara','30'=>'Ouargla','31'=>'Oran','32'=>'El Bayadh','33'=>'Illizi','34'=>'Bordj Bou Arréridj','35'=>'Boumerdès','36'=>'El Tarf','37'=>'Tindouf','38'=>'Tissemsilt','39'=>'El Oued','40'=>'Khenchela','41'=>'Souk Ahras','42'=>'Tipaza','43'=>'Mila','44'=>'Aïn Defla','45'=>'Naâma','46'=>'Aïn Témouchent','47'=>'Ghardaïa','48'=>'Relizane','49'=>'Timimoun','50'=>'Bordj Badji Mokhtar','51'=>'Ouled Djellal','52'=>'Béni Abbès','53'=>'In Salah','54'=>'In Guezzam','55'=>'Touggourt','56'=>'Djanet','57'=>"El M'Ghair",'58'=>'El Meniaa'];
@endphp

@section('title', 'Dashboard')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Total Commandes</div>
                    <div class="fw-800 fs-3">{{ $totalOrders }}</div>
                </div>
                <div class="stat-icon" style="background:#fff3e0;"><i class="bi bi-bag" style="color:var(--primary)"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">En Attente</div>
                    <div class="fw-800 fs-3">{{ $pendingOrders }}</div>
                </div>
                <div class="stat-icon" style="background:#fff8e1;"><i class="bi bi-clock" style="color:#f59e0b"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Produits</div>
                    <div class="fw-800 fs-3">{{ $totalProducts }}</div>
                </div>
                <div class="stat-icon" style="background:#e8f5e9;"><i class="bi bi-box" style="color:#22c55e"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Revenu livré</div>
                    <div class="fw-800 fs-4" style="color:var(--primary)">{{ number_format($totalRevenue, 0) }}<small class="fs-6"> DZD</small></div>
                </div>
                <div class="stat-icon" style="background:#fff3e0;"><i class="bi bi-cash" style="color:var(--primary)"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-700 mb-0">Dernières Commandes</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
            </div>
            <table class="table">
                <thead><tr><th>#</th><th>Client</th><th>Wilaya</th><th>Total</th><th>Statut</th><th></th></tr></thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>
                            <div class="fw-600">{{ $order->customer_name }}</div>
                            <small class="text-muted">{{ $order->customer_phone }}</small>
                        </td>
                        <td><span class="small">{{ $order->wilaya }} — {{ $wilayaNames[$order->wilaya] ?? '' }}</span></td>
                        <td class="fw-700" style="color:var(--primary)">{{ number_format($order->total, 0) }} DZD</td>
                        <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">→</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6 class="fw-700 mb-3">Actions Rapides</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus me-2"></i>Ajouter un produit</a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-secondary"><i class="bi bi-tags me-2"></i>Ajouter une catégorie</a>
                <a href="{{ route('admin.orders.index') }}?status=pending" class="btn btn-outline-warning"><i class="bi bi-clock me-2"></i>Commandes en attente ({{ $pendingOrders }})</a>
            </div>
        </div>
        <div class="stat-card mt-3">
            <h6 class="fw-700 mb-3">Statut des commandes</h6>
            @foreach($orderStats as $stat)
            <div class="d-flex justify-content-between mb-2">
                <span class="badge badge-{{ $stat->status }}">{{ ucfirst($stat->status) }}</span>
                <strong>{{ $stat->count }}</strong>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
