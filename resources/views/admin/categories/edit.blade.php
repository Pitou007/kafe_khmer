<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Category</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg:#f6f7fb;
            --text:#0f172a;
            --muted:#64748b;
            --brand1:#7c3aed;
            --brand2:#06b6d4;
            --shadow:0 12px 35px rgba(2,6,23,.10);
            --radius:18px;
        }

        body{
            min-height:100vh;
            background:
                radial-gradient(1200px 500px at 20% 0%, rgba(124,58,237,.12), transparent 60%),
                radial-gradient(900px 450px at 95% 10%, rgba(6,182,212,.12), transparent 55%),
                var(--bg);
            color:var(--text);
            overflow-x:hidden;
        }

        .bg-blobs{
            position:fixed;
            inset:0;
            pointer-events:none;
            z-index:0;
        }
        .blob{
            position:absolute;
            width:520px;height:520px;
            border-radius:999px;
            filter:blur(42px);
            opacity:.35;
            animation:softPulse 6s ease-in-out infinite;
        }
        .blob.one{left:-160px;top:-140px;background:rgba(124,58,237,.42);}
        .blob.two{right:-170px;top:-100px;background:rgba(6,182,212,.36);animation-delay:1.4s;}
        .blob.three{left:35%;bottom:-260px;background:rgba(124,58,237,.22);animation-delay:.8s;}

        @keyframes softPulse{
            0%,100%{opacity:.45;transform:translateY(0);}
            50%{opacity:.75;transform:translateY(-6px);}
        }
        @keyframes fadeUp{
            from{opacity:0;transform:translateY(18px);}
            to{opacity:1;transform:translateY(0);}
        }

        .page-wrap{position:relative;z-index:2;padding:18px 0;}

        .topbar{
            background:rgba(255,255,255,.78);
            backdrop-filter:blur(12px);
            border:1px solid rgba(15,23,42,.06);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            padding:14px 16px;
            animation:fadeUp .55s ease both;
        }

        .badge-soft{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:8px 12px;
            border-radius:999px;
            background:linear-gradient(90deg, rgba(124,58,237,.12), rgba(6,182,212,.10));
            border:1px solid rgba(124,58,237,.20);
            font-weight:800;
            font-size:13px;
        }

        .card-soft{
            background:rgba(255,255,255,.88);
            backdrop-filter:blur(10px);
            border:1px solid rgba(15,23,42,.06);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            animation:fadeUp .65s ease both;
        }

        .card-head{
            padding:14px 16px;
            border-bottom:1px solid rgba(15,23,42,.06);
            background:linear-gradient(90deg, rgba(124,58,237,.10), rgba(6,182,212,.08));
            font-weight:800;
        }

        .form-control{
            border-radius:14px;
            border:1px solid rgba(15,23,42,.10);
        }
        .form-control:focus{
            border-color:rgba(124,58,237,.35);
            box-shadow:0 0 0 .2rem rgba(124,58,237,.12);
        }

        .btn{
            border-radius:14px;
            font-weight:800;
        }
        .btn-primary{
            border:0;
            background:linear-gradient(90deg,var(--brand1),var(--brand2));
            box-shadow:0 10px 25px rgba(124,58,237,.18);
        }
        .btn-primary:hover{
            transform:translateY(-1px);
            filter:brightness(1.05);
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

<div class="container page-wrap" style="max-width:720px;">

    <!-- TOPBAR -->
    <div class="topbar d-flex justify-content-between align-items-center mb-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>Edit Category
                </h4>
                <span class="badge-soft">
                    <i class="bi bi-grid-3x3-gap"></i> Categories
                </span>
            </div>
            <div class="text-muted small">Update category name</div>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-dark btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="border-radius:14px;">
            <strong>Error</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM CARD -->
    <div class="card card-soft">
        <div class="card-head">
            <i class="bi bi-info-circle me-2"></i>Category Information
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Category Name</label>
                    <input name="name"
                           class="form-control"
                           value="{{ old('name', $category->name) }}"
                           placeholder="Enter category name"
                           required>
                </div>

                <button class="btn btn-primary w-100">
                    <i class="bi bi-check-circle me-1"></i> Update Category
                </button>
            </form>
        </div>
    </div>

</div>

    @include('partials.motion-scripts')
</body>
</html>

