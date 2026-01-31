<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin POS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f6f7fb;
            --text:#0f172a;
            --muted:#64748b;

            --brand1:#7c3aed;
            --brand2:#06b6d4;
            --brand3:#f97316;

            --shadow: 0 12px 35px rgba(2, 6, 23, .10);
            --radius: 18px;
        }

        body{
            min-height: 100vh;
            background:
                radial-gradient(1200px 500px at 20% 0%, rgba(124, 58, 237, .12), transparent 60%),
                radial-gradient(900px 450px at 95% 10%, rgba(6, 182, 212, .12), transparent 55%),
                var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        .page-wrap{ padding: 18px 0; }

        /* Topbar */
        .topbar{
            background: rgba(255,255,255,.78);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 16px;
            animation: fadeUp .5s ease;
        }

        .badge-soft{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(124,58,237,.12), rgba(6,182,212,.10));
            border: 1px solid rgba(124,58,237,.20);
            color: #1f2937;
            font-weight: 800;
            font-size: 13px;
        }

        /* Cards */
        .card-soft{
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform .18s ease, box-shadow .18s ease;
            animation: fadeUp .6s ease;
        }
        .card-soft:hover{
            transform: translateY(-2px);
            box-shadow: 0 18px 45px rgba(2,6,23,.12);
        }

        /* Inputs */
        .form-control, .form-select{ border-radius: 14px; }

        /* Buttons */
        .btn-primary{
            border: 0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
            transition: all .18s ease;
            border-radius: 14px;
        }
        .btn-primary:hover{ transform: translateY(-1px); filter: brightness(1.05); }

        .btn-success{
            border: 0;
            background: linear-gradient(90deg, #22c55e, #06b6d4);
            box-shadow: 0 10px 25px rgba(34,197,94,.18);
            border-radius: 14px;
            transition: all .18s ease;
        }
        .btn-success:hover{ transform: translateY(-1px); filter: brightness(1.05); }

        /* Sticky cart on desktop */
        @media (min-width: 992px){
            .sticky-cart{ position: sticky; top: 16px; }
        }

        /* Totals rows */
        .total-row{
            display:flex;
            justify-content: space-between;
            align-items:center;
            padding: 8px 0;
            color: var(--muted);
            font-weight: 700;
        }
        .total-row b{ color: var(--text); }
        .final-row{
            display:flex;
            justify-content: space-between;
            align-items:center;
            padding-top: 8px;
            font-size: 18px;
            font-weight: 950;
        }

        /* ===== Category filter buttons ===== */
        .catbar{
            display:flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .cat-btn{
            border-radius: 999px !important;
            font-weight: 800;
            padding: 6px 12px;
            border: 1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.75);
        }
        .cat-btn.active{
            border: 0;
            color: #fff;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124,58,237,.18);
        }

        /* ===== Product Grid Cards ===== */
        .product-grid{
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }
        @media (min-width: 768px){
            .product-grid{ grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        @media (min-width: 1200px){
            .product-grid{ grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }

        .p-card{
            background: rgba(255,255,255,.90);
            border: 1px solid rgba(15,23,42,.08);
            border-radius: 18px;
            box-shadow: 0 10px 28px rgba(2,6,23,.10);
            overflow: hidden;
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease;
            animation: fadeUp .45s ease;
            position: relative;
        }
        .p-card:hover{
            transform: translateY(-3px);
            box-shadow: 0 18px 45px rgba(2,6,23,.14);
        }

        .p-thumb{
            height: 120px;
            background: rgba(15,23,42,.06);
            display:flex;
            align-items:center;
            justify-content:center;
            overflow: hidden;
        }
        .p-thumb img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02);
        }

        .noimg{
            width: 100%; height: 100%;
            display:flex;
            align-items:center;
            justify-content:center;
            background: rgba(15,23,42,.08);
            color: rgba(15,23,42,.60);
            font-size: 12px;
            font-weight: 800;
        }

        .p-body{ padding: 10px 12px; }
        .p-name{
            font-weight: 900;
            font-size: 14px;
            line-height: 1.2;
            min-height: 34px;
        }
        .p-sku{
            font-size: 12px;
            color: var(--muted);
        }

        .p-meta{
            display:flex;
            align-items:center;
            justify-content: space-between;
            margin-top: 8px;
            gap: 8px;
        }

        .p-price{
            font-weight: 950;
            font-size: 15px;
            color: var(--text);
        }

        .p-stock{
            font-size: 12px;
            font-weight: 900;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid rgba(15,23,42,.08);
            background: rgba(255,255,255,.70);
            white-space: nowrap;
        }
        .p-stock.ok{ color:#166534; background: rgba(34,197,94,.12); border-color: rgba(34,197,94,.22); }
        .p-stock.low{ color:#92400e; background: rgba(245,158,11,.14); border-color: rgba(245,158,11,.22); }
        .p-stock.out{ color:#991b1b; background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.22); }

        .p-actions{
            padding: 10px 12px 12px;
            display:flex;
            justify-content: space-between;
            gap: 10px;
        }
        .p-add{
            flex: 1;
            border-radius: 14px !important;
        }
        .p-add:disabled{ opacity: .55; cursor: not-allowed; }

        /* Click success animation */
        .p-card.added{ animation: addedPop .38s ease; }
        .p-card.added::after{
            content: "✓ Added";
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 12px;
            font-weight: 950;
            color: #fff;
            padding: 6px 10px;
            border-radius: 999px;
            background: linear-gradient(90deg, #22c55e, #06b6d4);
            box-shadow: 0 10px 25px rgba(34,197,94,.18);
            animation: badgeFade .6s ease;
        }

        /* ===== Favorite (Wishlist) button on product card ===== */
        .fav-btn{
            position: absolute;
            top: 10px;
            left: 10px;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            border: 1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(10px);
            display: grid;
            place-items: center;
            cursor: pointer;
            opacity: 0;
            transform: translateY(-6px);
            transition: all .18s ease;
            z-index: 5;
            box-shadow: 0 10px 24px rgba(2,6,23,.10);
        }
        .p-card:hover .fav-btn{
            opacity: 1;
            transform: translateY(0);
        }
        .fav-btn span{
            font-size: 18px;
            line-height: 1;
            transform: translateY(1px);
        }
        .p-card.fav .fav-btn{
            opacity: 1;
            transform: translateY(0);
            border-color: rgba(239,68,68,.28);
            background: rgba(239,68,68,.10);
        }
        .p-card.fav .fav-btn span{ color: #ef4444; }

        /* Favorites row */
        .fav-row{
            display:flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 4px;
        }
        .fav-row::-webkit-scrollbar{ height: 8px; }
        .fav-row::-webkit-scrollbar-thumb{ background: rgba(15,23,42,.12); border-radius: 999px; }

        .fav-mini{
            min-width: 170px;
            max-width: 170px;
            border-radius: 18px;
            border: 1px solid rgba(15,23,42,.08);
            background: rgba(255,255,255,.85);
            box-shadow: 0 10px 24px rgba(2,6,23,.10);
            overflow: hidden;
            cursor: pointer;
            transition: transform .18s ease;
        }
        .fav-mini:hover{ transform: translateY(-2px); }
        .fav-mini .thumb{
            height: 86px;
            background: rgba(15,23,42,.06);
            overflow: hidden;
        }
        .fav-mini .thumb img{
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .fav-mini .b{ padding: 8px 10px 10px; }
        .fav-mini .t{
            font-weight: 900;
            font-size: 13px;
            line-height: 1.2;
            min-height: 32px;
        }
        .fav-mini .m{
            display:flex;
            justify-content: space-between;
            align-items:center;
            margin-top: 6px;
        }
        .fav-mini .p{ font-weight: 950; font-size: 13px; }

        /* Toast position */
        .toast-container{
            position: fixed;
            right: 16px;
            bottom: 16px;
            z-index: 2000;
        }

        /* Fly-to-cart animation */
        .fly-img{
            position: fixed;
            z-index: 5000;
            width: 56px;
            height: 56px;
            border-radius: 14px;
            object-fit: cover;
            box-shadow: 0 18px 45px rgba(2,6,23,.20);
            pointer-events: none;
            transition: transform .55s cubic-bezier(.2,.9,.1,1), opacity .55s ease;
            opacity: 1;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes addedPop{
            0%{ transform: scale(.98); }
            45%{ transform: scale(1.02); }
            100%{ transform: scale(1); }
        }
        @keyframes badgeFade{
            from{ opacity:0; transform: translateY(-6px); }
            to{ opacity:1; transform: translateY(0); }
        }
    </style>
    @include('partials.motion-head')
</head>

<body>
@php
    // Category fallback
    $categorySet = [];
    foreach ($products as $pp) {
        $c = $pp->category->name ?? ($pp->category_name ?? ($pp->category ?? 'Uncategorized'));
        $categorySet[$c] = true;
    }
    $categories = array_keys($categorySet);
    sort($categories);
@endphp

<div class="container page-wrap">

    {{-- TOPBAR --}}
    <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-bold">🧾 Admin POS</h4>
                <span class="badge-soft">☕ Kafe Khmer</span>
            </div>
            <div class="text-muted small">
                / focus search • Esc clear search • Ctrl+Backspace clear cart • Enter save • Scan SKU + Enter add
            </div>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <span class="badge-soft">📅 {{ now()->format('d M Y') }}</span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm" style="border-radius:14px;">⬅ Back</a>
        </div>
    </div>

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <b>Error:</b>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3">

        {{-- PRODUCTS --}}
        <div class="col-lg-7">
            <div class="card card-soft">
                <div class="card-body">

                    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-2">
                        <div class="fw-bold">Products</div>
                        <input id="search" class="form-control" style="max-width:360px"
                               placeholder="Search by name or SKU... (Press /)">
                    </div>

                    {{-- Favorites Row --}}
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-bold">⭐ Favorites</div>
                        <button type="button" class="btn btn-sm btn-outline-dark" style="border-radius:14px;"
                                onclick="clearFavorites()">
                            Clear Favorites
                        </button>
                    </div>
                    <div class="fav-row mb-3" id="favRow">
                        <div class="text-muted small">No favorites yet. Hover a product and click ❤️</div>
                    </div>

                    {{-- Category Filter --}}
                    <div class="catbar mb-3">
                        <button type="button" class="btn cat-btn active" data-cat="__all" onclick="setCategory('__all')">
                            All
                        </button>
                        @foreach($categories as $cat)
                            <button type="button" class="btn cat-btn" data-cat="{{ strtolower($cat) }}" onclick="setCategory('{{ strtolower($cat) }}')">
                                {{ $cat }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Product Grid --}}
                    <div class="product-grid" id="productGrid">
                        @foreach ($products as $p)
                            @php
                                $img = !empty($p->image_path) ? asset('storage/'.$p->image_path) : '';
                                $catName = $p->category->name ?? ($p->category_name ?? ($p->category ?? 'Uncategorized'));
                                $catKey = strtolower($catName);
                                $stockClass = $p->stock <= 0 ? 'out' : ($p->stock <= 5 ? 'low' : 'ok');
                            @endphp

                            <div class="p-card product-item"
                                 data-id="{{ $p->id }}"
                                 data-name="{{ strtolower($p->name) }}"
                                 data-sku="{{ strtolower($p->sku ?? '') }}"
                                 data-cat="{{ $catKey }}"
                                 onclick="addToCartWithAnim(this,
                                    {{ $p->id }},
                                    '{{ addslashes($p->name) }}',
                                    {{ (float) $p->price }},
                                    {{ (int) $p->stock }},
                                    '{{ $img }}'
                                 )">

                                {{-- Wishlist button --}}
                                <button type="button" class="fav-btn"
                                        onclick="event.stopPropagation(); toggleFavorite(this.closest('.p-card'))">
                                    <span>♡</span>
                                </button>

                                <div class="p-thumb">
                                    @if($img)
                                        <img src="{{ $img }}" alt="product">
                                    @else
                                        <div class="noimg">No Image</div>
                                    @endif
                                </div>

                                <div class="p-body">
                                    <div class="p-name">{{ $p->name }}</div>
                                    <div class="p-sku">SKU: {{ $p->sku ?? '-' }}</div>

                                    <div class="p-meta">
                                        <div class="p-price">$ {{ number_format($p->price, 2) }}</div>
                                        <span class="p-stock {{ $stockClass }}">Stock: {{ $p->stock }}</span>
                                    </div>

                                    <div class="text-muted small mt-1">Category: {{ $catName }}</div>
                                </div>

                                <div class="p-actions">
                                    <button type="button"
                                            class="btn btn-primary btn-sm p-add"
                                            {{ $p->stock <= 0 ? 'disabled' : '' }}
                                            onclick="event.stopPropagation(); addToCartWithAnim(this.closest('.p-card'),
                                                {{ $p->id }},
                                                '{{ addslashes($p->name) }}',
                                                {{ (float) $p->price }},
                                                {{ (int) $p->stock }},
                                                '{{ $img }}'
                                            )">
                                        ➕ Add
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

        {{-- CART --}}
        <div class="col-lg-5">
            <div class="sticky-cart">
                <div class="card card-soft">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0 fw-bold" id="cartTarget">🛒 Cart</h5>
                            <button class="btn btn-outline-danger btn-sm" style="border-radius:14px;"
                                    type="button"
                                    onclick="clearCart()">
                                Clear
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-2">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="cartBody">
                                <tr>
                                    <td colspan="4" class="text-muted">No items yet</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top pt-2">
                            <div class="total-row">
                                <span>
                                    Promotions
                                    <span class="text-muted small">
                                        @if ($promos->count())
                                            @foreach ($promos as $pr)
                                                <span class="badge bg-info text-dark">{{ $pr->name }}</span>
                                            @endforeach
                                        @else
                                            (No promo)
                                        @endif
                                    </span>
                                </span>
                                <b id="discountText">0.00</b>
                            </div>

                            <div class="total-row">
                                <span>Subtotal</span>
                                <b id="subtotalText">0.00</b>
                            </div>

                            <div class="mt-2">
                                <label class="form-label mb-1">Customer (optional)</label>
                                <select id="customerId" class="form-select">
                                    <option value="">-- Walk-in --</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-2">
                                <label class="form-label mb-1">Payment Type</label>
                                <select id="paymentType" class="form-select">
                                    <option value="cash">Cash</option>
                                    <option value="qr">QR</option>
                                    <option value="card">Card</option>
                                </select>
                            </div>

                            <div class="mt-2">
                                <label class="form-label mb-1">Tax</label>
                                <input id="tax" type="number" min="0" step="0.01" class="form-control" value="0">
                            </div>

                            <div class="final-row">
                                <span>Final Total</span>
                                <span>$ <b id="finalText">0.00</b></span>
                            </div>

                            <form id="posForm" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="items" id="itemsInput">
                                <input type="hidden" name="tax" id="taxInput">
                                <input type="hidden" name="payment_type" id="paymentTypeInput">
                                <input type="hidden" name="customer_id" id="customerIdInput">

                                <button type="submit" id="saveBtn" class="btn btn-success w-100" onclick="prepareSubmit(event)">
                                    ✅ Save Sale
                                </button>
                            </form>

                            <div class="text-muted small mt-2">
                                Tip: QR will go to checkout, cash/card saves directly.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 p-3 rounded-4" style="background: rgba(255,255,255,.75); border:1px solid rgba(15,23,42,.06);">
                    <div class="fw-bold mb-1">⌨️ Shortcuts</div>
                    <div class="text-muted small">
                        / focus search • Esc clear search • Ctrl+Backspace clear cart • Enter save • Scan SKU + Enter add
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Toast container --}}
<div class="toast-container" id="toastContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ==========================
    // Data
    // ==========================
    const cart = {};
    const promos = @json($promos);

    const STORE_URL = @json(route('admin.pos.store'));
    const CHECKOUT_URL = @json(route('admin.pos.checkout'));

    // ==========================
    // Helpers
    // ==========================
    function money(n) { return (Math.round(n * 100) / 100).toFixed(2); }

    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        const id = 't' + Math.random().toString(16).slice(2);

        const bg = (type === 'danger') ? 'bg-danger'
            : (type === 'warning') ? 'bg-warning text-dark'
            : (type === 'info') ? 'bg-info text-dark'
            : 'bg-success';

        const html = `
          <div id="${id}" class="toast align-items-center text-white ${bg} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body fw-semibold">${escapeHtml(message)}</div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        const el = document.getElementById(id);
        const t = new bootstrap.Toast(el, { delay: 1600 });
        t.show();
        el.addEventListener('hidden.bs.toast', () => el.remove());
    }

    function escapeHtml(str){
        return String(str || '')
            .replaceAll('&','&amp;')
            .replaceAll('<','&lt;')
            .replaceAll('>','&gt;')
            .replaceAll('"','&quot;')
            .replaceAll("'","&#039;");
    }

    // ==========================
    // Cart
    // ==========================
    function clearCart(){
        for (const k in cart) delete cart[k];
        renderCart();
        showToast('Cart cleared', 'info');
    }

    function addToCart(id, name, price, stock, imageUrl) {
        if (stock <= 0) { showToast('Out of stock', 'danger'); return false; }
        if (!cart[id]) cart[id] = { product_id:id, name, price, stock, imageUrl, qty:0 };
        if (cart[id].qty + 1 > cart[id].stock) { showToast('Not enough stock', 'warning'); return false; }
        cart[id].qty += 1;
        renderCart();
        return true;
    }

    function changeQty(id, delta) {
        if (!cart[id]) return;
        const next = cart[id].qty + delta;
        if (next <= 0) delete cart[id];
        else {
            if (next > cart[id].stock) { showToast('Not enough stock', 'warning'); return; }
            cart[id].qty = next;
        }
        renderCart();
    }

    function calcPromoDiscount(subtotal) {
        if (!promos || promos.length === 0) return 0;
        let best = 0;
        promos.forEach(p => {
            const min = parseFloat(p.min_amount ?? 0);
            if (subtotal < min) return;

            let d = 0;
            if (p.type === 'percent') d = subtotal * (parseFloat(p.value) / 100);
            else d = parseFloat(p.value);

            if (d > best) best = d;
        });
        return Math.min(best, subtotal);
    }

    function calcTotals() {
        let subtotal = 0;
        Object.values(cart).forEach(i => subtotal += i.qty * i.price);

        const tax = parseFloat((document.getElementById('tax')?.value || '0'));
        const discount = calcPromoDiscount(subtotal);
        const finalTotal = Math.max(0, subtotal - discount + tax);

        document.getElementById('subtotalText').innerText = money(subtotal);
        document.getElementById('discountText').innerText = money(discount);
        document.getElementById('finalText').innerText = money(finalTotal);
    }

    function renderCart() {
        const body = document.getElementById('cartBody');
        const items = Object.values(cart);

        if (items.length === 0) {
            body.innerHTML = `<tr><td colspan="4" class="text-muted">No items yet</td></tr>`;
            calcTotals();
            return;
        }

        body.innerHTML = items.map(i => `
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        ${ i.imageUrl
                            ? `<img src="${i.imageUrl}" style="width:45px;height:45px;object-fit:cover;border-radius:12px;box-shadow:0 10px 22px rgba(2,6,23,.10);">`
                            : `<div style="width:45px;height:45px;border-radius:12px;background:rgba(15,23,42,.08);display:flex;align-items:center;justify-content:center;font-size:11px;color:rgba(15,23,42,.60);">No</div>`
                        }
                        <div>
                            <div class="fw-semibold">${escapeHtml(i.name)}</div>
                            <div class="text-muted small">Price: ${money(i.price)} | Stock: ${i.stock}</div>
                        </div>
                    </div>
                </td>

                <td class="text-end">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary" style="border-radius:12px 0 0 12px"
                                onclick="changeQty(${i.product_id}, -1)">-</button>
                        <button type="button" class="btn btn-outline-secondary" disabled>${i.qty}</button>
                        <button type="button" class="btn btn-outline-secondary" style="border-radius:0 12px 12px 0"
                                onclick="changeQty(${i.product_id}, 1)">+</button>
                    </div>
                </td>

                <td class="text-end fw-bold">${money(i.qty*i.price)}</td>

                <td class="text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm" style="border-radius:14px;"
                        onclick="delete cart[${i.product_id}]; renderCart();">x</button>
                </td>
            </tr>
        `).join('');

        calcTotals();
    }

    // ==========================
    // Filters (category + search)
    // ==========================
    let activeCategory = "__all";

    function setCategory(catKey){
        activeCategory = catKey;
        document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
        const btn = document.querySelector(`.cat-btn[data-cat="${CSS.escape(catKey)}"]`);
        if (btn) btn.classList.add('active');
        applyFilters();
    }

    function applyFilters(){
        const q = (document.getElementById('search')?.value || '').toLowerCase().trim();
        document.querySelectorAll('#productGrid .product-item').forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const sku  = card.getAttribute('data-sku') || '';
            const cat  = card.getAttribute('data-cat') || '';

            const matchSearch = (name.includes(q) || sku.includes(q));
            const matchCat = (activeCategory === "__all" || cat === activeCategory);

            card.style.display = (matchSearch && matchCat) ? '' : 'none';
        });
    }

    document.getElementById('search')?.addEventListener('input', applyFilters);
    document.getElementById('tax')?.addEventListener('input', calcTotals);

    // ==========================
    // Favorites (Wishlist)
    // ==========================
    let favorites = new Map(); // id -> info

    function toggleFavorite(card){
        if (!card) return;

        const id = card.getAttribute('data-id');
        const name = card.querySelector('.p-name')?.innerText || '';
        const sku  = card.getAttribute('data-sku') || '';
        const cat  = card.getAttribute('data-cat') || '';
        const priceText = card.querySelector('.p-price')?.innerText || '';
        const imgEl = card.querySelector('.p-thumb img');
        const img = imgEl ? imgEl.src : '';

        const icon = card.querySelector('.fav-btn span');

        if (favorites.has(id)) {
            favorites.delete(id);
            card.classList.remove('fav');
            if (icon) icon.innerText = '♡';
            showToast('Removed from favorites', 'info');
        } else {
            favorites.set(id, { id, name, sku, cat, priceText, img });
            card.classList.add('fav');
            if (icon) icon.innerText = '♥';
            showToast('Added to favorites', 'success');
        }

        renderFavoritesRow();
    }

    function clearFavorites(){
        favorites.clear();
        document.querySelectorAll('.p-card.fav').forEach(c => {
            c.classList.remove('fav');
            const sp = c.querySelector('.fav-btn span');
            if (sp) sp.innerText = '♡';
        });
        renderFavoritesRow();
        showToast('Favorites cleared', 'info');
    }

    function renderFavoritesRow(){
        const row = document.getElementById('favRow');
        if (!row) return;

        const items = Array.from(favorites.values());
        if (items.length === 0){
            row.innerHTML = `<div class="text-muted small">No favorites yet. Hover a product and click ❤️</div>`;
            return;
        }

        row.innerHTML = items.map(p => `
            <div class="fav-mini" onclick="clickProductById('${p.id}')">
                <div class="thumb">
                    ${p.img ? `<img src="${p.img}">` : `<div class="noimg">No</div>`}
                </div>
                <div class="b">
                    <div class="t">${escapeHtml(p.name)}</div>
                    <div class="m">
                        <div class="p">${escapeHtml(p.priceText)}</div>
                        <span class="badge bg-light text-dark" style="border:1px solid rgba(15,23,42,.10);border-radius:999px;">⭐</span>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function clickProductById(id){
        const card = document.querySelector(`#productGrid .product-item[data-id="${CSS.escape(id)}"]`);
        if (card) card.click();
    }

    // ==========================
    // Fly-to-cart
    // ==========================
    function flyToCart(fromCard){
        const imgEl = fromCard?.querySelector('.p-thumb img');
        const target = document.getElementById('cartTarget');
        if (!imgEl || !target) return;

        const r1 = imgEl.getBoundingClientRect();
        const r2 = target.getBoundingClientRect();

        const clone = document.createElement('img');
        clone.src = imgEl.src;
        clone.className = 'fly-img';
        clone.style.left = (r1.left + window.scrollX) + 'px';
        clone.style.top  = (r1.top  + window.scrollY) + 'px';
        document.body.appendChild(clone);

        requestAnimationFrame(() => {
            const dx = (r2.left + window.scrollX) - (r1.left + window.scrollX);
            const dy = (r2.top  + window.scrollY) - (r1.top  + window.scrollY);
            clone.style.transform = `translate(${dx}px, ${dy}px) scale(0.35)`;
            clone.style.opacity = '0.2';
        });

        setTimeout(() => clone.remove(), 600);
    }

    // ==========================
    // Add with animation + toast
    // ==========================
    function addToCartWithAnim(cardEl, id, name, price, stock, imageUrl){
        const ok = addToCart(id, name, price, stock, imageUrl);
        if (!ok) return;

        flyToCart(cardEl);
        showToast(`Added: ${name}`, 'success');

        if (cardEl) {
            cardEl.classList.remove('added');
            void cardEl.offsetWidth;
            cardEl.classList.add('added');
            setTimeout(() => cardEl.classList.remove('added'), 700);
        }
    }

    // ==========================
    // Submit
    // ==========================
    function prepareSubmit(e) {
        e.preventDefault();

        const items = Object.values(cart).map(i => ({ product_id: i.product_id, qty: i.qty }));
        if (items.length === 0) { showToast('Cart is empty', 'danger'); return; }

        const paymentType = document.getElementById('paymentType').value;

        document.getElementById('itemsInput').value = JSON.stringify(items);
        document.getElementById('taxInput').value = document.getElementById('tax').value || 0;
        document.getElementById('paymentTypeInput').value = paymentType;
        document.getElementById('customerIdInput').value = document.getElementById('customerId').value || '';

        document.getElementById('posForm').action = (paymentType === 'qr') ? CHECKOUT_URL : STORE_URL;
        document.getElementById('posForm').submit();
    }

    // ==========================
    // Keyboard + Barcode scan
    // ==========================
    const searchEl = document.getElementById('search');
    const saveBtn = document.getElementById('saveBtn');

    let scanBuffer = "";
    let lastKeyTime = 0;

    function isTypingTarget(el){
        if (!el) return false;
        const tag = (el.tagName || '').toLowerCase();
        return tag === 'input' || tag === 'textarea' || tag === 'select' || el.isContentEditable;
    }

    function findCardBySKU(skuLower){
        return document.querySelector(`#productGrid .product-item[data-sku="${CSS.escape(skuLower)}"]`);
    }

    function addBySKU(sku){
        const skuLower = (sku || '').toLowerCase().trim();
        if (!skuLower) return false;

        const card = findCardBySKU(skuLower);
        if (!card) { showToast(`SKU not found: ${sku}`, 'danger'); return false; }

        card.click();
        return true;
    }

    document.addEventListener('keydown', (e) => {
        // / focus search
        if (e.key === '/' && !isTypingTarget(e.target)) {
            e.preventDefault();
            searchEl?.focus();
            return;
        }

        // Esc clear search + scan buffer
        if (e.key === 'Escape') {
            if (searchEl) {
                searchEl.value = '';
                applyFilters();
                if (document.activeElement === searchEl) searchEl.blur();
                showToast('Search cleared', 'info');
            }
            scanBuffer = '';
            return;
        }

        // Ctrl + Backspace clear cart
        if (e.ctrlKey && e.key === 'Backspace') {
            e.preventDefault();
            clearCart();
            return;
        }

        // Enter: if scanBuffer exists -> add by SKU, else save (when not typing)
        if (e.key === 'Enter' && !isTypingTarget(e.target)) {
            if (scanBuffer.trim().length > 0) {
                const sku = scanBuffer.trim();
                scanBuffer = '';
                addBySKU(sku);
                return;
            }
            e.preventDefault();
            saveBtn?.click();
            return;
        }

        // barcode buffer: fast typing outside inputs
        const now = Date.now();
        const fast = (now - lastKeyTime) < 40;
        lastKeyTime = now;

        if (!isTypingTarget(e.target)) {
            if (e.key.length === 1 && /[a-zA-Z0-9\-_]/.test(e.key)) {
                if (!fast) scanBuffer = "";
                scanBuffer += e.key;
            }
        }
    });

</script>

    @include('partials.motion-scripts')
</body>
</html>

