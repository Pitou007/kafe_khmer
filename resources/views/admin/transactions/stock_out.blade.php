<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stock Out</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f6f7fb;
            --text:#0f172a;
            --muted:#64748b;

            --brand1:#7c3aed;
            --brand2:#06b6d4;

            --warn1:#f59e0b;
            --warn2:#f97316;

            --shadow: 0 12px 35px rgba(2, 6, 23, .10);
            --radius: 18px;
        }

        body{
            min-height:100vh;
            background:
                radial-gradient(1200px 500px at 20% 0%, rgba(124, 58, 237, .12), transparent 60%),
                radial-gradient(900px 450px at 95% 10%, rgba(6, 182, 212, .12), transparent 55%),
                var(--bg);
            color: var(--text);
        }

        .topbar{
            background: rgba(255,255,255,.78);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 16px;
        }

        .badge-soft{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(245,158,11,.14), rgba(249,115,22,.10));
            border: 1px solid rgba(245,158,11,.22);
            color: #1f2937;
            font-weight: 900;
            font-size: 13px;
        }

        .card-soft{
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-head{
            padding: 16px 18px;
            background: linear-gradient(90deg, rgba(245,158,11,.16), rgba(249,115,22,.10));
            border-bottom: 1px solid rgba(15,23,42,.06);
        }

        .muted{ color: var(--muted); }

        .form-control, .form-select{
            border-radius: 14px;
            border-color: rgba(15,23,42,.12);
        }
        .form-control:focus, .form-select:focus{
            box-shadow: 0 0 0 .2rem rgba(245,158,11,.18);
            border-color: rgba(245,158,11,.35);
        }

        /* Warning gradient button */
        .btn-warn{
            border: 0;
            background: linear-gradient(90deg, var(--warn1), var(--warn2));
            box-shadow: 0 10px 25px rgba(245,158,11,.18);
            transition: all .18s ease;
            border-radius: 14px;
            font-weight: 900;
            color: #111827;
        }
        .btn-warn:hover{ transform: translateY(-1px); filter: brightness(1.04); }

        .btn-dark, .btn-outline-dark, .btn-outline-danger{
            border-radius: 14px;
            font-weight: 800;
        }

        /* Qty stepper */
        .qty-wrap{
            display:flex;
            align-items:center;
            border: 1px solid rgba(15,23,42,.12);
            border-radius: 14px;
            overflow: hidden;
            background: rgba(255,255,255,.9);
        }
        .qty-btn{
            width: 44px;
            height: 42px;
            border: 0;
            background: rgba(15,23,42,.04);
            font-weight: 900;
            transition: .15s ease;
        }
        .qty-btn:hover{ background: rgba(245,158,11,.12); }
        .qty-input{
            border: 0 !important;
            border-left: 1px solid rgba(15,23,42,.10) !important;
            border-right: 1px solid rgba(15,23,42,.10) !important;
            text-align:center;
            width: 90px;
            height: 42px;
            font-weight: 900;
            background: transparent;
        }
        .qty-input:focus{ outline: none; box-shadow:none; }

        /* Input icon */
        .icon-input{ position: relative; }
        .icon-input .icon{
            position:absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            opacity: .65;
            font-size: 14px;
        }
        .icon-input input{ padding-left: 34px; }

        /* Toast position */
        .toast-container{
            position: fixed;
            right: 16px;
            bottom: 16px;
            z-index: 2000;
        }

        /* Small inline warning panel */
        .warn-panel{
            border-radius: 16px;
            border: 1px solid rgba(245,158,11,.18);
            background: rgba(245,158,11,.10);
            padding: 12px 14px;
        }
    </style>
    @include('partials.motion-head')
</head>

<body class="bg-light">

<div class="container py-4">

    {{-- TOPBAR --}}
    <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-bold">📤 Stock Out</h4>
                <span class="badge-soft">Reduce stock</span>
            </div>
            <div class="muted small">Use this when items leave inventory (usage, sold outside POS, etc).</div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-dark btn-sm">⬅ Back</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Card --}}
    <div class="card card-soft">
        <div class="card-head">
            <div class="fw-bold">New Stock Out</div>
            <div class="muted small">Choose product → set qty → note reason.</div>
        </div>

        <div class="card-body p-4">
            <div class="warn-panel mb-3">
                <div class="fw-bold">⚠️ Important</div>
                <div class="muted small">Qty cannot be greater than current stock. (We also validate in backend.)</div>
            </div>

            <form id="stockOutForm" method="POST" action="{{ route('admin.transactions.out.store') }}" class="row g-3">
                @csrf

                {{-- Product --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Product</label>
                    <select id="productSelect" name="product_id" class="form-select" required>
                        <option value="">-- choose product --</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}" data-stock="{{ (int)$p->stock }}">
                                {{ $p->name }} ({{ $p->sku ?? '-' }}) — stock: {{ $p->stock }}
                            </option>
                        @endforeach
                    </select>
                    <div class="muted small mt-1" id="stockHint">Select a product to see current stock.</div>
                </div>

                {{-- Qty --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Qty</label>
                    <div class="qty-wrap">
                        <button class="qty-btn" type="button" onclick="stepQty(-1)">−</button>
                        <input id="qtyInput" class="qty-input" type="number" name="qty" min="1" value="1" required>
                        <button class="qty-btn" type="button" onclick="stepQty(1)">+</button>
                    </div>
                    <div class="muted small mt-1" id="qtyHint">Minimum 1</div>
                </div>

                {{-- Note --}}
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Note</label>
                    <div class="icon-input">
                        <span class="icon">🧾</span>
                        <input id="noteInput" type="text" name="note" class="form-control" placeholder="reason...">
                    </div>
                </div>

                {{-- Actions --}}
                <div class="col-12 d-flex gap-2 flex-wrap mt-2">
                    <button id="saveBtn" class="btn btn-warn px-4" type="submit">
                        <span class="btn-text">📤 Save Stock Out</span>
                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>

                    <button class="btn btn-outline-danger" type="button" onclick="resetFormNice()">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<div class="toast-container" id="toastContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function escapeHtml(str){
        return String(str || '')
            .replaceAll('&','&amp;')
            .replaceAll('<','&lt;')
            .replaceAll('>','&gt;')
            .replaceAll('"','&quot;')
            .replaceAll("'","&#039;");
    }

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
        const t = new bootstrap.Toast(el, { delay: 1700 });
        t.show();
        el.addEventListener('hidden.bs.toast', () => el.remove());
    }

    // Qty stepper
    function stepQty(delta){
        const el = document.getElementById('qtyInput');
        const cur = parseInt(el.value || '1', 10);
        const next = Math.max(1, cur + delta);
        el.value = next;
        validateQty();
    }

    // Stock hint + qty max validation (front-end helper)
    const productSelect = document.getElementById('productSelect');
    const stockHint = document.getElementById('stockHint');
    const qtyHint = document.getElementById('qtyHint');
    const qtyInput = document.getElementById('qtyInput');

    function getSelectedStock(){
        const opt = productSelect?.options?.[productSelect.selectedIndex];
        const stock = parseInt(opt?.getAttribute('data-stock') || '0', 10);
        return isNaN(stock) ? 0 : stock;
    }

    function validateQty(){
        const stock = getSelectedStock();
        const qty = parseInt(qtyInput.value || '1', 10);

        if (!productSelect.value){
            qtyHint.innerHTML = 'Minimum 1';
            qtyInput.classList.remove('is-invalid');
            return;
        }

        if (qty > stock){
            qtyHint.innerHTML = `⚠️ Qty too high. Max stock: <b>${escapeHtml(stock)}</b>`;
            qtyInput.classList.add('is-invalid');
        } else {
            qtyHint.innerHTML = `Max available: <b>${escapeHtml(stock)}</b>`;
            qtyInput.classList.remove('is-invalid');
        }
    }

    productSelect?.addEventListener('change', () => {
        const stock = getSelectedStock();
        stockHint.innerHTML = `Current stock: <b>${escapeHtml(stock)}</b>`;
        validateQty();
        if (productSelect.value) showToast('Product selected', 'info');
    });

    qtyInput?.addEventListener('input', validateQty);

    function resetFormNice(){
        document.getElementById('stockOutForm').reset();
        qtyInput.value = 1;
        stockHint.innerHTML = 'Select a product to see current stock.';
        qtyHint.innerHTML = 'Minimum 1';
        qtyInput.classList.remove('is-invalid');
        showToast('Form reset', 'info');
    }

    // Loading button on submit
    const form = document.getElementById('stockOutForm');
    const saveBtn = document.getElementById('saveBtn');

    form?.addEventListener('submit', (e) => {
        // optional client check
        validateQty();
        if (qtyInput.classList.contains('is-invalid')) {
            e.preventDefault();
            showToast('Qty cannot be greater than current stock', 'danger');
            return;
        }

        const spinner = saveBtn.querySelector('.spinner-border');
        const text = saveBtn.querySelector('.btn-text');
        spinner.classList.remove('d-none');
        text.textContent = 'Saving...';
        saveBtn.disabled = true;
    });
</script>

    @include('partials.motion-scripts')
</body>
</html>

