@extends('layouts.admin')
@section('title', 'Modifier Catégorie')
@section('content')
<div class="row justify-content-center"><div class="col-md-5">
<div class="stat-card">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label fw-600">Nom *</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}"></div>
        <button class="btn btn-primary w-100">Mettre à jour</button>
    </form>
</div>
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mt-3 w-100">← Retour</a>
</div></div>
@endsection
