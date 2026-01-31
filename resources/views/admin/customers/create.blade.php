<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Customer</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
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

    /* animated blobs */
    .bg-blobs{
      position:fixed;
      inset:0;
      pointer-events:none;
      z-index:0;
      overflow:hidden;
    }
    .blob{
      position:absolute;
      width:520px;
      height:520px;
      border-radius:999px;
      filter:blur(42px);
      opacity:.35;
      animation:pulse 6s ease-in-out infinite;
    }
    .blob.one{ left:-160px; top:-140px; background:rgba(124,58,237,.42); }
    .blob.two{ right:-170px; top:-100px; background:rgba(6,182,212,.36); animation-delay:1.4s; }
    .blob.three{ left:35%; bottom:-260px; background:rgba(124,58,237,.22); animation-delay:.8s; }

    @keyframes pulse{
      0%,100%{ opacity:.45; transform:translateY(0); }
      50%{ opacity:.75; transform:translateY(-6px); }
    }

    .page-wrap{ position:relative; z-index:2; padding:18px 0; }

    .topbar{
      background:rgba(255,255,255,.78);
      backdrop-filter:blur(12px);
      border:1px solid rgba(15,23,42,.06);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:14px 16px;
    }

    .badge-soft{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:8px 12px;
      border-radius:999px;
      background:linear-gradient(90deg, rgba(124,58,237,.12), rgba(6,182,212,.10));
      border:1px solid rgba(124,58,237,.20);
      color:#1f2937;
      font-weight:800;
      font-size:13px;
      white-space:nowrap;
    }

    .card-soft{
      background:rgba(255,255,255,.88);
      backdrop-filter:blur(10px);
      border:1px solid rgba(15,23,42,.06);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      overflow:hidden;
    }

    .card-head{
      padding:14px 16px;
      border-bottom:1px solid rgba(15,23,42,.06);
      background:linear-gradient(90deg, rgba(124,58,237,.10), rgba(6,182,212,.08));
      font-weight:800;
    }

    .form-label{
      font-weight:700;
      color:#374151;
    }

    .form-control,
    .form-select{
      border-radius:14px;
      border:1px solid rgba(15,23,42,.15);
    }

    .form-control:focus,
    .form-select:focus{
      border-color:var(--brand1);
      box-shadow:0 0 0 .15rem rgba(124,58,237,.25);
    }

    .btn{
      border-radius:14px;
      font-weight:800;
    }

    .btn-primary{
      border:0;
      background:linear-gradient(90deg, var(--brand1), var(--brand2));
      box-shadow:0 10px 25px rgba(124,58,237,.18);
    }

    .btn-primary:hover{ filter:brightness(1.05); }

    @media (max-width: 575.98px){
      .topbar{ padding:12px 12px; }
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
    <div class="topbar mb-3">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <h4 class="mb-0 fw-bold">
              <i class="bi bi-person-plus me-2"></i>Add Customer
            </h4>
            <span class="badge-soft">
              <i class="bi bi-people"></i> Customers
            </span>
          </div>
          <div class="text-muted small">Create new customer / member profile</div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
          <span class="badge-soft">
            <i class="bi bi-calendar3"></i> {{ now()->format('d M Y') }}
          </span>
          <a class="btn btn-dark btn-sm" href="{{ route('admin.customers.index') }}">
            <i class="bi bi-arrow-left"></i> Back
          </a>
        </div>
      </div>
    </div>

    <!-- ERRORS -->
    @if ($errors->any())
      <div class="alert alert-danger" style="border-radius:14px;">
        <strong>Error:</strong>
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
        <i class="bi bi-ui-checks-grid me-2"></i>Customer Information
      </div>

      <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.customers.store') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" value="{{ old('name') }}" required>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Phone</label>
              <input name="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input name="email" type="email" class="form-control" value="{{ old('email') }}">
            </div>
          </div>

          <div class="mb-3 mt-3">
            <label class="form-label">Address</label>
            <input name="address" class="form-control" value="{{ old('address') }}">
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Points</label>
              <input name="points" type="number" min="0" class="form-control" value="{{ old('points', 0) }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Member</label>
              <select name="is_member" class="form-select">
                <option value="1" @selected(old('is_member', 1) == 1)>Yes</option>
                <option value="0" @selected(old('is_member', 1) == 0)>No</option>
              </select>
            </div>
          </div>

          <button class="btn btn-primary w-100 mt-4">
            <i class="bi bi-save"></i> Save Customer
          </button>
        </form>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.motion-scripts')
</body>
</html>
    
