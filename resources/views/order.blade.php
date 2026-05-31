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
                            <div>⚠️ {{ $e }}</div>
                        @endforeach
                    </div>
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
                                    <select name="wilaya" class="form-select form-select-lg" required style="border-radius:10px;">
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

                    <!-- CART ITEMS WITH QTY CONTROLS -->
                    <div class="card border-0 shadow-sm mb-3" style="border-radius:14px;overflow:hidden;">
                        <div class="card-header fw-700 py-3" style="background:#f8f8f8;">
                            <i class="bi bi-cart3 me-2" style="color:var(--primary)"></i>سلة المشتريات
                        </div>
                        <div id="orderItemsList" class="px-3 py-2">
                            <p class="text-muted small py-2 mb-0">Chargement...</p>
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
        let cart = JSON.parse(localStorage.getItem('yacinmoto_cart') || '[]');
        const cartInput  = document.getElementById('cartDataInput');
        const container  = document.getElementById('orderItemsList');
        const totalEl    = document.getElementById('orderTotal');
        const submitBtn  = document.getElementById('submitBtn');

        function saveCart() {
            localStorage.setItem('yacinmoto_cart', JSON.stringify(cart));
            cartInput.value = JSON.stringify(cart);
        }

        function changeQty(id, delta) {
            const item = cart.find(i => i.id == id);
            if (!item) return;
            item.qty += delta;
            if (item.qty <= 0) {
                cart = cart.filter(i => i.id != id);
            }
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
            let total = 0;
            let html = '';

            cart.forEach(i => {
                const sub = i.price * i.qty;
                total += sub;
                html += `
                <div class="d-flex align-items-center justify-content-between py-2 border-bottom gap-2">
                    <div class="d-flex align-items-center gap-2 flex-grow-1">
                        ${i.image ? `<img src="${i.image}" style="width:44px;height:44px;object-fit:contain;border-radius:8px;background:#f8f8f8;border:1px solid #eee;padding:2px;">` : ''}
                        <span class="fw-600 small">${i.name}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <button type="button" onclick="changeQty(${i.id}, -1)"
                            style="width:28px;height:28px;border-radius:50%;border:1.5px solid var(--primary);background:white;color:var(--primary);font-weight:800;font-size:1rem;line-height:1;cursor:pointer;">−</button>
                        <span class="fw-700" style="min-width:20px;text-align:center;">${i.qty}</span>
                        <button type="button" onclick="changeQty(${i.id}, 1)"
                            style="width:28px;height:28px;border-radius:50%;border:1.5px solid var(--primary);background:var(--primary);color:white;font-weight:800;font-size:1rem;line-height:1;cursor:pointer;">+</button>
                        <span class="fw-700 small ms-1" style="color:var(--primary);min-width:70px;text-align:right;">${sub.toLocaleString()} DZD</span>
                    </div>
                </div>`;
            });

            container.innerHTML = html;
            totalEl.textContent = total.toLocaleString() + ' DZD';
        }

        // Init
        saveCart();
        renderCart();

        // Re-sync on submit
        document.getElementById('orderForm').addEventListener('submit', function() {
            cartInput.value = JSON.stringify(cart);
        });
    </script>
@endsection
