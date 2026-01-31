<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>

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
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes softPulse {

            0%,
            100% {
                opacity: .45;
                transform: translateY(0);
            }

            50% {
                opacity: .75;
                transform: translateY(-6px);
            }
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

        .form-control {
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .10);
        }

        .form-control:focus {
            border-color: rgba(124, 58, 237, .35);
            box-shadow: 0 0 0 .2rem rgba(124, 58, 237, .12);
        }

        .help {
            color: var(--muted);
            font-size: 12px;
            margin-top: 6px;
        }

        .divider {
            height: 1px;
            background: rgba(15, 23, 42, .06);
            margin: 12px 0;
        }

        /* Preview */
        .preview-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: rgba(255, 255, 255, .72);
        }

        .thumb {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            overflow: hidden;
            background: rgba(15, 23, 42, .06);
            display: grid;
            place-items: center;
            box-shadow: 0 10px 22px rgba(2, 6, 23, .10);
            flex: 0 0 auto;
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumb .noimg {
            font-size: 12px;
            font-weight: 900;
            color: rgba(15, 23, 42, .55);
        }

        .preview-title {
            font-weight: 900;
        }

        .muted {
            color: var(--muted);
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

    <div class="container page-wrap" style="max-width: 880px;">

        <!-- TOPBAR -->
        <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-plus-square me-2"></i>Add Product
                    </h4>
                    <span class="badge-soft">
                        <i class="bi bi-box-seam"></i>
                        Inventory
                    </span>
                </div>
                <div class="text-muted small">Create a new product with price, stock, and optional image</div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <a class="btn btn-dark btn-sm" href="{{ route('admin.products.index') }}">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="border-radius:16px;">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle me-1"></i> Please fix these errors:</div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-soft">
            <div class="card-head d-flex justify-content-between align-items-center">
                <div class="fw-bold"><i class="bi bi-ui-checks-grid me-1"></i> Product Form</div>
                <span class="badge-soft"><i class="bi bi-shield-check"></i> Admin</span>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Name</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:14px 0 0 14px;">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input class="form-control" name="name" value="{{ old('name') }}" required
                                    placeholder="e.g. Iced Latte">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">SKU</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:14px 0 0 14px;">
                                    <i class="bi bi-upc-scan"></i>
                                </span>
                                <input class="form-control" name="sku" value="{{ old('sku') }}"
                                    placeholder="e.g. LATTE-001">
                            </div>
                            <div class="help">Optional, but recommended for barcode/scan</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:14px 0 0 14px;">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" name="price"
                                    value="{{ old('price', 0) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stock</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:14px 0 0 14px;">
                                    <i class="bi bi-bar-chart-fill"></i>
                                </span>
                                <input type="number" min="0" class="form-control" name="stock"
                                    value="{{ old('stock', 0) }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="divider"></div>
                        </div>

                        <div class="col-md-7">
                            <label class="form-label fw-semibold">Image</label>
                            <input id="imageInput" type="file" class="form-control" name="image" accept="image/*">
                            <div class="help">jpg / png / webp — max 2MB</div>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Preview</label>
                            <div class="preview-wrap">
                                <div class="thumb" id="imgThumb">
                                    <div class="noimg"><i class="bi bi-image"></i></div>
                                </div>
                                <div>
                                    <div class="preview-title" id="prevName">New Product</div>
                                    <div class="muted small" id="prevMeta">Price: $0.00 • Stock: 0</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <button class="btn btn-primary w-100 py-2">
                                <i class="bi bi-check2-circle me-1"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        // UI only: live preview (no backend change)
        const nameInput = document.querySelector('input[name="name"]');
        const priceInput = document.querySelector('input[name="price"]');
        const stockInput = document.querySelector('input[name="stock"]');
        const imageInput = document.getElementById('imageInput');

        const prevName = document.getElementById('prevName');
        const prevMeta = document.getElementById('prevMeta');
        const imgThumb = document.getElementById('imgThumb');

        function money(n) {
            const x = Number(n || 0);
            return (Math.round(x * 100) / 100).toFixed(2);
        }

        function renderPreview() {
            prevName.textContent = (nameInput.value || 'New Product').trim();
            prevMeta.textContent = `Price: $${money(priceInput.value)} • Stock: ${Number(stockInput.value || 0)}`;
        }

        nameInput?.addEventListener('input', renderPreview);
        priceInput?.addEventListener('input', renderPreview);
        stockInput?.addEventListener('input', renderPreview);
        renderPreview();

        imageInput?.addEventListener('change', () => {
            const file = imageInput.files && imageInput.files[0];
            if (!file) {
                imgThumb.innerHTML = `<div class="noimg"><i class="bi bi-image"></i></div>`;
                return;
            }
            const url = URL.createObjectURL(file);
            imgThumb.innerHTML = `<img src="${url}" alt="preview">`;
        });
    </script>
    @include('partials.motion-scripts')
</body>

</html>

