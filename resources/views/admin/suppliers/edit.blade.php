<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Supplier</title>
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

        .form-label {
            font-weight: 800;
            color: #111827;
        }

        .form-control,
        .form-select,
        textarea {
            border-radius: 14px !important;
            padding: .72rem .9rem;
            border: 1px solid rgba(15, 23, 42, .12);
        }

        .form-control:focus,
        textarea:focus {
            border-color: rgba(124, 58, 237, .35);
            box-shadow: 0 0 0 .2rem rgba(124, 58, 237, .12);
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(15, 23, 42, .55);
            font-weight: 900;
            font-size: 14px;
            pointer-events: none;
        }

        .icon-wrap {
            position: relative;
        }

        .icon-wrap .form-control,
        .icon-wrap textarea {
            padding-left: 38px;
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
        .btn-dark,
        .btn-secondary {
            border-radius: 14px;
        }

        /* Loading spinner */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: .9;
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
                    <h4 class="mb-0 fw-bold">✏️ Edit Supplier</h4>
                    <span class="badge-soft">Update supplier info</span>
                </div>
                <div class="text-muted small">Keep vendor details correct for stock-in/transactions.</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <span class="badge-soft">ID: {{ $supplier->id }}</span>
                <a class="btn btn-dark btn-sm" href="{{ route('admin.suppliers.index') }}">⬅ Back</a>
            </div>
        </div>

        {{-- ERROR ALERT (nice) --}}
        @if ($errors->any())
            <div class="card card-soft mb-3">
                <div class="card-body">
                    <div class="fw-bold text-danger mb-2">⚠️ Please fix these errors:</div>
                    <ul class="mb-0 text-muted">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- SUCCESS SESSION -> TOAST --}}
        @if (session('success'))
            <script>
                window.__FLASH_SUCCESS__ = @json(session('success'));
            </script>
        @endif

        <div class="card card-soft">
            <div class="card-head d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="fw-bold">Supplier Form</div>
                <div class="text-muted small">Fields with * are required</div>
            </div>

            <div class="card-body p-4">
                <form id="editForm" method="POST" action="{{ route('admin.suppliers.update', $supplier->id) }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name *</label>
                            <div class="icon-wrap">
                                <span class="input-icon">👤</span>
                                <input name="name" class="form-control" value="{{ old('name', $supplier->name) }}"
                                    required placeholder="Supplier name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Company</label>
                            <div class="icon-wrap">
                                <span class="input-icon">🏢</span>
                                <input name="company_name" class="form-control"
                                    value="{{ old('company_name', $supplier->company_name) }}"
                                    placeholder="Company name (optional)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <div class="icon-wrap">
                                <span class="input-icon">📞</span>
                                <input name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}"
                                    placeholder="Phone number">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <div class="icon-wrap">
                                <span class="input-icon">✉️</span>
                                <input name="email" type="email" class="form-control"
                                    value="{{ old('email', $supplier->email) }}" placeholder="example@gmail.com">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <div class="icon-wrap">
                                <span class="input-icon">📍</span>
                                <input name="address" class="form-control"
                                    value="{{ old('address', $supplier->address) }}"
                                    placeholder="Street / City / Location">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Note</label>
                            <div class="icon-wrap">
                                <span class="input-icon">📝</span>
                                <textarea name="note" class="form-control" rows="4" placeholder="Extra details...">{{ old('note', $supplier->note) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button id="saveBtn" class="btn btn-primary px-4" type="submit">
                            <span class="btn-text">✅ Update Supplier</span>
                        </button>

                        <a class="btn btn-outline-dark px-4" href="{{ route('admin.suppliers.index') }}">
                            Cancel
                        </a>
                    </div>

                    <div class="text-muted small mt-3">
                        Tip: Keep phone/email for faster contact during restock.
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ===== Loading animation on submit =====
        const form = document.getElementById('editForm');
        const btn = document.getElementById('saveBtn');

        form?.addEventListener('submit', () => {
            btn.classList.add('btn-loading');
        });

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

        // show success toast
        if (window.__FLASH_SUCCESS__) {
            showToast(window.__FLASH_SUCCESS__, 'success');
        }

        // show first error as toast too (optional nice UX)
        @if ($errors->any())
            showToast(@json($errors->first()), 'danger');
        @endif
    </script>
    @include('partials.motion-scripts')
</body>

</html>

