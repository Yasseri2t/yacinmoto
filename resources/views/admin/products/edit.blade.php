@extends('layouts.admin')
@section('title', 'Modifier: ' . $product->name)
@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="stat-card">
            <form method="POST" action="{{ route('admin.products.update', $product) }}">
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

                    {{-- Main image --}}
                    <div class="col-12">
                        <label class="form-label fw-600">Photo principale (URL Cloudinary)</label>
                        @if($product->image)
                        <div class="mb-2">
                            <img src="{{ $product->image }}" id="imgPreview" style="width:80px;height:80px;object-fit:contain;border-radius:8px;border:2px solid #ff6b00;background:#f8f8f8;padding:4px;">
                        </div>
                        @endif
                        <input type="url" name="image" class="form-control" id="imgInput"
                            value="{{ old('image', $product->image) }}"
                            placeholder="https://res.cloudinary.com/...">
                        <small class="text-muted">Laissez vide pour garder la photo actuelle</small>
                    </div>

                    {{-- Extra images --}}
                    <div class="col-12">
                        <label class="form-label fw-600">Photos supplémentaires (URLs Cloudinary)</label>
                        <textarea name="extra_images" class="form-control" rows="4" id="extraInput"
                            placeholder="Collez une URL par ligne:&#10;https://res.cloudinary.com/...&#10;https://res.cloudinary.com/...">{{ old('extra_images', $product->images->pluck('url')->implode("\n")) }}</textarea>
                        <small class="text-muted">Une URL par ligne — remplace toutes les photos supplémentaires existantes</small>
                        <div id="extraPreview" class="d-flex gap-2 flex-wrap mt-2">
                            @foreach($product->images as $img)
                            <img src="{{ $img->url }}" style="width:70px;height:70px;object-fit:contain;border-radius:8px;border:2px solid #ddd;background:#f8f8f8;padding:3px;">
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-4">
                        <div class="form-check">
                            <input type="checkbox" name="in_stock" class="form-check-input" id="in_stock" {{ $product->in_stock ? 'checked' : '' }}>
                            <label class="form-check-label fw-600" for="in_stock"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>En stock</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_piece_of_day" class="form-check-input" id="pod" {{ $product->is_piece_of_day ? 'checked' : '' }}>
                            <label class="form-check-label fw-600" for="pod"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;fill:currentColor;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>Pièce du Jour</label>
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
    document.getElementById('imgInput').addEventListener('input', function() {
        const preview = document.getElementById('imgPreview');
        if (preview) preview.src = this.value;
    });

    document.getElementById('extraInput').addEventListener('input', function() {
        const preview = document.getElementById('extraPreview');
        const urls = this.value.split('\n').map(u => u.trim()).filter(u => u);
        preview.innerHTML = urls.map(url =>
            `<img src="${url}" style="width:70px;height:70px;object-fit:contain;border-radius:8px;border:2px solid #ddd;background:#f8f8f8;padding:3px;" onerror="this.style.display='none'">`
        ).join('');
    });

    document.querySelector('form').addEventListener('submit', function() {
        const select = document.getElementById('motoSelect');
        const selected = Array.from(select.selectedOptions).map(o => o.value);
        document.getElementById('compatibleHidden').value = selected.join(', ');
        select.name = '';
    });
</script>
@endsection
