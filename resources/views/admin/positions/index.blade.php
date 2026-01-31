<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Positions</title>

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
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes softPulse {
            0%, 100% { opacity: .45; transform: translateY(0); }
            50% { opacity: .75; transform: translateY(-6px); }
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
            font-weight: 800;
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
                        <i class="bi bi-diagram-3 me-2"></i>Positions
                    </h4>
                    <span class="badge-soft">
                        <i class="bi bi-shield-check"></i> Admin
                    </span>
                </div>
                <div class="text-muted small">Manage position names and base salary</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <span class="badge-soft">
                    <i class="bi bi-calendar3"></i> {{ now()->format('d M Y') }}
                </span>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>

                <a href="{{ route('admin.positions.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="border-radius:14px;">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" style="border-radius:14px;">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
            </div>
        @endif

        <!-- TABLE CARD -->
        <div class="card card-soft">
            <div class="card-head d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-list-ul me-2"></i>Position List
                </div>
                <span class="chip">
                    <i class="bi bi-collection"></i> Rows: {{ $positions->count() }}
                </span>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:80px;">#</th>
                                <th>Name</th>
                                <th class="text-end">Base Salary</th>
                                <th class="text-end" style="width:160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($positions as $p)
                                <tr class="trow">
                                    <td class="text-muted">{{ $p->id }}</td>
                                    <td class="fw-semibold">{{ $p->name }}</td>
                                    <td class="text-end fw-bold">{{ number_format($p->base_salary, 2) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.positions.edit', $p->id) }}"
                                            class="btn btn-sm btn-outline-dark">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form class="d-inline" method="POST"
                                            action="{{ route('admin.positions.delete', $p->id) }}"
                                            onsubmit="return confirm('Delete this position?')">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash3"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted text-center py-4">
                                        <i class="bi bi-inbox me-1"></i>No positions
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.motion-scripts')
</body>

</html>

