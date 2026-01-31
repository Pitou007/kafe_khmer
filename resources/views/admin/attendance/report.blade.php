<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
        }

        .topbar {
            background: rgba(255, 255, 255, .78);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 16px;
            animation: fadeUp .5s ease;
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
            animation: fadeUp .6s ease;
        }

        .card-soft:hover {
            box-shadow: 0 18px 45px rgba(2, 6, 23, .12);
        }

        .muted {
            color: var(--muted);
        }

        /* inputs */
        .form-control,
        .form-select {
            border-radius: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(124, 58, 237, .35);
            box-shadow: 0 0 0 .2rem rgba(124, 58, 237, .12);
        }

        /* buttons */
        .btn {
            border-radius: 14px;
            font-weight: 900;
        }

        .btn-primary {
            border: 0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
            transition: all .18s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        /* summary cards */
        .stat {
            border-radius: 18px;
            border: 1px solid rgba(15, 23, 42, .06);
            background: rgba(255, 255, 255, .70);
            box-shadow: 0 10px 24px rgba(2, 6, 23, .08);
            padding: 14px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stat .k {
            font-size: 12px;
            color: var(--muted);
            font-weight: 800;
        }

        .stat .v {
            font-size: 22px;
            font-weight: 950;
            line-height: 1;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            box-shadow: 0 10px 20px rgba(2, 6, 23, .10);
        }

        .dot.present {
            background: #22c55e;
        }

        .dot.late {
            background: #f59e0b;
        }

        .dot.permission {
            background: #3b82f6;
        }

        /* table */
        .table thead th {
            font-size: 12px;
            letter-spacing: .02em;
            color: var(--muted);
            border-bottom: 1px solid rgba(15, 23, 42, .10) !important;
        }

        .table tbody td {
            border-top: 1px solid rgba(15, 23, 42, .06);
            vertical-align: middle;
        }

        .pill {
            font-weight: 950;
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: rgba(255, 255, 255, .75);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .pill.present {
            color: #166534;
            background: rgba(34, 197, 94, .12);
            border-color: rgba(34, 197, 94, .22);
        }

        .pill.late {
            color: #92400e;
            background: rgba(245, 158, 11, .14);
            border-color: rgba(245, 158, 11, .22);
        }

        .pill.permission {
            color: #1d4ed8;
            background: rgba(59, 130, 246, .12);
            border-color: rgba(59, 130, 246, .22);
        }

        /* sticky actions */
        @media (min-width: 992px) {
            .sticky-actions {
                position: sticky;
                bottom: 16px;
                z-index: 50;
            }
        }

        /* toast */
        .toast-container {
            position: fixed;
            right: 16px;
            bottom: 16px;
            z-index: 2000;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @include('partials.motion-head')
</head>

<body>
    @php
        // Totals for summary cards (safe even if empty)
        $presentTotal = 0;
        $lateTotal = 0;
        $permissionTotal = 0;
        foreach ($rows as $r) {
            $presentTotal += (int) ($r->present_count ?? 0);
            $lateTotal += (int) ($r->late_count ?? 0);
            $permissionTotal += (int) ($r->permission_count ?? 0);
        }
    @endphp

    <div class="container page-wrap">

        {{-- TOPBAR --}}
        <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-bold">📊 Attendance Report</h4>
                    <span class="badge-soft">From {{ \Carbon\Carbon::parse($from)->format('d M Y') }} →
                        {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</span>
                </div>
                <div class="text-muted small">
                    Filter date range • Search employee • Print report
                </div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-dark btn-sm">⬅ Back</a>
                <button type="button" class="btn btn-dark btn-sm" onclick="window.print()">🖨 Print</button>
            </div>
        </div>

        {{-- FILTER BAR --}}
        <div class="card card-soft mb-3">
            <div class="card-body">
                <form class="row g-2 align-items-end" method="GET" action="{{ route('admin.attendance.report') }}">
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-bold mb-1">From</label>
                        <input type="date" name="from" value="{{ $from }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-bold mb-1">To</label>
                        <input type="date" name="to" value="{{ $to }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-primary w-100" type="submit">Apply Filter</button>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-bold mb-1">Search</label>
                        <input id="search" class="form-control" placeholder="Search employee name...">
                    </div>
                </form>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="stat">
                    <div>
                        <div class="k">Total Present</div>
                        <div class="v">{{ $presentTotal }}</div>
                    </div>
                    <div class="dot present"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat">
                    <div>
                        <div class="k">Total Late</div>
                        <div class="v">{{ $lateTotal }}</div>
                    </div>
                    <div class="dot late"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat">
                    <div>
                        <div class="k">Total Permission</div>
                        <div class="v">{{ $permissionTotal }}</div>
                    </div>
                    <div class="dot permission"></div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card card-soft">
            <div class="card-body table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th class="text-end">Present</th>
                            <th class="text-end">Late</th>
                            <th class="text-end">Permission</th>
                        </tr>
                    </thead>
                    <tbody id="reportBody">
                        @forelse($rows as $r)
                            <tr class="r-row">
                                <td class="fw-semibold r-name">{{ $r->name }}</td>
                                <td class="text-end">
                                    <span class="pill present"><span style="font-size:10px;">●</span>
                                        {{ $r->present_count }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="pill late"><span style="font-size:10px;">●</span>
                                        {{ $r->late_count }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="pill permission"><span style="font-size:10px;">●</span>
                                        {{ $r->permission_count }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No attendance data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sticky bottom action --}}
        <div class="sticky-actions mt-3">
            <div class="card card-soft">
                <div class="card-body d-flex flex-wrap gap-2 justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing summary for selected range.
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-dark" onclick="window.print()">🖨 Print</button>
                        <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-dark">Back</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ===== Search filter =====
        const searchEl = document.getElementById('search');
        searchEl?.addEventListener('input', () => {
            const q = (searchEl.value || '').toLowerCase().trim();
            document.querySelectorAll('.r-row').forEach(tr => {
                const name = (tr.querySelector('.r-name')?.innerText || '').toLowerCase();
                tr.style.display = name.includes(q) ? '' : 'none';
            });
        });
    </script>
    @include('partials.motion-scripts')
</body>

</html>

