@extends('layouts.admin')
@section('title', 'Sections')
@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.sections.create') }}" class="btn btn-primary"><i class="bi bi-plus me-1"></i>Ajouter une section</a>
</div>
@if(session('success'))
    <div class="alert alert-success py-2">{{ session('success') }}</div>
@endif
<div class="stat-card">
    <table class="table align-middle">
        <thead>
            <tr><th>Ordre</th><th>Icône</th><th>Nom</th><th>Slug</th><th>Produits</th><th></th></tr>
        </thead>
        <tbody>
            @foreach($sections as $section)
            <tr>
                <td><span class="badge bg-secondary">{{ $section->sort_order }}</span></td>
                <td style="font-size:1.3rem;">{{ $section->icon }}</td>
                <td class="fw-600">{{ $section->name }}</td>
                <td><code>{{ $section->slug }}</code></td>
                <td>{{ $section->products()->count() }}</td>
                <td>
                    <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-sm btn-outline-warning me-1">Modifier</a>
                    <form method="POST" action="{{ route('admin.sections.destroy', $section) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette section?')">✕</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
