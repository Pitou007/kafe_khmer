<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transactions History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            animation: fadeUp .6s ease;
        }

        .card-head{
            padding: 14px 16px;
            border-bottom: 1px solid rgba(15,23,42,.06);
            background: linear-gradient(90deg, rgba(124,58,237,.10), rgba(6,182,212,.08));
        }

        /* Filter pills */
        .pillbar{
            display:flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .pill{
            border-radius: 999px !important;
            font-weight: 800;
            padding: 6px 12px;
            border: 1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.70);
            transition: .15s ease;
            cursor:pointer;
            user-select:none;
        }
        .pill:hover{ transform: translateY(-1px); }
        .pill.active{
            border: 0;
            color:#fff;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
        }

        /* Buttons */
        .btn{
            border-radius: 14px;
            font-weight: 800;
        }
        .btn-primary{
            border: 0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
        }
        .btn-primary:hover{ transform: translateY(-1px); filter: brightness(1.05); }

        .btn-dark{ border-radius: 14px; }

        /* Action buttons (gradient look) */
        .btn-grad{
            border: 0;
            color: #fff !important;
            box-shadow: 0 10px 25px rgba(2,6,23,.10);
            transition: .16s ease;
        }
        .btn-grad:hover{ transform: translateY(-1px); filter: brightness(1.05); }
        .btn-in{ background: linear-gradient(90deg, #22c55e, #06b6d4); }
        .btn-out{ background: linear-gradient(90deg, #f59e0b, #f97316); }
        .btn-broken{ background: linear-gradient(90deg, #ef4444, #fb7185); }
        .btn-transfer{ background: linear-gradient(90deg, #3b82f6, #06b6d4); }

        /* Table */
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
        .trow:hover{
            background: rgba(124,58,237,.06);
        }

        .muted{ color: var(--muted); }

        .type-badge{
            border-radius: 999px;
            font-weight: 900;
            letter-spacing: .02em;
            padding: 6px 10px;
        }

        /* Mobile: action buttons wrap nicely */
        .actions-wrap{
            display:flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @include('partials.motion-head')
</head>

<body>
<div class="container page-wrap">

    {{-- TOPBAR --}}
    <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-bold">📦 Transactions</h4>
                <span class="badge-soft">Stock in / out / transfer / broken</span>
            </div>
            <div class="text-muted small">Track every movement of products in your inventory</div>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <span class="badge-soft">📅 {{ now()->format('d M Y') }}</span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">⬅ Back</a>
        </div>
    </div>

    {{-- FILTER + ACTIONS --}}
    <div class="card card-soft mb-3">
        <div class="card-head d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <div class="fw-bold">Filter</div>
            <div class="actions-wrap">
                <a class="btn btn-grad btn-in btn-sm" href="{{ route('admin.transactions.in') }}">➕ Stock In</a>
                <a class="btn btn-grad btn-out btn-sm" href="{{ route('admin.transactions.out') }}">➖ Stock Out</a>
                <a class="btn btn-grad btn-broken btn-sm" href="{{ route('admin.transactions.broken') }}">💥 Broken</a>
                <a class="btn btn-grad btn-transfer btn-sm" href="{{ route('admin.transactions.transfer') }}">🔁 Transfer</a>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="row g-2 align-items-end">
                <div class="col-lg-8">
                    {{-- pill buttons that still submit with select --}}
                    <div class="pillbar mb-2">
                        <span class="pill {{ $type==='all' ? 'active' : '' }}" onclick="pickType('all')">All</span>
                        <span class="pill {{ $type==='in' ? 'active' : '' }}" onclick="pickType('in')">Stock In</span>
                        <span class="pill {{ $type==='out' ? 'active' : '' }}" onclick="pickType('out')">Stock Out</span>
                        <span class="pill {{ $type==='transfer' ? 'active' : '' }}" onclick="pickType('transfer')">Transfer</span>
                        <span class="pill {{ $type==='broken' ? 'active' : '' }}" onclick="pickType('broken')">Broken</span>
                    </div>

                    <select id="typeSelect" name="type" class="form-select" style="border-radius:14px;">
                        <option value="all" @selected($type === 'all')>All</option>
                        <option value="in" @selected($type === 'in')>Stock In</option>
                        <option value="out" @selected($type === 'out')>Stock Out</option>
                        <option value="transfer" @selected($type === 'transfer')>Transfer</option>
                        <option value="broken" @selected($type === 'broken')>Broken</option>
                    </select>
                </div>

                <div class="col-lg-4">
                    <button class="btn btn-primary w-100" type="submit">✅ Apply Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card card-soft">
        <div class="card-body table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Product</th>
                    <th class="text-end">Qty</th>
                    <th>Note</th>
                    <th>By</th>
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
                    @endphp
                    <tr class="trow">
                        <td class="text-muted">{{ $t->id }}</td>
                        <td>
                            <span class="badge type-badge {{ $badge }}">{{ strtoupper($t->type) }}</span>
                        </td>
                        <td class="fw-semibold">
                            {{ $t->product_name }}
                            <span class="text-muted">({{ $t->product_sku ?? '-' }})</span>
                        </td>
                        <td class="text-end fw-bold">{{ $t->qty }}</td>
                        <td class="muted">{{ $t->note ?? '-' }}</td>
                        <td>{{ $t->user_name ?? '-' }}</td>
                        <td class="muted">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No transactions found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function pickType(type){
        const sel = document.getElementById('typeSelect');
        sel.value = type;
        // auto submit for fast UX
        sel.form.submit();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.motion-scripts')
</body>
</html>

