@extends('layouts.admin')
@section('title', 'Modifier Section')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="stat-card">
            <h6 class="fw-700 mb-4">Modifier: {{ $section->name }}</h6>
            <form method="POST" action="{{ route('admin.sections.update', $section) }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-600">Nom *</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $section->name) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600">Icône (emoji) *</label>
                    <input type="text" name="icon" class="form-control" required value="{{ old('icon', $section->icon) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600">Ordre d'affichage</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $section->sort_order) }}" min="0">
                </div>
                <div class="alert alert-warning py-2 small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Modifier le nom change aussi le slug. Les produits liés à l'ancien slug <strong>{{ $section->slug }}</strong> ne seront plus dans cette section. Mettez-les à jour manuellement.
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                    <a href="{{ route('admin.sections.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
