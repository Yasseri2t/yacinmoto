@extends('layouts.admin')
@section('title', 'Prix de Livraison')
@section('content')
@if(session('success'))
    <div class="alert alert-success py-2">{{ session('success') }}</div>
@endif
<div class="stat-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-700 mb-0"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>Prix de livraison par wilaya</h6>
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
                        <th><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>Domicile (DZD)</th>
                        <th><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><rect x="2" y="3" width="20" height="18" rx="1"/><path d="M8 3v18M16 3v18M2 9h20M2 15h20"/></svg>Bureau (DZD)</th>
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
            <button type="submit" class="btn btn-primary px-5"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>Enregistrer tous les prix</button>
        </div>
    </form>
</div>
@endsection
