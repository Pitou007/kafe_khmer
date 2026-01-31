<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg: #f6f7fb;
            --text: #0f172a;
            --muted: #64748b;

            --brand1: #7c3aed;
            --brand2: #06b6d4;

            --shadow: 0 12px 35px rgba(2, 6, 23, .10);
            --radius: 18px;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(1200px 500px at 20% 0%, rgba(124, 58, 237, .12), transparent 60%),
                radial-gradient(900px 450px at 95% 10%, rgba(6, 182, 212, .12), transparent 55%),
                var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        .page-wrap {
            padding: 18px 0;
            position: relative;
            z-index: 2;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes softPulse {

            0%,
            100% {
                opacity: .45;
                transform: translateY(0);
            }

            50% {
                opacity: .75;
                transform: translateY(-6px);
            }
        }

        /* background blobs */
        .bg-blobs {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 999px;
            filter: blur(42px);
            opacity: .35;
            animation: softPulse 6s ease-in-out infinite;
        }

        .blob.one {
            left: -160px;
            top: -140px;
            background: rgba(124, 58, 237, .42);
        }

        .blob.two {
            right: -170px;
            top: -100px;
            background: rgba(6, 182, 212, .36);
            animation-delay: 1.4s;
        }

        .blob.three {
            left: 35%;
            bottom: -260px;
            background: rgba(124, 58, 237, .22);
            animation-delay: .8s;
        }

        .topbar {
            background: rgba(255, 255, 255, .78);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 16px;
            animation: fadeUp .55s ease both;
        }

        .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(124, 58, 237, .12), rgba(6, 182, 212, .10));
            border: 1px solid rgba(124, 58, 237, .20);
            color: #1f2937;
            font-weight: 800;
            font-size: 13px;
        }

        .card-soft {
            background: rgba(255, 255, 255, .88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp .65s ease both;
        }

        .card-head {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(15, 23, 42, .06);
            background: linear-gradient(90deg, rgba(124, 58, 237, .10), rgba(6, 182, 212, .08));
        }

        .btn {
            border-radius: 14px;
            font-weight: 800;
        }

        .btn-primary {
            border: 0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
            transition: transform .18s ease, filter .18s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        .btn-dark {
            border-radius: 14px;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            display: inline-grid;
            place-items: center;
            border-radius: 999px !important;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .90);
            box-shadow: 0 10px 22px rgba(2, 6, 23, .10);
            transition: transform .14s ease, filter .14s ease;
            color: #0f172a;
        }

        .icon-btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        .icon-edit {
            background: rgba(245, 158, 11, .12);
            border-color: rgba(245, 158, 11, .22);
        }

        .icon-del {
            background: rgba(239, 68, 68, .12);
            border-color: rgba(239, 68, 68, .22);
        }

        .table thead th {
            font-size: 12px;
            color: var(--muted);
            letter-spacing: .02em;
            border-bottom: 1px solid rgba(15, 23, 42, .08) !important;
            white-space: nowrap;
        }

        .table tbody td {
            border-top: 1px solid rgba(15, 23, 42, .06);
            vertical-align: middle;
        }

        tr.trow:hover {
            background: rgba(124, 58, 237, .06);
        }

        .muted {
            color: var(--muted);
        }

        .thumb {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            overflow: hidden;
            background: rgba(15, 23, 42, .06);
            display: grid;
            place-items: center;
            box-shadow: 0 10px 22px rgba(2, 6, 23, .10);
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .noimg {
            font-size: 11px;
            font-weight: 800;
            color: rgba(15, 23, 42, .60);
        }

        .price {
            font-weight: 900;
        }

        .stock-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 900;
            font-size: 12px;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .75);
        }

        .stock-ok {
            background: rgba(34, 197, 94, .12);
            border-color: rgba(34, 197, 94, .22);
            color: #166534;
        }

        .stock-low {
            background: rgba(245, 158, 11, .14);
            border-color: rgba(245, 158, 11, .22);
            color: #92400e;
        }

        .stock-out {
            background: rgba(239, 68, 68, .12);
            border-color: rgba(239, 68, 68, .22);
            color: #991b1b;
        }
    </style>
    @include('partials.motion-head')
</head>

<body>
    <div class="bg-blobs">
        <div class="blob one"></div>
        <div class="blob two"></div>
        <div class="blob three"></div>
    </div>

    <div class="container page-wrap">

        <!-- TOPBAR -->
        <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-box-seam me-2"></i>Products
                    </h4>
                    <span class="badge-soft">
                        <i class="bi bi-grid-1x2"></i>
                        Product inventory list
                    </span>
                </div>
                <div class="text-muted small">View • Edit • Delete products</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <span class="badge-soft">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->format('d M Y') }}
                </span>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>

                <a class="btn btn-primary btn-sm" href="{{ route('admin.products.create') }}">
                    <i class="bi bi-plus-lg"></i> Add Product
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="border-radius:16px;">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            </div>
        @endif

        <div class="card card-soft">
            <div class="card-head d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="fw-bold">
                    <i class="bi bi-list-ul me-1"></i> Product List
                </div>

                <!-- search only UI (no controller change) -->
                <div class="input-group input-group-sm" style="min-width:280px;">
                    <span class="input-group-text" style="border-radius:14px 0 0 14px;">
                        <i class="bi bi-search"></i>
                    </span>
                    <input id="pSearch" class="form-control form-control-sm" placeholder="Search name / sku ...">
                </div>
            </div>

            <div class="card-body table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:90px;">Image</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Stock</th>
                            <th class="text-end" style="width:140px;">Action</th>
                        </tr>
                    </thead>

                    <tbody id="pBody">
                        @forelse($products as $p)
                            @php
                                $sku = strtolower($p->sku ?? '');
                                $nm = strtolower($p->name ?? '');
                                $stock = (int) ($p->stock ?? 0);
                                $stockClass = $stock <= 0 ? 'stock-out' : ($stock <= 5 ? 'stock-low' : 'stock-ok');
                            @endphp

                            <tr class="trow" data-name="{{ $nm }}" data-sku="{{ $sku }}">
                                <td>
                                    <div class="thumb">
                                        @if ($p->image_path)
                                            <img src="{{ asset('storage/' . $p->image_path) }}" alt="product">
                                        @else
                                            <div class="noimg">No Image</div>
                                        @endif
                                    </div>
                                </td>

                                <td class="fw-semibold">{{ $p->name }}</td>
                                <td class="muted">{{ $p->sku ?? '-' }}</td>

                                <td class="text-end price">
                                    ${{ number_format($p->price, 2) }}
                                </td>

                                <td class="text-end">
                                    <span class="stock-pill {{ $stockClass }}">
                                        <i class="bi bi-bar-chart-fill"></i>
                                        {{ $stock }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a class="icon-btn icon-edit me-1" title="Edit"
                                        href="{{ route('admin.products.edit', $p->id) }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form class="d-inline" method="POST"
                                        action="{{ route('admin.products.delete', $p->id) }}"
                                        onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        <button class="icon-btn icon-del" title="Delete">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                    No products
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        // UI search only (no backend changes)
        const pSearch = document.getElementById('pSearch');
        const pBody = document.getElementById('pBody');

        function applyProductFilter() {
            const q = (pSearch.value || '').toLowerCase().trim();
            pBody.querySelectorAll('tr.trow').forEach(r => {
                const text = (r.dataset.name || '') + ' ' + (r.dataset.sku || '');
                r.style.display = text.includes(q) ? '' : 'none';
            });
        }

        pSearch?.addEventListener('input', applyProductFilter);
    </script>
    @include('partials.motion-scripts')
</body>

</html>

