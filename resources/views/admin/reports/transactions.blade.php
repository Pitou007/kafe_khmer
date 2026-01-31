<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stock Transactions Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f6f7fb;
            --text:#0f172a;
            --muted:#64748b;
            --brand1:#7c3aed;
            --brand2:#06b6d4;
            --shadow: 0 12px 35px rgba(2,6,23,.10);
            --shadow2: 0 18px 45px rgba(2,6,23,.12);
            --radius: 18px;
        }

        body{
            min-height:100vh;
            background:
                radial-gradient(1200px 500px at 20% 0%, rgba(124,58,237,.12), transparent 60%),
                radial-gradient(900px 450px at 95% 10%, rgba(6,182,212,.12), transparent 55%),
                var(--bg);
            color: var(--text);
            overflow-x:hidden;
        }

        /* animated blobs */
        .bg-blobs{ position:fixed; inset:0; pointer-events:none; z-index:0; overflow:hidden; }
        .blob{
            position:absolute; width:560px; height:560px; border-radius:999px;
            filter: blur(46px);
            opacity:.55;
            animation: softFloat 8s ease-in-out infinite;
            transform: translate3d(0,0,0);
        }
        .blob.one{ left:-180px; top:-160px; background: rgba(124,58,237,.55); }
        .blob.two{ right:-190px; top:-140px; background: rgba(6,182,212,.45); animation-delay:1.4s; }
        .blob.three{ left:32%; bottom:-280px; background: rgba(124,58,237,.30); animation-delay:.8s; }

        @keyframes softFloat{
            0%,100%{ transform: translateY(0) scale(1); opacity:.55; }
            50%{ transform: translateY(-14px) scale(1.03); opacity:.70; }
        }
        @keyframes fadeUp{
            from{ opacity:0; transform: translateY(18px); }
            to{ opacity:1; transform: translateY(0); }
        }

        .page-wrap{ padding: 18px 0; position:relative; z-index:2; }

        .topbar{
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(15,23,42,.06);
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
            color:#111827;
            font-weight: 900;
            font-size: 13px;
        }

        .chip{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.85);
            border: 1px solid rgba(15,23,42,.08);
            font-weight: 900;
            color:#111827;
        }

        .card-soft{
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15,23,42,.06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow:hidden;
            animation: fadeUp .65s ease both;
        }
        .card-soft:hover{ box-shadow: var(--shadow2); }

        .card-head{
            padding: 14px 16px;
            border-bottom: 1px solid rgba(15,23,42,.06);
            background: linear-gradient(90deg, rgba(124,58,237,.10), rgba(6,182,212,.08));
        }

        .btn{ border-radius: 14px; font-weight: 900; }
        .btn-primary{
            border:0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124,58,237,.18);
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

        /* table */
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

        .type-pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 900;
            border: 1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.75);
            white-space: nowrap;
        }
        .dot{ width:8px; height:8px; border-radius:999px; display:inline-block; }
        .type-in .dot{ background:#22c55e; }
        .type-out .dot{ background:#f59e0b; }
        .type-transfer .dot{ background:#3b82f6; }
        .type-broken .dot{ background:#ef4444; }

        .qty{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 950;
            border: 1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.80);
            min-width: 62px;
        }

        /* ---------------------------
           ✅ RESPONSIVE IMPROVEMENTS
           --------------------------- */

        /* container breathing room on small screens */
        @media (max-width: 576px){
            .page-wrap{ padding: 14px 0; }
            .topbar{ padding: 12px 12px; }
            .card-head{ padding: 12px 12px; }
        }

        /* topbar layout */
        .topbar h4{ line-height: 1.15; }
        @media (max-width: 576px){
            .topbar .badge-soft{ font-size: 12px; padding: 7px 10px; }
            .topbar .btn{ width: 100%; }
        }

        /* Filter form: better grid on mobile */
        @media (max-width: 576px){
            form.row.g-2 > [class*="col-"]{ margin-top: .25rem; }
        }

        /* TABLE -> MOBILE CARDS */
        .td-label{
            display:none;
            font-size: 11px;
            font-weight: 900;
            color: var(--muted);
            letter-spacing: .02em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        @media (max-width: 768px){
            .table-responsive{ overflow: visible; } /* allow card shadows */
            table.table thead{ display:none; }

            table.table,
            table.table tbody,
            table.table tr,
            table.table td{
                display:block;
                width:100%;
            }

            table.table tbody tr{
                background: rgba(255,255,255,.88);
                border: 1px solid rgba(15,23,42,.08);
                border-radius: 16px;
                padding: 10px 12px;
                box-shadow: 0 10px 25px rgba(2,6,23,.08);
                margin-bottom: 10px;
            }

            table.table tbody td{
                border: 0 !important;
                padding: 8px 0;
            }

            table.table tbody td + td{
                border-top: 1px dashed rgba(15,23,42,.10);
            }

            /* show labels */
            .td-label{ display:block; }

            /* align qty right on mobile too */
            .mobile-end{ display:flex; justify-content:space-between; align-items:center; gap:10px; }
            .qty{ min-width: 70px; }
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
            <div class="w-100 w-sm-auto">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-arrow-repeat me-2"></i>Stock Transactions
                    </h4>
                    <span class="badge-soft"><i class="bi bi-shield-check"></i> Admin</span>
                </div>
                <div class="text-muted small">Stock in / out / transfer / broken</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap w-100 w-sm-auto justify-content-start justify-content-sm-end">
                <span class="badge-soft"><i class="bi bi-calendar3"></i> {{ now()->format('d M Y') }}</span>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- FILTER -->
        <div class="card card-soft mb-3">
            <div class="card-head d-flex justify-content-between align-items-center">
                <div class="fw-bold"><i class="bi bi-funnel me-1"></i> Filter</div>
                <span class="chip"><i class="bi bi-clock-history"></i> Range</span>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.transactions') }}" class="row g-2 align-items-end">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label fw-semibold mb-1">Type</label>
                        <select name="type" class="form-select">
                            <option value="all" @selected($type === 'all')>All</option>
                            <option value="in" @selected($type === 'in')>Stock In</option>
                            <option value="out" @selected($type === 'out')>Stock Out</option>
                            <option value="transfer" @selected($type === 'transfer')>Transfer</option>
                            <option value="broken" @selected($type === 'broken')>Broken</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label fw-semibold mb-1">From</label>
                        <input type="date" name="from" class="form-control" value="{{ $from }}">
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label fw-semibold mb-1">To</label>
                        <input type="date" name="to" class="form-control" value="{{ $to }}">
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-check2-circle me-1"></i> Apply Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card card-soft">
            <div class="card-head d-flex justify-content-between align-items-center">
                <div class="fw-bold"><i class="bi bi-list-check me-1"></i> Transactions List</div>
                <span class="chip"><i class="bi bi-collection"></i> Rows: {{ $txns->count() }}</span>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Product</th>
                            <th class="text-end">Qty</th>
                            <th>Reference</th>
                            <th>Note</th>
                            <th>Created By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($txns as $t)
                            @php
                                $badge = match ($t->type) {
                                    'in' => 'bg-success',
                                    'out' => 'bg-warning text-dark',
                                    'transfer' => 'bg-primary',
                                    'broken' => 'bg-danger',
                                    default => 'bg-secondary',
                                };

                                $ref = '-';
                                if ($t->type === 'out' && !empty($t->invoice_number)) {
                                    $ref = $t->invoice_number;
                                } elseif (!empty($t->reference_id)) {
                                    $ref = 'REF-' . $t->reference_id;
                                }

                                $typeKey = strtolower($t->type ?? 'all');
                                $typePill = $typeKey === 'in' ? 'type-in'
                                    : ($typeKey === 'out' ? 'type-out'
                                    : ($typeKey === 'transfer' ? 'type-transfer'
                                    : ($typeKey === 'broken' ? 'type-broken' : '')));
                            @endphp

                            <tr class="trow">
                                <td class="text-muted">
                                    <div class="td-label">ID</div>
                                    {{ $t->id }}
                                </td>

                                <td>
                                    <div class="td-label">Type</div>
                                    <span class="type-pill {{ $typePill }}">
                                        <span class="dot"></span>
                                        {{ strtoupper($t->type) }}
                                    </span>
                                </td>

                                <td class="fw-semibold">
                                    <div class="td-label">Product</div>
                                    {{ $t->product_name ?? ('Product #' . $t->product_id) }}
                                </td>

                                <td class="text-end">
                                    <div class="td-label">Qty</div>
                                    <div class="mobile-end">
                                        <span class="text-muted d-md-none">Quantity</span>
                                        <span class="qty">{{ $t->qty }}</span>
                                    </div>
                                </td>

                                <td class="fw-semibold">
                                    <div class="td-label">Reference</div>
                                    {{ $ref }}
                                </td>

                                <td class="text-muted">
                                    <div class="td-label">Note</div>
                                    {{ $t->note ?? '-' }}
                                </td>

                                <td>
                                    <div class="td-label">Created By</div>
                                    {{ $t->user_name ?? '-' }}
                                </td>

                                <td>
                                    <div class="td-label">Date</div>
                                    {{ \Carbon\Carbon::parse($t->created_at)->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4 text-center">No transactions found</td>
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

