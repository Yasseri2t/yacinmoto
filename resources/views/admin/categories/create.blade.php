@extends('layouts.admin')
@section('title', 'Ajouter Catégorie')
@section('content')
<div class="row justify-content-center"><div class="col-md-5">
<div class="stat-card">
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="mb-3"><label class="form-label fw-600">Nom *</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="ex: Freins, Moteur..."></div>
        <button class="btn btn-primary w-100">Ajouter</button>
    </form>
</div>
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mt-3 w-100"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>Retour</a>
</div></div>
@endsection
