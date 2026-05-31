@extends('layouts.admin')
@section('title', 'Modifier: ' . $product->name)
@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="stat-card">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-600">Nom du produit *</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name', $product->name) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Prix (DZD) *</label>
                        <input type="number" name="price" class="form-control" required value="{{ old('price', $product->price) }}" step="50">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Section *</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Type</label>
                        <select name="section" class="form-select">
                                <option value="">Choisir...</option>
                                @foreach($sections as $s)
                                <option value="{{ $s->slug }}" {{ (old('section', $product->section ?? '') == $s->slug) ? 'selected' : '' }}>{{ $s->icon }} {{ $s->name }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Marque</label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Modèles compatibles</label>
                        @php $currentModels = array_map('trim', explode(',', $product->compatible_models ?? '')); @endphp
                        <select name="compatible_models_select[]" class="form-select" multiple id="motoSelect" size="5">
                            @foreach($motoTypes as $m)
                            <option value="{{ $m->name }}" {{ in_array($m->name, $currentModels) ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Ctrl+Click pour plusieurs</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">Changer la photo</label>
                        @if($product->image)
                        <div class="mb-2"><img src="{{ $product->image }}" style="width:80px;height:80px;object-fit:contain;border-radius:8px;border:2px solid #ff6b00;background:#f8f8f8;padding:4px;"></div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12 d-flex gap-4">
                        <div class="form-check">
                            <input type="checkbox" name="in_stock" class="form-check-input" id="in_stock" {{ $product->in_stock ? 'checked' : '' }}>
                            <label class="form-check-label fw-600" for="in_stock">✓ En stock</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_piece_of_day" class="form-check-input" id="pod" {{ $product->is_piece_of_day ? 'checked' : '' }}>
                            <label class="form-check-label fw-600" for="pod">⭐ Pièce du Jour</label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="compatible_models" id="compatibleHidden">
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Mettre à jour</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.querySelector('form').addEventListener('submit', function() {
    const select = document.getElementById('motoSelect');
    const selected = Array.from(select.selectedOptions).map(o => o.value);
    document.getElementById('compatibleHidden').value = selected.join(', ');
    select.name = '';
});
</script>
@endsection
