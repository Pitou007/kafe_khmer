<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Product</title>

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
            max-width: 920px;
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

        /* Current image card */
        .img-card {
            border-radius: 18px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: rgba(255, 255, 255, .72);
            padding: 12px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .thumb {
            width: 92px;
            height: 92px;
            border-radius: 18px;
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

        .muted {
            color: var(--muted);
        }

        /* Mini preview for new upload */
        .preview-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: rgba(255, 255, 255, .72);
        }

        .preview-title {
            font-weight: 900;
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
                        <i class="bi bi-pencil-square me-2"></i>Edit Product
                    </h4>
                    <span class="badge-soft">
                        <i class="bi bi-box-seam"></i>
                        Update item
                    </span>
                </div>
                <div class="text-muted small">Edit name, SKU, price, stock, and update image</div>
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
                <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Name</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:14px 0 0 14px;">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input id="nameInput" class="form-control" name="name"
                                    value="{{ old('name', $product->name) }}" required placeholder="e.g. Iced Latte">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">SKU</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:14px 0 0 14px;">
                                    <i class="bi bi-upc-scan"></i>
                                </span>
                                <input class="form-control" name="sku" value="{{ old('sku', $product->sku) }}"
                                    placeholder="e.g. LATTE-001">
                            </div>
                            <div class="help">Optional, but recommended for scanning</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:14px 0 0 14px;">$</span>
                                <input id="priceInput" type="number" step="0.01" min="0" class="form-control"
                                    name="price" value="{{ old('price', $product->price) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stock</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:14px 0 0 14px;">
                                    <i class="bi bi-bar-chart-fill"></i>
                                </span>
                                <input id="stockInput" type="number" min="0" class="form-control" name="stock"
                                    value="{{ old('stock', $product->stock) }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="divider"></div>
                        </div>

                        <!-- CURRENT IMAGE -->
                        <div class="col-md-7">
                            <label class="form-label fw-semibold">Current Image</label>
                            <div class="img-card">
                                <div class="thumb">
                                    @if ($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="current">
                                    @else
                                        <div class="noimg"><i class="bi bi-image"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold">Current photo</div>
                                    <div class="muted small">
                                        @if ($product->image_path)
                                            Stored in: <span class="text-muted">{{ $product->image_path }}</span>
                                        @else
                                            No image uploaded yet
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CHANGE IMAGE + PREVIEW -->
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Change Image</label>
                            <input id="imageInput" type="file" class="form-control" name="image"
                                accept="image/*">
                            <div class="help">jpg / png / webp — max 2MB</div>

                            <div class="mt-3">
                                <label class="form-label fw-semibold">New Preview</label>
                                <div class="preview-wrap">
                                    <div class="thumb" id="imgThumb">
                                        <div class="noimg"><i class="bi bi-image"></i></div>
                                    </div>
                                    <div>
                                        <div class="preview-title" id="prevName">{{ old('name', $product->name) }}
                                        </div>
                                        <div class="muted small" id="prevMeta">
                                            Price: ${{ number_format(old('price', $product->price), 2) }} • Stock:
                                            {{ old('stock', $product->stock) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <button class="btn btn-primary w-100 py-2">
                                <i class="bi bi-check2-circle me-1"></i> Update
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        // UI-only live preview (no backend changes)
        const nameInput = document.getElementById('nameInput');
        const priceInput = document.getElementById('priceInput');
        const stockInput = document.getElementById('stockInput');
        const imageInput = document.getElementById('imageInput');

        const prevName = document.getElementById('prevName');
        const prevMeta = document.getElementById('prevMeta');
        const imgThumb = document.getElementById('imgThumb');

        function money(n) {
            const x = Number(n || 0);
            return (Math.round(x * 100) / 100).toFixed(2);
        }

        function renderPreview() {
            prevName.textContent = (nameInput.value || '').trim() || 'Product';
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

