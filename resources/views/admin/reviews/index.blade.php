@extends('layouts.admin')
@section('title', 'Modération des avis')
@section('content')

<div class="row g-4">
    {{-- Pending reviews --}}
    <div class="col-12">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-700 mb-0">
                    ⏳ Avis en attente
                    @if($pending->count())
                        <span class="badge ms-2" style="background:var(--primary);border-radius:20px;padding:2px 10px;">
                            {{ $pending->count() }}
                        </span>
                    @endif
                </h6>
            </div>

            @if($pending->isEmpty())
                <div class="text-muted text-center py-4">
                    <i class="bi bi-check-circle fs-2 d-block mb-2" style="color:#22c55e;"></i>
                    Aucun avis en attente de modération.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produit</th>
                                <th>Auteur</th>
                                <th>Note</th>
                                <th>Commentaire</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pending as $review)
                            <tr>
                                <td>#{{ $review->id }}</td>
                                <td>
                                    <a href="{{ route('product.show', $review->product->slug) }}" target="_blank"
                                       style="color:var(--primary);text-decoration:none;">
                                        {{ Str::limit($review->product->name, 30) }}
                                    </a>
                                </td>
                                <td><strong>{{ $review->name }}</strong></td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="color:{{ $i <= $review->stars ? '#ffc107' : '#ddd' }};">★</span>
                                    @endfor
                                </td>
                                <td style="max-width:300px;">
                                    <span class="text-muted small">{{ $review->comment }}</span>
                                </td>
                                <td><small class="text-muted">{{ $review->created_at->diffForHumans() }}</small></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- Approve --}}
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-success" title="Approuver">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        {{-- Reject/delete --}}
                                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}"
                                              onsubmit="return confirm('Supprimer cet avis ?')">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-danger" title="Rejeter & supprimer">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Approved reviews --}}
    <div class="col-12">
        <div class="stat-card">
            <h6 class="fw-700 mb-3">✅ Avis approuvés (50 derniers)</h6>

            @if($approved->isEmpty())
                <p class="text-muted text-center py-3">Aucun avis approuvé pour l'instant.</p>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produit</th>
                                <th>Auteur</th>
                                <th>Note</th>
                                <th>Commentaire</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approved as $review)
                            <tr>
                                <td>#{{ $review->id }}</td>
                                <td>
                                    <a href="{{ route('product.show', $review->product->slug) }}" target="_blank"
                                       style="color:var(--primary);text-decoration:none;">
                                        {{ Str::limit($review->product->name, 30) }}
                                    </a>
                                </td>
                                <td><strong>{{ $review->name }}</strong></td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="color:{{ $i <= $review->stars ? '#ffc107' : '#ddd' }};">★</span>
                                    @endfor
                                </td>
                                <td style="max-width:300px;">
                                    <span class="text-muted small">{{ $review->comment }}</span>
                                </td>
                                <td><small class="text-muted">{{ $review->created_at->diffForHumans() }}</small></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                                          onsubmit="return confirm('Supprimer cet avis approuvé ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
