<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt</title>

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
        }

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
            animation: fadeUp .65s ease;
        }

        .receipt-head{
            padding: 18px 18px 14px;
            background: linear-gradient(90deg, rgba(124,58,237,.14), rgba(6,182,212,.10));
            border-bottom: 1px solid rgba(15,23,42,.06);
        }

        .r-title{
            font-weight: 950;
            font-size: 18px;
            margin: 0;
        }

        .muted{ color: var(--muted); }

        .pimg{
            width: 60px; height: 60px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 10px 22px rgba(2,6,23,.10);
        }
        .noimg{
            width: 60px; height: 60px;
            border-radius: 12px;
            background: rgba(15,23,42,.08);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size: 11px;
            color: rgba(15,23,42,.60);
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

        .totals{
            margin-top: 12px;
            padding: 14px;
            border-radius: 16px;
            background: rgba(255,255,255,.70);
            border: 1px solid rgba(15,23,42,.06);
        }
        .trow{
            display:flex;
            justify-content: space-between;
            padding: 6px 0;
            color: var(--muted);
            font-weight: 700;
        }
        .trow b{ color: var(--text); }

        .final{
            display:flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: 950;
            padding-top: 10px;
            border-top: 1px dashed rgba(15,23,42,.15);
            margin-top: 8px;
        }

        .btn-primary{
            border: 0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
            transition: all .18s ease;
            border-radius: 14px;
        }
        .btn-primary:hover{ transform: translateY(-1px); filter: brightness(1.05); }

        .btn-dark, .btn-outline-dark{
            border-radius: 14px;
        }

        /* Print styles */
        @media print{
            body{ background: #fff !important; }
            .no-print{ display:none !important; }
            .card-soft{ box-shadow: none !important; border: 1px solid #ddd !important; }
            .topbar{ box-shadow:none !important; border: none !important; background:#fff !important; }
        }

        @keyframes fadeUp{
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @include('partials.motion-head')
</head>

<body>

<div class="container py-4">

    {{-- TOPBAR --}}
    <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 no-print">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-bold">🧾 Receipt</h4>
                <span class="badge-soft">Invoice: {{ $sale->invoice_number }}</span>
            </div>
            <div class="text-muted small">Thank you for your purchase</div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.pos') }}">➕ New Sale</a>
            <button class="btn btn-dark btn-sm" type="button" onclick="window.print()">🖨 Print</button>
        </div>
    </div>

    <div class="card card-soft">
        {{-- Receipt header inside card --}}
        <div class="receipt-head">
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <div>
                    <p class="r-title mb-1">☕ Kafe Khmer</p>
                    <div class="muted small">Receipt / Invoice</div>
                </div>
                <div class="text-end">
                    <div class="fw-bold">{{ $sale->invoice_number }}</div>
                    <div class="muted small">{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y H:i') }}</div>
                </div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-sm-4">
                    <div class="muted small">Cashier</div>
                    <div class="fw-semibold">{{ $sale->cashier_name ?? $sale->user_id }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="muted small">Payment</div>
                    <div class="fw-semibold">{{ strtoupper($sale->payment_type) }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="muted small">Status</div>
                    <span class="badge bg-success">Paid</span>
                </div>
            </div>
        </div>

        <div class="card-body">

            {{-- Items --}}
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                    <tr>
                        <th style="width:90px;">Image</th>
                        <th>Product</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Total</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($items as $i)
                        <tr>
                            <td>
                                @if (!empty($i->image_path))
                                    <img class="pimg" src="{{ asset('storage/' . $i->image_path) }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="noimg" style="display:none;">No Image</div>
                                @else
                                    <div class="noimg">No Image</div>
                                @endif
                            </td>

                            <td>
                                <div class="fw-semibold">{{ $i->name }}</div>
                            </td>

                            <td class="text-end fw-semibold">{{ $i->qty }}</td>
                            <td class="text-end">{{ number_format($i->price, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($i->line_total, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="totals">
                <div class="trow">
                    <span>Subtotal</span>
                    <b>{{ number_format($sale->total_amount, 2) }}</b>
                </div>
                <div class="trow">
                    <span>Discount</span>
                    <b>- {{ number_format($sale->discount, 2) }}</b>
                </div>
                <div class="trow">
                    <span>Tax</span>
                    <b>{{ number_format($sale->tax, 2) }}</b>
                </div>

                <div class="final">
                    <span>Final Total</span>
                    <span>$ {{ number_format($sale->final_total, 2) }}</span>
                </div>
            </div>

            <div class="text-center mt-3 muted small">
                Powered by Kafe Khmer POS • Thank you 🙏
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.motion-scripts')
</body>
</html>

