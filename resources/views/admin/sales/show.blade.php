<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sale Detail</title>

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

        .topbar{
            background: rgba(255,255,255,.78);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 16px;
            animation: fadeUp .55s ease;
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
            animation: fadeUp .65s ease;
        }

        .card-head{
            padding: 14px 16px;
            background: linear-gradient(90deg, rgba(124,58,237,.14), rgba(6,182,212,.10));
            border-bottom: 1px solid rgba(15,23,42,.06);
            font-weight: 950;
        }

        .muted{ color: var(--muted); }

        .stat-row{
            display:flex;
            justify-content: space-between;
            align-items:center;
            padding: 8px 0;
            color: var(--muted);
            font-weight: 700;
        }
        .stat-row b{ color: var(--text); }

        .final-row{
            display:flex;
            justify-content: space-between;
            align-items:center;
            font-size: 18px;
            font-weight: 950;
            padding-top: 10px;
            border-top: 1px dashed rgba(15,23,42,.18);
            margin-top: 8px;
        }

        .pimg{
            width: 58px; height: 58px;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 10px 22px rgba(2,6,23,.10);
        }
        .noimg{
            width: 58px; height: 58px;
            border-radius: 14px;
            background: rgba(15,23,42,.08);
            display:flex; align-items:center; justify-content:center;
            font-size: 11px;
            color: rgba(15,23,42,.60);
            font-weight: 900;
        }

        .table thead th{
            font-size: 12px;
            color: var(--muted);
            letter-spacing: .02em;
            border-bottom: 1px solid rgba(15,23,42,.08) !important;
        }
        .table tbody td{
            border-top: 1px solid rgba(15,23,42,.06);
            vertical-align: middle;
        }

        .btn-primary{
            border: 0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
            transition: all .18s ease;
            border-radius: 14px;
        }
        .btn-primary:hover{ transform: translateY(-1px); filter: brightness(1.05); }
        .btn-dark, .btn-outline-dark{ border-radius: 14px; }

        @media print{
            .no-print{ display:none !important; }
            body{ background:#fff !important; }
            .topbar, .card-soft{ box-shadow:none !important; }
        }

        @keyframes fadeUp{
            from{ opacity:0; transform: translateY(12px); }
            to{ opacity:1; transform: translateY(0); }
        }
    </style>
    @include('partials.motion-head')
</head>

<body>

<div class="container page-wrap">

    {{-- TOPBAR --}}
    <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 no-print">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-bold">🧾 Sale Detail</h4>
                <span class="badge-soft">Invoice: {{ $sale->invoice_number }}</span>
            </div>
            <div class="text-muted small">View sale information & items</div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-dark btn-sm">⬅ Back</a>
            <a href="{{ route('admin.pos.receipt', $sale->id) }}" class="btn btn-primary btn-sm">🧾 Receipt</a>
            <button type="button" class="btn btn-dark btn-sm" onclick="window.print()">🖨 Print</button>
        </div>
    </div>

    <div class="row g-3">

        {{-- LEFT: SALE INFO --}}
        <div class="col-lg-4">
            <div class="card card-soft">
                <div class="card-head">📌 Sale Summary</div>
                <div class="card-body">

                    <div class="mb-2">
                        <div class="muted small">Cashier</div>
                        <div class="fw-semibold">{{ $sale->cashier_name ?? '-' }}</div>
                    </div>

                    <div class="mb-2">
                        <div class="muted small">Customer</div>
                        <div class="fw-semibold">{{ $sale->customer_name ?? '-' }}</div>
                    </div>

                    <div class="mb-2">
                        <div class="muted small">Payment</div>
                        <div class="fw-semibold">
                            <span class="badge bg-light text-dark" style="border:1px solid rgba(15,23,42,.10);border-radius:999px;">
                                {{ strtoupper($sale->payment_type) }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="muted small">Date</div>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y H:i') }}</div>
                    </div>

                    <hr>

                    <div class="stat-row">
                        <span>Subtotal</span>
                        <b>{{ number_format($sale->total_amount, 2) }}</b>
                    </div>

                    <div class="stat-row">
                        <span>Discount</span>
                        <b>- {{ number_format($sale->discount, 2) }}</b>
                    </div>

                    <div class="stat-row">
                        <span>Tax</span>
                        <b>{{ number_format($sale->tax, 2) }}</b>
                    </div>

                    <div class="final-row">
                        <span>Final Total</span>
                        <span>{{ number_format($sale->final_total, 2) }}</span>
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT: ITEMS TABLE --}}
        <div class="col-lg-8">
            <div class="card card-soft">
                <div class="card-head">🧾 Items</div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width:80px;">Image</th>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $i)
                                    <tr>
                                        <td>
                                            @if (!empty($i->image_path))
                                                <img class="pimg" src="{{ asset('storage/' . $i->image_path) }}"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div class="noimg" style="display:none;">No</div>
                                            @else
                                                <div class="noimg">No</div>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="fw-semibold">{{ $i->name }}</div>
                                            <div class="text-muted small">Item</div>
                                        </td>

                                        <td class="text-muted">{{ $i->sku ?? '-' }}</td>
                                        <td class="text-end fw-semibold">{{ $i->qty }}</td>
                                        <td class="text-end">{{ number_format($i->price, 2) }}</td>
                                        <td class="text-end fw-bold">{{ number_format($i->line_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(count($items) === 0)
                        <div class="text-center text-muted py-4">No items found.</div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.motion-scripts')
</body>
</html>

