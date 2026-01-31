<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stock Report</title>

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

        /* animated blobs */
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

        .btn-outline-secondary {
            border-radius: 14px;
            font-weight: 800;
        }

        .form-control {
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .10);
        }

        .form-control:focus {
            border-color: rgba(124, 58, 237, .35);
            box-shadow: 0 0 0 .2rem rgba(124, 58, 237, .12);
        }

        /* summary stat cards */
        .stat {
            background: rgba(255, 255, 255, .88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 14px;
            animation: fadeUp .7s ease both;
            display: flex;
            gap: 12px;
            align-items: center;
            min-height: 86px;
        }

        .stat .icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(90deg, rgba(124, 58, 237, .14), rgba(6, 182, 212, .12));
            border: 1px solid rgba(124, 58, 237, .18);
        }

        .stat .label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
        }

        .stat .value {
            font-size: 22px;
            font-weight: 950;
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

        .trow:hover {
            background: rgba(124, 58, 237, .06);
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .75);
            border: 1px solid rgba(15, 23, 42, .08);
            font-weight: 800;
            color: #111827;
        }

        /* stock badge (no emoji) */
        .stock-badge {
            font-weight: 900;
            border-radius: 999px;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(15, 23, 42, .10);
        }

        .stock-badge.low {
            background: rgba(239, 68, 68, .12);
            border-color: rgba(239, 68, 68, .22);
            color: #991b1b;
        }

        .stock-badge.ok {
            background: rgba(34, 197, 94, .12);
            border-color: rgba(34, 197, 94, .22);
            color: #166534;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            display: inline-block;
        }

        .dot.low {
            background: #ef4444;
        }

        .dot.ok {
            background: #22c55e;
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
                    <h4 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Stock Report</h4>
                    <span class="badge-soft"><i class="bi bi-shield-check"></i> Admin</span>
                </div>
                <div class="text-muted small">Search products and view current stock</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <span class="badge-soft"><i class="bi bi-calendar3"></i> {{ now()->format('d M Y') }}</span>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- SEARCH -->
        <div class="card card-soft mb-3">
            <div class="card-head d-flex justify-content-between align-items-center gap-2">
                <div class="fw-bold"><i class="bi bi-search me-1"></i> Search</div>
                <span class="chip"><i class="bi bi-lightning-charge"></i> Quick filter</span>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.stock') }}" class="d-flex flex-wrap gap-2">
                    <div class="flex-grow-1">
                        <input name="q" class="form-control" placeholder="Search by name or SKU..."
                            value="{{ $q }}">
                    </div>
                    <button class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.reports.stock') }}">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </a>
                </form>
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="stat">
                    <div class="icon"><i class="bi bi-collection"></i></div>
                    <div>
                        <div class="label">Total Stock Items</div>
                        <div class="value">{{ number_format($totalItems) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat">
                    <div class="icon"><i class="bi bi-cash-stack"></i></div>
                    <div>
                        <div class="label">Estimated Stock Value</div>
                        <div class="value">{{ number_format($estimatedValue, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card card-soft">
            <div class="card-head d-flex justify-content-between align-items-center">
                <div class="fw-bold"><i class="bi bi-list-check me-1"></i> Products</div>
                <span class="chip"><i class="bi bi-info-circle"></i> Results: {{ $products->count() }}</span>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Stock</th>
                            <th class="text-end">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                            <tr class="trow">
                                <td class="text-muted">{{ $p->id }}</td>
                                <td class="fw-semibold">{{ $p->name }}</td>
                                <td class="text-muted">{{ $p->sku ?? '-' }}</td>
                                <td class="text-end">{{ number_format($p->price, 2) }}</td>
                                <td class="text-end">
                                    @php $low = ($p->stock <= 5); @endphp
                                    <span class="stock-badge {{ $low ? 'low' : 'ok' }}">
                                        <span class="dot {{ $low ? 'low' : 'ok' }}"></span>
                                        {{ $p->stock }}
                                    </span>
                                </td>
                                <td class="text-end fw-bold">{{ number_format($p->price * $p->stock, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4 text-center">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @include('partials.motion-scripts')
</body>

</html>

