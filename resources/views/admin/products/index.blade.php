@extends('layouts.admin')
@section('title', 'Produits')
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div></div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus me-1"></i>Ajouter un
            produit</a>
    </div>
    <div class="stat-card">
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Section</th>
                    <th>Stock</th>
                    <th>Pièce du jour</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if ($product->image)
                                    <img src="{{ $product->image }}" width="45" height="45"
                                        style="object-fit:cover;border-radius:8px;">
                                @else
                                    <div style="width:45px;height:45px;background:#f0f0f0;border-radius:8px;"></div>
                                @endif
                                <div>
                                    <div class="fw-600">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->brand }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td class="fw-700" style="color:var(--primary)">{{ number_format($product->price, 0) }} DZD</td>
                        <td><span class="badge"
                                style="background:#f0f0f0;color:#333;">{{ $product->section ?? '—' }}</span></td>
                        <td>
                            @if ($product->in_stock)
                                <span class="badge" style="background:#d4edda;color:#155724;">✓ Disponible</span>
                            @else
                                <span class="badge" style="background:#f8d7da;color:#721c24;">✗ Rupture</span>
                            @endif
                        </td>
                        <td>
                            @if ($product->is_piece_of_day)
                                <span class="badge" style="background:var(--primary);color:white;">⭐ Oui</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="btn btn-sm btn-outline-warning me-1">Modifier</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Supprimer ce produit?')">✕</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

@endsection
