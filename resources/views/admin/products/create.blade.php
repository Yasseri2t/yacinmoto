@extends('layouts.admin')
@section('title', 'Ajouter un Produit')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="stat-card">
                <form method="POST" action="{{ route('admin.products.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-600">Nom du produit *</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}"
                                placeholder="ex: Filtre à air Cuxi 2">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Prix (DZD) *</label>
                            <input type="number" name="price" class="form-control" required value="{{ old('price') }}"
                                step="50" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Section *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Choisir...</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Type</label>
                            <select name="section" class="form-select">
                                <option value="">Choisir...</option>
                                @foreach($sections as $s)
                                <option value="{{ $s->slug }}" {{ old('section') == $s->slug ? 'selected' : '' }}>{{ $s->icon }} {{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Marque</label>
                            <input type="text" name="brand" class="form-control" value="{{ old('brand') }}"
                                placeholder="ex: Yamaha, Motul">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Modèles compatibles</label>
                            <select name="compatible_models_select[]" class="form-select" multiple id="motoSelect"
                                size="5">
                                @foreach ($motoTypes as $m)
                                    <option value="{{ $m->name }}">{{ $m->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Ctrl+Click pour plusieurs</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Description du produit...">{{ old('description') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Photo du produit (URL Cloudinary)</label>
                            <input type="url" name="image" class="form-control" value="{{ old('image') }}"
                                placeholder="https://res.cloudinary.com/..." id="imgInput">
                            <small class="text-muted">Uploadez l'image sur Cloudinary → copiez l'URL → collez ici</small>
                            <div id="imgPreview" class="mt-2"></div>
                        </div>
                        <div class="col-12 d-flex gap-4">
                            <div class="form-check">
                                <input type="checkbox" name="in_stock" class="form-check-input" id="in_stock" checked>
                                <label class="form-check-label fw-600" for="in_stock">✓ En stock</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="is_piece_of_day" class="form-check-input" id="pod">
                                <label class="form-check-label fw-600" for="pod">⭐ Pièce du Jour</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="compatible_models" id="compatibleHidden">
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">Ajouter le produit</button>
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
            if (this.value) {
                preview.innerHTML =
                    `<img src="${this.value}" style="width:90px;height:90px;object-fit:contain;border-radius:8px;border:2px solid #ff6b00;background:#f8f8f8;padding:4px;" onerror="this.style.display='none'">`;
            } else {
                preview.innerHTML = '';
            }
        });
        document.querySelector('form').addEventListener('submit', function() {
            const select = document.getElementById('motoSelect');
            const selected = Array.from(select.selectedOptions).map(o => o.value);
            document.getElementById('compatibleHidden').value = selected.join(', ');
            select.name = '';
        });
    </script>
@endsection
