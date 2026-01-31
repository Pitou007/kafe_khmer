<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Report</title>

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
            --shadow2: 0 18px 45px rgba(2, 6, 23, .12);
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

        /* ===== Animated Background Blobs (smooth + not too transparent) ===== */
        .bg-blobs {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            width: 560px;
            height: 560px;
            border-radius: 999px;
            filter: blur(46px);
            opacity: .55;
            animation: softFloat 8s ease-in-out infinite;
            transform: translate3d(0, 0, 0);
        }

        .blob.one {
            left: -180px;
            top: -160px;
            background: rgba(124, 58, 237, .55);
        }

        .blob.two {
            right: -190px;
            top: -140px;
            background: rgba(6, 182, 212, .45);
            animation-delay: 1.4s;
        }

        .blob.three {
            left: 32%;
            bottom: -280px;
            background: rgba(124, 58, 237, .30);
            animation-delay: .8s;
        }

        @keyframes softFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: .55;
            }

            50% {
                transform: translateY(-14px) scale(1.03);
                opacity: .70;
            }
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

        /* ===== Topbar ===== */
        .topbar {
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(14px);
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
            color: #111827;
            font-weight: 900;
            font-size: 13px;
        }

        /* ===== Cards ===== */
        .card-soft {
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp .65s ease both;
        }

        .card-soft:hover {
            box-shadow: var(--shadow2);
        }

        .card-head {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(15, 23, 42, .06);
            background: linear-gradient(90deg, rgba(124, 58, 237, .10), rgba(6, 182, 212, .08));
        }

        /* ===== Buttons / Inputs ===== */
        .btn {
            border-radius: 14px;
            font-weight: 900;
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

        .form-control {
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .10);
        }

        .form-control:focus {
            border-color: rgba(124, 58, 237, .35);
            box-shadow: 0 0 0 .2rem rgba(124, 58, 237, .12);
        }

        /* ===== Summary stat cards ===== */
        .stat {
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 14px;
            animation: fadeUp .70s ease both;
            display: flex;
            gap: 12px;
            align-items: center;
            min-height: 92px;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .stat:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow2);
        }

        .stat .icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(90deg, rgba(124, 58, 237, .14), rgba(6, 182, 212, .12));
            border: 1px solid rgba(124, 58, 237, .18);
        }

        .stat .label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .02em;
            text-transform: uppercase;
        }

        .stat .value {
            font-size: 22px;
            font-weight: 950;
        }

        /* ===== Table ===== */
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
            background: rgba(255, 255, 255, .85);
            border: 1px solid rgba(15, 23, 42, .08);
            font-weight: 900;
            color: #111827;
        }

        /* ===== Payment pill (better than default badge) ===== */
        .pay-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 900;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .75);
            white-space: nowrap;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            display: inline-block;
        }

        .pay-cash .dot {
            background: #22c55e;
        }

        .pay-qr .dot {
            background: #06b6d4;
        }

        .pay-card .dot {
            background: #f59e0b;
        }

        /* ===== View button nicer ===== */
        .btn-view {
            border-radius: 14px;
            font-weight: 900;
            border: 1px solid rgba(15, 23, 42, .10);
            background: rgba(255, 255, 255, .85);
            transition: transform .18s ease, filter .18s ease;
        }

        .btn-view:hover {
            transform: translateY(-1px);
            filter: brightness(1.03);
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
                    <h4 class="mb-0 fw-bold"><i class="bi bi-graph-up-arrow me-2"></i>Sales Report</h4>
                    <span class="badge-soft"><i class="bi bi-shield-check"></i> Admin</span>
                </div>
                <div class="text-muted small">Filter by date and view totals</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
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
                <span class="chip"><i class="bi bi-clock-history"></i> Date range</span>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold mb-1">From</label>
                        <input type="date" name="from" class="form-control" value="{{ $from }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold mb-1">To</label>
                        <input type="date" name="to" class="form-control" value="{{ $to }}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-check2-circle me-1"></i> Apply Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="stat">
                    <div class="icon"><i class="bi bi-receipt"></i></div>
                    <div>
                        <div class="label">Invoices</div>
                        <div class="value">{{ number_format($summary['count']) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat">
                    <div class="icon"><i class="bi bi-cash-stack"></i></div>
                    <div>
                        <div class="label">Subtotal</div>
                        <div class="value">{{ number_format($summary['subtotal'], 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat">
                    <div class="icon"><i class="bi bi-tag"></i></div>
                    <div>
                        <div class="label">Discount</div>
                        <div class="value">{{ number_format($summary['discount'], 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat">
                    <div class="icon"><i class="bi bi-check2-square"></i></div>
                    <div>
                        <div class="label">Final Total</div>
                        <div class="value">{{ number_format($summary['final'], 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card card-soft">
            <div class="card-head d-flex justify-content-between align-items-center">
                <div class="fw-bold"><i class="bi bi-list-check me-1"></i> Sales List</div>
                <span class="chip"><i class="bi bi-collection"></i> Rows: {{ $sales->count() }}</span>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Cashier</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end">Tax</th>
                            <th class="text-end">Final</th>
                            <th>Payment</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $s)
                            @php
                                $pay = strtolower($s->payment_type ?? 'cash');
                                $payClass = $pay === 'qr' ? 'pay-qr' : ($pay === 'card' ? 'pay-card' : 'pay-cash');
                            @endphp
                            <tr class="trow">
                                <td class="text-muted">{{ $s->id }}</td>
                                <td class="fw-semibold">{{ $s->invoice_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->created_at)->format('d M Y H:i') }}</td>
                                <td>{{ $s->cashier_name }}</td>
                                <td class="text-end">{{ number_format($s->total_amount, 2) }}</td>
                                <td class="text-end">{{ number_format($s->discount, 2) }}</td>
                                <td class="text-end">{{ number_format($s->tax, 2) }}</td>
                                <td class="text-end fw-bold">{{ number_format($s->final_total, 2) }}</td>

                                <td>
                                    <span class="pay-pill {{ $payClass }}">
                                        <span class="dot"></span>
                                        {{ strtoupper($s->payment_type) }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a class="btn btn-sm btn-view" href="{{ route('admin.sales.show', $s->id) }}">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-muted py-4 text-center">No sales found</td>
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

