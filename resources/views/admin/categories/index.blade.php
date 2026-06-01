@extends('layouts.admin')
@section('title', 'Catégories')
@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus me-1"></i>Ajouter</a>
</div>
<div class="stat-card">
    <table class="table">
        <thead><tr><th>#</th><th>Nom</th><th>Slug</th><th>Produits</th><th></th></tr></thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td class="fw-600">{{ $cat->name }}</td>
                <td><code>{{ $cat->slug }}</code></td>
                <td>{{ $cat->products->count() }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-warning me-1">Modifier</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer?')"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
