<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance</title>
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

        .card-head {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(15, 23, 42, .06);
            background: linear-gradient(90deg, rgba(124, 58, 237, .10), rgba(6, 182, 212, .08));
        }

        .muted {
            color: var(--muted);
        }

        /* Inputs */
        .form-control,
        .form-select {
            border-radius: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(124, 58, 237, .35);
            box-shadow: 0 0 0 .2rem rgba(124, 58, 237, .12);
        }

        /* Buttons */
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

        .btn-success {
            border: 0;
            background: linear-gradient(90deg, #22c55e, #06b6d4);
            box-shadow: 0 10px 25px rgba(34, 197, 94, .18);
            transition: all .18s ease;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        /* Status pill select */
        .status-select {
            border-radius: 999px !important;
            font-weight: 900;
            padding: .35rem .75rem;
            border: 1px solid rgba(15, 23, 42, .12);
            background: rgba(255, 255, 255, .9);
        }

        .status-present {
            background: rgba(34, 197, 94, .12) !important;
            border-color: rgba(34, 197, 94, .22) !important;
            color: #166534;
        }

        .status-late {
            background: rgba(245, 158, 11, .14) !important;
            border-color: rgba(245, 158, 11, .22) !important;
            color: #92400e;
        }

        .status-permission {
            background: rgba(59, 130, 246, .12) !important;
            border-color: rgba(59, 130, 246, .22) !important;
            color: #1d4ed8;
        }

        /* Table */
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

        /* Sticky actions */
        @media (min-width: 992px) {
            .sticky-actions {
                position: sticky;
                bottom: 16px;
                z-index: 50;
            }
        }

        /* Loading button */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: .92;
        }

        .btn-loading .btn-text {
            opacity: 0;
        }

        .btn-loading::after {
            content: "";
            width: 18px;
            height: 18px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, .55);
            border-top-color: #fff;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Toast */
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
    <div class="container page-wrap">

        {{-- TOPBAR --}}
        <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-bold">🧾 Attendance</h4>
                    <span class="badge-soft">Daily check-in</span>
                </div>
                <div class="text-muted small">Choose date, set status, time in/out, then save.</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <span class="badge-soft">📅 {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
                <a href="{{ route('admin.attendance.report') }}" class="btn btn-dark btn-sm">📊 Report</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm">⬅ Back</a>
            </div>
        </div>

        {{-- flash to toast --}}
        @if (session('success'))
            <script>
                window.__FLASH_SUCCESS__ = @json(session('success'));
            </script>
        @endif
        @if ($errors->any())
            <script>
                window.__FLASH_ERROR__ = @json($errors->first());
            </script>
        @endif

        {{-- Date filter --}}
        <div class="card card-soft mb-3">
            <div class="card-body">
                <form class="row g-2 align-items-end" method="GET" action="{{ route('admin.attendance.index') }}">
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-bold mb-1">Select Date</label>
                        <input type="date" name="date" value="{{ $date }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-primary w-100" type="submit">Go</button>
                    </div>
                    <div class="col-12 col-md-5 text-md-end">
                        <div class="text-muted small">
                            Tip: Use <b>Present</b> default, change only who late/permission.
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Attendance table form --}}
        <form id="attForm" method="POST" action="{{ route('admin.attendance.store') }}">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="card card-soft">
                <div class="card-head d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="fw-bold">Employees</div>
                    <div class="text-muted small">Total: <b>{{ $employees->count() }}</b></div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Position</th>
                                <th style="width:200px;">Status</th>
                                <th style="width:170px;">Check In</th>
                                <th style="width:170px;">Check Out</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($employees as $index => $e)
                                @php $a = $attendanceMap->get($e->id); @endphp

                                <tr>
                                    <td class="fw-semibold">
                                        {{ $e->name }}
                                        <input type="hidden" name="rows[{{ $index }}][employee_id]"
                                            value="{{ $e->id }}">
                                    </td>

                                    <td class="muted">{{ $e->position_name }}</td>

                                    <td>
                                        @php $status = ($a->status ?? 'Present'); @endphp
                                        <select class="form-select form-select-sm status-select" data-status
                                            name="rows[{{ $index }}][status]">
                                            <option value="Present" @selected($status == 'Present')>✅ Present</option>
                                            <option value="Late" @selected($status == 'Late')>⏰ Late</option>
                                            <option value="Permission" @selected($status == 'Permission')>📝 Permission
                                            </option>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="time" class="form-control form-control-sm"
                                            name="rows[{{ $index }}][check_in]"
                                            value="{{ $a->check_in ?? '' }}">
                                    </td>

                                    <td>
                                        <input type="time" class="form-control form-control-sm"
                                            name="rows[{{ $index }}][check_out]"
                                            value="{{ $a->check_out ?? '' }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Sticky actions --}}
            <div class="sticky-actions mt-3">
                <div class="card card-soft">
                    <div class="card-body d-flex flex-wrap gap-2 justify-content-between align-items-center">
                        <div class="text-muted small">
                            ✅ After saving, you can open <b>Report</b> to view summary.
                        </div>

                        <div class="d-flex gap-2">
                            <button id="saveBtn" class="btn btn-success px-4" type="submit">
                                <span class="btn-text">✅ Save Attendance</span>
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark px-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ===== Status select color =====
        function applyStatusColor(sel) {
            sel.classList.remove('status-present', 'status-late', 'status-permission');
            const v = (sel.value || '').toLowerCase();
            if (v === 'present') sel.classList.add('status-present');
            if (v === 'late') sel.classList.add('status-late');
            if (v === 'permission') sel.classList.add('status-permission');
        }

        document.querySelectorAll('select[data-status]').forEach(sel => {
            applyStatusColor(sel);
            sel.addEventListener('change', () => applyStatusColor(sel));
        });

        // ===== Loading on submit =====
        const form = document.getElementById('attForm');
        const btn = document.getElementById('saveBtn');
        form?.addEventListener('submit', () => btn.classList.add('btn-loading'));

        // ===== Toast =====
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const id = 't' + Math.random().toString(16).slice(2);

            const bg = (type === 'danger') ? 'bg-danger' :
                (type === 'warning') ? 'bg-warning text-dark' :
                (type === 'info') ? 'bg-info text-dark' :
                'bg-success';

            const html = `
      <div id="${id}" class="toast align-items-center text-white ${bg} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body fw-semibold">${escapeHtml(message)}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    `;
            container.insertAdjacentHTML('beforeend', html);

            const el = document.getElementById(id);
            const t = new bootstrap.Toast(el, {
                delay: 1700
            });
            t.show();
            el.addEventListener('hidden.bs.toast', () => el.remove());
        }

        function escapeHtml(str) {
            return String(str || '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", "&#039;");
        }

        if (window.__FLASH_SUCCESS__) showToast(window.__FLASH_SUCCESS__, 'success');
        if (window.__FLASH_ERROR__) showToast(window.__FLASH_ERROR__, 'danger');
    </script>
    @include('partials.motion-scripts')
</body>

</html>

