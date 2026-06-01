@extends('layouts.admin')
@section('title', 'Prix de Livraison')
@section('content')
@if(session('success'))
    <div class="alert alert-success py-2">{{ session('success') }}</div>
@endif
<div class="stat-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-700 mb-0">💰 Prix de livraison par wilaya</h6>
        <small class="text-muted">DZD — modifiez et cliquez Enregistrer</small>
    </div>
    <form method="POST" action="{{ route('admin.delivery.update') }}">
        @csrf @method('PUT')
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead style="background:#f8f8f8;">
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Wilaya</th>
                        <th>🏠 Domicile (DZD)</th>
                        <th>🏢 Bureau (DZD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prices as $p)
                    <tr>
                        <td class="text-muted small">{{ $p->wilaya_number }}</td>
                        <td class="fw-600 small">{{ $p->wilaya_name }}</td>
                        <td>
                            <input type="number" name="home_price[{{ $p->id }}]"
                                value="{{ $p->home_price }}" min="0" step="50"
                                class="form-control form-control-sm" style="width:90px;">
                        </td>
                        <td>
                            <input type="number" name="office_price[{{ $p->id }}]"
                                value="{{ $p->office_price }}" min="0" step="50"
                                class="form-control form-control-sm" style="width:90px;">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary px-5">💾 Enregistrer tous les prix</button>
        </div>
    </form>
</div>
@endsection
