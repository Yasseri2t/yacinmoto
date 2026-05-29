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
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mt-3 w-100">← Retour</a>
</div></div>
@endsection
