@extends('layouts.app')
@section('title', 'Commander')
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <h4 class="fw-800 mb-4"><i class="bi bi-bag-check me-2" style="color:var(--primary)"></i>Confirmer la commande</h4>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        @foreach ($errors->all() as $e)
                            <div><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>{{ $e }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('order.store') }}" id="orderForm">
                    @csrf
                    <input type="hidden" name="cart_data" id="cartDataInput">
                    <input type="hidden" name="delivery_cost" id="deliveryCostInput" value="0">

                    <!-- CLIENT INFO -->
                    <div class="card border-0 shadow-sm mb-3" style="border-radius:14px;overflow:hidden;">
                        <div class="card-header fw-700 py-3" style="background:#1a1a1a;color:white;">
                            معلومات الزبون — Informations client
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small text-muted">الاسم الكامل *</label>
                                    <input type="text" name="customer_name" class="form-control form-control-lg" required
                                        value="{{ old('customer_name') }}" placeholder="Nom complet" style="border-radius:10px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small text-muted">الهاتف *</label>
                                    <input type="text" name="customer_phone" class="form-control form-control-lg"
                                        required value="{{ old('customer_phone') }}" placeholder="05 XX XX XX XX" style="border-radius:10px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small text-muted">الولاية *</label>
                                    <select name="wilaya" id="wilayaSelect" class="form-select form-select-lg" required style="border-radius:10px;">
                                        <option value="">اختر الولاية</option>
                                        @php $wilayas = ['01-Adrar','02-Chlef','03-Laghouat','04-Oum El Bouaghi','05-Batna','06-Béjaïa','07-Biskra','08-Béchar','09-Blida','10-Bouira','11-Tamanrasset','12-Tébessa','13-Tlemcen','14-Tiaret','15-Tizi Ouzou','16-Alger','17-Djelfa','18-Jijel','19-Sétif','20-Saïda','21-Skikda','22-Sidi Bel Abbès','23-Annaba','24-Guelma','25-Constantine','26-Médéa','27-Mostaganem','28-M\'Sila','29-Mascara','30-Ouargla','31-Oran','32-El Bayadh','33-Illizi','34-Bordj Bou Arréridj','35-Boumerdès','36-El Tarf','37-Tindouf','38-Tissemsilt','39-El Oued','40-Khenchela','41-Souk Ahras','42-Tipaza','43-Mila','44-Aïn Defla','45-Naâma','46-Aïn Témouchent','47-Ghardaïa','48-Relizane','49-Timimoun','50-Bordj Badji Mokhtar','51-Ouled Djellal','52-Béni Abbès','53-In Salah','54-In Guezzam','55-Touggourt','56-Djanet','57-El M\'Ghair','58-El Meniaa']; @endphp
                                        @foreach ($wilayas as $w)
                                            @php $parts = explode('-', $w, 2); @endphp
                                            <option value="{{ trim($parts[0]) }}" {{ old('wilaya') == trim($parts[0]) ? 'selected' : '' }}>{{ $w }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small text-muted">البلدية *</label>
                                    <input type="text" name="commune" class="form-control form-control-lg"
                                        placeholder="Commune" required value="{{ old('commune') }}" style="border-radius:10px;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-600 small text-muted">العنوان الكامل *</label>
                                    <textarea name="address" class="form-control" rows="2" required placeholder="Adresse complète"
                                        style="border-radius:10px;">{{ old('address') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-600 small text-muted">نوع التوصيل *</label>
                                    <div class="d-flex gap-4 mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="delivery_type" value="home" id="home" checked>
                                            <label class="form-check-label fw-600" for="home"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>توصيل للمنزل</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="delivery_type" value="office" id="office">
                                            <label class="form-check-label fw-600" for="office"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><rect x="2" y="3" width="20" height="18" rx="1"/><path d="M8 3v18M16 3v18M2 9h20M2 15h20"/></svg>توصيل للمكتب</label>
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

                    <!-- CART ITEMS -->
                    <div class="card border-0 shadow-sm mb-3" style="border-radius:14px;overflow:hidden;">
                        <div class="card-header fw-700 py-3" style="background:#f8f8f8;">
                            <i class="bi bi-cart3 me-2" style="color:var(--primary)"></i>سلة المشتريات
                        </div>
                        <div id="orderItemsList" class="px-3 py-2"></div>
                        <div class="px-3 pb-1 pt-0" id="deliveryRow" style="display:none;">
                            <div class="d-flex justify-content-between py-2 text-muted small border-top">
                                <span id="deliveryLabel"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>Livraison</span>
                                <span id="deliveryCostDisplay">— DZD</span>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between fw-800 py-3" style="background:#fff8f5;">
                            <span>Total:</span>
                            <span style="color:var(--primary);font-size:1.1rem;" id="orderTotal">0 DZD</span>
                        </div>
                    </div>

                    <div class="alert" style="background:#fff8f5;border:2px solid var(--primary);border-radius:12px;">
                        <strong style="color:var(--primary)">الدفع عند الاستلام</strong> — سيتصل بك فريقنا لتأكيد الطلب
                    </div>

                    <button type="submit" id="submitBtn" class="btn w-100 text-white fw-800 py-3"
                        style="background:var(--primary);border-radius:12px;font-size:1.1rem;">
                        <i class="bi bi-check-circle me-2"></i>أطلب الان — Commander
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let cart = JSON.parse(localStorage.getItem('yacinmoto_cart') || '[]');
    let deliveryCost = 0;
    let productTotal = 0;

    const cartInput     = document.getElementById('cartDataInput');
    const delivInput    = document.getElementById('deliveryCostInput');
    const container     = document.getElementById('orderItemsList');
    const totalEl       = document.getElementById('orderTotal');
    const submitBtn     = document.getElementById('submitBtn');
    const deliveryRow   = document.getElementById('deliveryRow');
    const delivLabel    = document.getElementById('deliveryLabel');
    const delivDisplay  = document.getElementById('deliveryCostDisplay');
    const wilayaSelect  = document.getElementById('wilayaSelect');
    const delivTypeRadios = document.querySelectorAll('input[name="delivery_type"]');

    function saveCart() {
        localStorage.setItem('yacinmoto_cart', JSON.stringify(cart));
        cartInput.value = JSON.stringify(cart);
    }

    function changeQty(id, delta) {
        const item = cart.find(i => i.id == id);
        if (!item) return;
        item.qty += delta;
        if (item.qty <= 0) cart = cart.filter(i => i.id != id);
        saveCart();
        renderCart();
    }

    function renderCart() {
        if (!cart.length) {
            container.innerHTML = '<p class="text-danger small py-3 mb-0 text-center">⚠️ سلتك فارغة! <a href="/">اختر منتجات</a></p>';
            submitBtn.disabled = true;
            totalEl.textContent = '0 DZD';
            return;
        }
        submitBtn.disabled = false;
        productTotal = 0;
        let html = '';
        cart.forEach(i => {
            const sub = i.price * i.qty;
            productTotal += sub;
            html += `
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom gap-2">
                <div class="d-flex align-items-center gap-2 flex-grow-1 overflow-hidden">
                    ${i.image ? `<img src="${i.image}" style="width:44px;height:44px;object-fit:contain;border-radius:8px;background:#f8f8f8;border:1px solid #eee;padding:2px;flex-shrink:0;">` : ''}
                    <span class="fw-600 small text-truncate">${i.name}</span>
                </div>
                <div class="d-flex align-items-center gap-1 flex-shrink-0">
                    <button type="button" onclick="changeQty(${i.id},-1)"
                        style="width:28px;height:28px;border-radius:50%;border:1.5px solid var(--primary);background:white;color:var(--primary);font-weight:800;font-size:1rem;cursor:pointer;">−</button>
                    <span class="fw-700 small" style="min-width:20px;text-align:center;">${i.qty}</span>
                    <button type="button" onclick="changeQty(${i.id},1)"
                        style="width:28px;height:28px;border-radius:50%;border:1.5px solid var(--primary);background:var(--primary);color:white;font-weight:800;font-size:1rem;cursor:pointer;">+</button>
                    <span class="fw-700 small ms-2" style="color:var(--primary);min-width:75px;text-align:right;">${sub.toLocaleString()} DZD</span>
                </div>
            </div>`;
        });
        container.innerHTML = html;
        updateTotal();
    }

    function updateTotal() {
        const grand = productTotal + deliveryCost;
        totalEl.textContent = grand.toLocaleString() + ' DZD';
        delivInput.value = deliveryCost;
    }

    function fetchDeliveryPrice() {
        const wilaya = wilayaSelect.value;
        const type = document.querySelector('input[name="delivery_type"]:checked')?.value || 'home';
        if (!wilaya) { deliveryRow.style.display = 'none'; deliveryCost = 0; updateTotal(); return; }

        fetch(`/delivery-price/${wilaya}`)
            .then(r => r.json())
            .then(data => {
                deliveryCost = type === 'home' ? parseFloat(data.home_price) : parseFloat(data.office_price);
                delivLabel.textContent = type === 'home' ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>Livraison domicile' : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><rect x="2" y="3" width="20" height="18" rx="1"/><path d="M8 3v18M16 3v18M2 9h20M2 15h20"/></svg>Livraison bureau';
                delivDisplay.textContent = deliveryCost.toLocaleString() + ' DZD';
                deliveryRow.style.display = 'block';
                updateTotal();
            })
            .catch(() => { deliveryCost = 0; updateTotal(); });
    }

    wilayaSelect.addEventListener('change', fetchDeliveryPrice);
    delivTypeRadios.forEach(r => r.addEventListener('change', fetchDeliveryPrice));

    // expose changeQty globally for onclick
    window.changeQty = changeQty;

    saveCart();
    renderCart();

    document.getElementById('orderForm').addEventListener('submit', function() {
        cartInput.value = JSON.stringify(cart);
        delivInput.value = deliveryCost;
    });
});
</script>
@endsection
