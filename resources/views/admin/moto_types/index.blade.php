@extends('layouts.admin')
@section('title', 'Types de Moto')
@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.moto-types.create') }}" class="btn btn-primary"><i class="bi bi-plus me-1"></i>Ajouter</a>
</div>
<div class="stat-card">
    <table class="table">
        <thead><tr><th>#</th><th>Nom</th><th>Slug</th><th></th></tr></thead>
        <tbody>
            @foreach($motoTypes as $m)
            <tr>
                <td>{{ $m->id }}</td>
                <td class="fw-600">{{ $m->name }}</td>
                <td><code>{{ $m->slug }}</code></td>
                <td>
                    <a href="{{ route('admin.moto-types.edit', $m) }}" class="btn btn-sm btn-outline-warning me-1">Modifier</a>
                    <form method="POST" action="{{ route('admin.moto-types.destroy', $m) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer?')">✕</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
