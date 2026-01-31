<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suppliers</title>
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

        .form-control {
            border-radius: 14px;
            padding: .72rem .9rem;
        }

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

        .btn-outline-dark,
        .btn-dark {
            border-radius: 14px;
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

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(15, 23, 42, .04);
            border: 1px solid rgba(15, 23, 42, .08);
            color: #111827;
            font-size: 12px;
            font-weight: 800;
            max-width: 240px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .muted {
            color: var(--muted);
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
                    <h4 class="mb-0 fw-bold">🏭 Suppliers</h4>
                    <span class="badge-soft">Manage vendors & contacts</span>
                </div>
                <div class="text-muted small">Search suppliers, edit info, or remove old vendors.</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <span class="badge-soft">📅 {{ now()->format('d M Y') }}</span>
                <a class="btn btn-dark btn-sm" href="{{ route('admin.dashboard') }}">⬅ Back</a>
                <a class="btn btn-primary btn-sm" href="{{ route('admin.suppliers.create') }}">➕ Add Supplier</a>
            </div>
        </div>

        {{-- SUCCESS SESSION -> TOAST --}}
        @if (session('success'))
            <div class="toast-container" id="toastContainer"></div>
            <script>
                window.__FLASH_SUCCESS__ = @json(session('success'));
            </script>
        @endif

        <div class="card card-soft">
            <div class="card-head d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="fw-bold">Supplier List</div>

                <div class="d-flex gap-2 align-items-center">
                    <input id="search" class="form-control" style="max-width:360px"
                        placeholder="Search name / company / phone / email...">
                    <span class="badge-soft">Total: {{ $suppliers->count() }}</span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0" id="supTable">
                        <thead>
                            <tr>
                                <th style="width:70px;">#</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th class="text-end" style="width:180px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($suppliers as $s)
                                <tr class="sup-row">
                                    <td class="muted">{{ $s->id }}</td>

                                    <td>
                                        <div class="fw-bold">{{ $s->name }}</div>
                                        <div class="muted small">Supplier</div>
                                    </td>

                                    <td>
                                        <span class="chip">🏢 {{ $s->company_name ?? '-' }}</span>
                                    </td>

                                    <td>
                                        <span class="chip">📞 {{ $s->phone ?? '-' }}</span>
                                    </td>

                                    <td>
                                        <span class="chip">✉️ {{ $s->email ?? '-' }}</span>
                                    </td>

                                    <td>
                                        <span class="chip">📍 {{ $s->address ?? '-' }}</span>
                                    </td>

                                    <td class="text-end">
                                        <a class="btn btn-sm btn-warning" style="border-radius:14px;"
                                            href="{{ route('admin.suppliers.edit', $s->id) }}">Edit</a>

                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            style="border-radius:14px;"
                                            onclick="openDeleteModal({{ $s->id }}, @json($s->name))">
                                            Delete
                                        </button>

                                        <form id="delForm{{ $s->id }}" method="POST"
                                            action="{{ route('admin.suppliers.delete', $s->id) }}" class="d-none">
                                            @csrf
                                        </form>
                                    </td>

                                    {{-- hidden searchable text --}}
                                    <td class="d-none sup-search">
                                        {{ strtolower(($s->name ?? '') . ' ' . ($s->company_name ?? '') . ' ' . ($s->phone ?? '') . ' ' . ($s->email ?? '') . ' ' . ($s->address ?? '')) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted p-4">No suppliers yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top" style="border-top:1px solid rgba(15,23,42,.06) !important;">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="text-muted small">Tip: Use the search box to filter quickly.</div>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.suppliers.create') }}">➕ Add
                            Supplier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirm Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px; overflow:hidden;">
                <div class="modal-header"
                    style="background:rgba(239,68,68,.08); border-bottom:1px solid rgba(15,23,42,.06);">
                    <h5 class="modal-title fw-bold">🗑 Delete Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="fw-semibold mb-1">Are you sure?</div>
                    <div class="text-muted">This will permanently delete:</div>
                    <div class="mt-2 p-2 rounded-3"
                        style="background:rgba(15,23,42,.04); border:1px solid rgba(15,23,42,.06);">
                        <span class="fw-bold" id="delName">Supplier</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ============ Search filter ============
        const searchEl = document.getElementById('search');
        searchEl?.addEventListener('input', () => {
            const q = (searchEl.value || '').toLowerCase().trim();
            document.querySelectorAll('.sup-row').forEach(row => {
                const text = row.querySelector('.sup-search')?.innerText || '';
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });

        // ============ Delete modal ============
        let deleteId = null;
        const delModalEl = document.getElementById('deleteModal');
        const delModal = new bootstrap.Modal(delModalEl);

        function openDeleteModal(id, name) {
            deleteId = id;
            document.getElementById('delName').innerText = name || 'Supplier';
            delModal.show();
        }

        document.getElementById('confirmDeleteBtn')?.addEventListener('click', () => {
            if (!deleteId) return;
            const f = document.getElementById('delForm' + deleteId);
            if (f) f.submit();
        });

        // ============ Toast success ============
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

        if (window.__FLASH_SUCCESS__) {
            showToast(window.__FLASH_SUCCESS__, 'success');
        }
    </script>
    @include('partials.motion-scripts')
</body>

</html>

