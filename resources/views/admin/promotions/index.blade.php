<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Promotions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f6f7fb;
            --text:#0f172a;
            --muted:#64748b;
            --brand1:#7c3aed;
            --brand2:#06b6d4;
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

        .bg-blobs{
            position: fixed;
            inset: 0;
            pointer-events:none;
            z-index: 0;
            overflow:hidden;
        }
        .blob{
            position:absolute;
            width: 520px;
            height: 520px;
            border-radius: 999px;
            filter: blur(42px);
            opacity: .35;
            animation: softPulse 6s ease-in-out infinite;
        }
        .blob.one{ left:-160px; top:-140px; background: rgba(124,58,237,.42); }
        .blob.two{ right:-170px; top:-100px; background: rgba(6,182,212,.36); animation-delay: 1.4s; }
        .blob.three{ left:35%; bottom:-260px; background: rgba(124,58,237,.22); animation-delay: .8s; }

        .page-wrap{ padding: 18px 0; position: relative; z-index: 2; }

        @keyframes fadeUp{
            from{ opacity:0; transform: translateY(18px); }
            to{ opacity:1; transform: translateY(0); }
        }
        @keyframes softPulse{
            0%,100%{ opacity:.45; transform: translateY(0); }
            50%{ opacity:.75; transform: translateY(-6px); }
        }

        .topbar{
            background: rgba(255,255,255,.78);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 16px;
            animation: fadeUp .55s ease both;
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

        .card-soft{
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp .65s ease both;
        }

        .card-head{
            padding: 14px 16px;
            border-bottom: 1px solid rgba(15,23,42,.06);
            background: linear-gradient(90deg, rgba(124,58,237,.10), rgba(6,182,212,.08));
        }

        .btn{ border-radius: 14px; font-weight: 800; }
        .btn-primary{
            border: 0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
            transition: transform .18s ease, filter .18s ease;
        }
        .btn-primary:hover{ transform: translateY(-1px); filter: brightness(1.05); }

        .form-control, .form-select{
            border-radius: 14px;
            border: 1px solid rgba(15,23,42,.10);
        }
        .form-control:focus, .form-select:focus{
            border-color: rgba(124,58,237,.35);
            box-shadow: 0 0 0 .2rem rgba(124,58,237,.12);
        }

        .help{ color: var(--muted); font-size: 12px; }

        .table thead th{
            font-size: 12px;
            color: var(--muted);
            letter-spacing: .02em;
            border-bottom: 1px solid rgba(15,23,42,.08) !important;
            white-space: nowrap;
        }
        .table tbody td{
            border-top: 1px solid rgba(15,23,42,.06);
            vertical-align: middle;
        }
        .trow:hover{ background: rgba(124,58,237,.06); }

        .chip{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.75);
            border: 1px solid rgba(15,23,42,.08);
            font-weight: 800;
            color: #111827;
        }

        .icon-btn{
            width: 38px;
            height: 38px;
            display:inline-grid;
            place-items:center;
            border-radius: 999px !important;
            border: 1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.85);
            box-shadow: 0 10px 22px rgba(2,6,23,.10);
            transition: transform .14s ease, filter .14s ease;
        }
        .icon-btn:hover{ transform: translateY(-1px); filter: brightness(1.05); }
        .icon-warn{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.22); }
        .icon-del{ background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.22); }
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
                <h4 class="mb-0 fw-bold"><i class="bi bi-percent me-2"></i>Promotions</h4>
                <span class="badge-soft"><i class="bi bi-shield-check"></i> Admin</span>
            </div>
            <div class="text-muted small">Create and manage discounts for products or general promotions</div>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <span class="badge-soft"><i class="bi bi-calendar3"></i> {{ now()->format('d M Y') }}</span>
            <a class="btn btn-dark btn-sm" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="border-radius:16px;">
            <i class="bi bi-check2-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <!-- ADD PROMO -->
    <div class="card card-soft mb-3">
        <div class="card-head d-flex justify-content-between align-items-center">
            <div class="fw-bold"><i class="bi bi-plus-circle me-1"></i> Add Promotion</div>
            <span class="chip">
                <i class="bi bi-lightning-charge"></i>
                Quick create
            </span>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.promotions.store') }}" class="row g-2 align-items-end">
                @csrf

                <div class="col-lg-5">
                    <label class="form-label fw-semibold mb-1">Product (optional)</label>
                    <select class="form-select" name="product_id">
                        <option value="">-- Select Product (optional) --</option>
                        @foreach ($products as $prod)
                            <option value="{{ $prod->id }}">
                                {{ $prod->name }} {{ $prod->sku ? '(' . $prod->sku . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="help mt-1">
                        If you don’t pick a product, promotion will be a general promotion.
                    </div>
                </div>

                <div class="col-lg-2">
                    <label class="form-label fw-semibold mb-1">Type</label>
                    <select class="form-select" name="type" required>
                        <option value="percent">Percent (%)</option>
                        <option value="fixed">Fixed ($)</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <label class="form-label fw-semibold mb-1">Value</label>
                    <input type="number" step="0.01" min="0" class="form-control" name="value" placeholder="Value" required>
                </div>

                <div class="col-lg-2">
                    <label class="form-label fw-semibold mb-1">Min Amount</label>
                    <input type="number" step="0.01" min="0" class="form-control" name="min_amount" placeholder="Min">
                </div>

                <div class="col-lg-1">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- LIST -->
    <div class="card card-soft">
        <div class="card-head d-flex justify-content-between align-items-center">
            <div class="fw-bold"><i class="bi bi-list-check me-1"></i> Promotion List</div>
            <span class="chip">
                <i class="bi bi-collection"></i>
                Total: {{ $promotions->count() }}
            </span>
        </div>

        <div class="card-body table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Min</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($promotions as $p)
                    <tr class="trow">
                        <td class="fw-semibold">
                            {{ $p->product_name ? $p->product_name . ' (Product)' : $p->name }}
                        </td>

                        <td class="text-uppercase">{{ $p->type }}</td>
                        <td>{{ number_format($p->value, 2) }}</td>
                        <td>{{ number_format($p->min_amount, 2) }}</td>

                        <td>
                            @if ($p->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>

                        <td class="text-end">
                            <form class="d-inline" method="POST" action="{{ route('admin.promotions.toggle', $p->id) }}">
                                @csrf
                                <button class="icon-btn icon-warn" title="Toggle">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </form>

                            <form class="d-inline" method="POST"
                                  action="{{ route('admin.promotions.delete', $p->id) }}"
                                  onsubmit="return confirm('Delete this promotion?')">
                                @csrf
                                <button class="icon-btn icon-del" title="Delete">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No promotions</td>
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

