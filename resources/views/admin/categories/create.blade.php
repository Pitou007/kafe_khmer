<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Category • Kafe Khmer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #f6f7fb;
            --text: #0f172a;
            --muted: #64748b;

            --coffee: #7c3aed;
            /* purple */
            --mint: #06b6d4;
            /* cyan */
            --latte: #f59e0b;
            /* coffee-ish */
            --shadow: 0 12px 35px rgba(2, 6, 23, .10);
            --radius: 18px;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(1200px 500px at 20% 0%, rgba(124, 58, 237, .12), transparent 60%),
                radial-gradient(900px 450px at 95% 10%, rgba(6, 182, 212, .12), transparent 55%),
                radial-gradient(700px 400px at 50% 100%, rgba(245, 158, 11, .10), transparent 60%),
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
            font-weight: 900;
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

        .form-control {
            border-radius: 14px;
            padding: 12px 14px;
            font-weight: 700;
        }

        .form-control:focus {
            border-color: rgba(124, 58, 237, .35);
            box-shadow: 0 0 0 .2rem rgba(124, 58, 237, .12);
        }

        .label {
            font-weight: 900;
            margin-bottom: 6px;
        }

        .btn {
            border-radius: 14px;
            font-weight: 900;
            padding: 10px 14px;
            transition: all .18s ease;
        }

        .btn-primary {
            border: 0;
            background: linear-gradient(90deg, var(--coffee), var(--mint));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        .btn-outline-dark {
            border-radius: 14px;
            font-weight: 900;
        }

        .hint {
            font-size: 12px;
            color: var(--muted);
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(245, 158, 11, .12);
            border: 1px solid rgba(245, 158, 11, .22);
            font-weight: 900;
        }

        .input-pad {
            padding-left: 58px !important;
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
    <div class="container page-wrap" style="max-width: 820px;">

        {{-- TOPBAR --}}
        <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-bold">☕ Create Category</h4>
                    <span class="badge-soft">Kafe Khmer • Admin</span>
                </div>
                <div class="text-muted small">
                    Add a category like: Coffee, Tea, Dessert, Snack…
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark btn-sm">⬅ Back</a>
            </div>
        </div>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <b>Error:</b>
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <div class="card card-soft">
            <div class="card-body p-4 p-md-5">

                <div class="mb-3">
                    <div class="fw-bold" style="font-size:18px;">🫘 Category Information</div>
                    <div class="hint">This category will appear in product forms and POS filters.</div>
                </div>

                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="label form-label">Category Name</label>

                        <div class="input-wrap">
                            <div class="input-icon">☕</div>
                            <input name="name" class="form-control input-pad" value="{{ old('name') }}"
                                placeholder="e.g. Coffee / Tea / Dessert" required autofocus>
                        </div>

                        <div class="hint mt-2">
                            Tip: Keep it short (1–2 words). Example: “Hot Coffee”, “Iced Coffee”.
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button class="btn btn-primary">
                            ✅ Save Category
                        </button>

                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.motion-scripts')
</body>

</html>

