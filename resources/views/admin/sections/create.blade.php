@extends('layouts.admin')
@section('title', 'Ajouter une Section')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="stat-card">
            <h6 class="fw-700 mb-4">Nouvelle Section</h6>
            <form method="POST" action="{{ route('admin.sections.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-600">Nom *</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="ex: Freinage">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600">Icône (emoji) *</label>
                    <input type="text" name="icon" class="form-control" required value="{{ old('icon') }}" placeholder="ex: 🔩">
                    <small class="text-muted">Copiez un emoji depuis emojipedia.org</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600">Ordre d'affichage</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    <small class="text-muted">0 = en premier, 1, 2, 3... pour ordonner</small>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Ajouter</button>
                    <a href="{{ route('admin.sections.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
