@extends('layouts.app')
@section('title', 'Commander')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <h4 class="fw-800 mb-4"><i class="bi bi-bag-check me-2" style="color:var(--primary)"></i>Confirmer la commande</h4>

            @if($errors->any())
            <div class="alert alert-danger rounded-3">@foreach($errors->all() as $e)<div>⚠️ {{ $e }}</div>@endforeach</div>
            @endif

            <form method="POST" action="{{ route('order.store') }}" id="orderForm">
                @csrf
                <input type="hidden" name="cart_data" id="cartDataInput">

                <!-- CLIENT INFO -->
                <div class="card border-0 shadow-sm mb-3" style="border-radius:14px;overflow:hidden;">
                    <div class="card-header fw-700 py-3" style="background:#1a1a1a;color:white;">
                        معلومات الزبون — Informations client
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600 small text-muted">الاسم الكامل *</label>
                                <input type="text" name="customer_name" class="form-control form-control-lg" required value="{{ old('customer_name') }}" placeholder="Nom complet" style="border-radius:10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600 small text-muted">الهاتف *</label>
                                <input type="text" name="customer_phone" class="form-control form-control-lg" required value="{{ old('customer_phone') }}" placeholder="05 XX XX XX XX" style="border-radius:10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600 small text-muted">الولاية *</label>
                                <select name="wilaya" class="form-select form-select-lg" required style="border-radius:10px;">
                                    <option value="">اختر الولاية</option>
                                    @php $wilayas = ['01-Adrar','02-Chlef','03-Laghouat','04-Oum El Bouaghi','05-Batna','06-Béjaïa','07-Biskra','08-Béchar','09-Blida','10-Bouira','11-Tamanrasset','12-Tébessa','13-Tlemcen','14-Tiaret','15-Tizi Ouzou','16-Alger','17-Djelfa','18-Jijel','19-Sétif','20-Saïda','21-Skikda','22-Sidi Bel Abbès','23-Annaba','24-Guelma','25-Constantine','26-Médéa','27-Mostaganem','28-M\'Sila','29-Mascara','30-Ouargla','31-Oran','32-El Bayadh','33-Illizi','34-Bordj Bou Arréridj','35-Boumerdès','36-El Tarf','37-Tindouf','38-Tissemsilt','39-El Oued','40-Khenchela','41-Souk Ahras','42-Tipaza','43-Mila','44-Aïn Defla','45-Naâma','46-Aïn Témouchent','47-Ghardaïa','48-Relizane','49-Timimoun','50-Bordj Badji Mokhtar','51-Ouled Djellal','52-Béni Abbès','53-In Salah','54-In Guezzam','55-Touggourt','56-Djanet','57-El M\'Ghair','58-El Meniaa']; @endphp
                                    @foreach($wilayas as $w)
                                    @php $parts = explode('-', $w, 2); @endphp
                                    <option value="{{ trim($parts[0]) }}" {{ old('wilaya') == trim($parts[0]) ? 'selected' : '' }}>{{ $w }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600 small text-muted">البلدية *</label>
                                <input type="text" name="commune" class="form-control form-control-lg" placeholder="Commune" required value="{{ old('commune') }}" style="border-radius:10px;">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600 small text-muted">العنوان الكامل *</label>
                                <textarea name="address" class="form-control" rows="2" required placeholder="Adresse complète" style="border-radius:10px;">{{ old('address') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600 small text-muted">نوع التوصيل *</label>
                                <div class="d-flex gap-4 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="delivery_type" value="home" id="home" checked>
                                        <label class="form-check-label fw-600" for="home">🏠 توصيل للمنزل</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="delivery_type" value="office" id="office">
                                        <label class="form-check-label fw-600" for="office">🏢 توصيل للمكتب</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600 small text-muted">ملاحظات (اختياري)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="أي ملاحظات..." style="border-radius:10px;">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ORDER ITEMS SUMMARY (small list at bottom) -->
                <div class="card border-0 shadow-sm mb-3" style="border-radius:14px;overflow:hidden;">
                    <div class="card-header fw-700 py-3" style="background:#f8f8f8;">
                        <i class="bi bi-list-ul me-2" style="color:var(--primary)"></i>Mes articles
                    </div>
                    <div id="orderItemsList" class="px-3 py-2">
                        <p class="text-muted small py-2 mb-0">Chargement...</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between fw-800" style="background:#fff8f5;">
                        <span>Total:</span>
                        <span style="color:var(--primary)" id="orderTotal">0 DZD</span>
                    </div>
                </div>

                <div class="alert" style="background:#fff8f5;border:2px solid var(--primary);border-radius:12px;">
                    <strong style="color:var(--primary)">الدفع عند الاستلام</strong> — سيتصل بك فريقنا لتأكيد الطلب
                </div>

                <button type="submit" id="submitBtn" class="btn w-100 text-white fw-800 py-3" style="background:var(--primary);border-radius:12px;font-size:1.1rem;">
                    <i class="bi bi-check-circle me-2"></i>أطلب الان — Commander
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
window.addEventListener('load', function() {
    const cart = JSON.parse(localStorage.getItem('yacinmoto_cart') || '[]');
    const container = document.getElementById('orderItemsList');
    const totalEl = document.getElementById('orderTotal');
    const cartInput = document.getElementById('cartDataInput');

    if (!cart.length) {
        container.innerHTML = '<p class="text-danger small py-2 mb-0">⚠️ Panier vide! <a href="/">Retourner au catalogue</a></p>';
        document.getElementById('submitBtn').disabled = true;
        return;
    }

    // Set cart data immediately
    cartInput.value = JSON.stringify(cart);

    let total = 0;
    let html = '';
    cart.forEach(i => {
        total += i.price * i.qty;
        html += `<div class="d-flex justify-content-between align-items-center py-2 border-bottom">
            <div>
                <span class="fw-600 small">${i.name}</span>
                <span class="text-muted small ms-2">x${i.qty}</span>
            </div>
            <span class="fw-700 small" style="color:var(--primary)">${(i.price * i.qty).toLocaleString()} DZD</span>
        </div>`;
    });

    container.innerHTML = html;
    totalEl.textContent = total.toLocaleString() + ' DZD';

    // Set cart data again before submit to be safe
    document.getElementById('orderForm').addEventListener('submit', function() {
        cartInput.value = JSON.stringify(JSON.parse(localStorage.getItem('yacinmoto_cart') || '[]'));
    });
});
</script>
@endsection
