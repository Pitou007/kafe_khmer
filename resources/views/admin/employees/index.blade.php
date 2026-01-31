<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employees</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --bg:#f6f7fb;
      --text:#0f172a;
      --muted:#64748b;
      --brand1:#7c3aed;
      --brand2:#06b6d4;
      --shadow: 0 12px 35px rgba(2, 6, 23, .10);
      --radius: 18px;
    }

    body{
      min-height: 100vh;
      background:
        radial-gradient(1200px 500px at 20% 0%, rgba(124, 58, 237, .12), transparent 60%),
        radial-gradient(900px 450px at 95% 10%, rgba(6, 182, 212, .12), transparent 55%),
        var(--bg);
      color: var(--text);
      overflow-x: hidden;
    }

    .page-wrap{ padding: 18px 0; }

    .topbar{
      background: rgba(255,255,255,.78);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(15, 23, 42, .06);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 14px 16px;
      animation: fadeUp .5s ease;
    }

    .badge-soft{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding: 8px 12px;
      border-radius: 999px;
      background: linear-gradient(90deg, rgba(124,58,237,.12), rgba(6,182,212,.10));
      border: 1px solid rgba(124,58,237,.20);
      color: #1f2937;
      font-weight: 800;
      font-size: 13px;
    }

    .card-soft{
      background: rgba(255,255,255,.88);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(15, 23, 42, .06);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
      animation: fadeUp .6s ease;
    }

    .card-head{
      padding: 14px 16px;
      border-bottom: 1px solid rgba(15,23,42,.06);
      background: linear-gradient(90deg, rgba(124,58,237,.10), rgba(6,182,212,.08));
    }

    .form-control{ border-radius: 14px; }

    .btn{
      border-radius: 14px;
      font-weight: 800;
    }

    .btn-primary{
      border: 0;
      background: linear-gradient(90deg, var(--brand1), var(--brand2));
      box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
      transition: all .18s ease;
    }
    .btn-primary:hover{ transform: translateY(-1px); filter: brightness(1.05); }

    /* round icon buttons */
    .icon-btn{
      width: 36px; height: 36px;
      display:inline-grid;
      place-items:center;
      border-radius: 999px !important;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.85);
      box-shadow: 0 10px 22px rgba(2,6,23,.10);
      transition: transform .14s ease, filter .14s ease;
    }
    .icon-btn:hover{ transform: translateY(-1px); filter: brightness(1.05); }

    .icon-edit{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.22); }
    .icon-del{ background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.22); }

    /* table */
    .table thead th{
      font-size: 12px;
      color: var(--muted);
      letter-spacing: .02em;
      border-bottom: 1px solid rgba(15,23,42,.08) !important;
      white-space: nowrap;
    }
    .table tbody td{
      border-top: 1px solid rgba(15,23,42,.06);
      vertical-align: middle;
    }
    .trow:hover{ background: rgba(124,58,237,.06); }

    .muted{ color: var(--muted); }

    /* small avatar circle */
    .avatar{
      width: 38px; height: 38px;
      border-radius: 999px;
      display:grid;
      place-items:center;
      font-weight: 950;
      color: #fff;
      background: linear-gradient(90deg, var(--brand1), var(--brand2));
      box-shadow: 0 10px 24px rgba(124,58,237,.18);
      flex: 0 0 auto;
    }

    @keyframes fadeUp{
      from{ opacity:0; transform: translateY(12px); }
      to{ opacity:1; transform: translateY(0); }
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
        <h4 class="mb-0 fw-bold">👥 Employees</h4>
        <span class="badge-soft">Manage staff & positions</span>
      </div>
      <div class="text-muted small">Search • Edit • Delete employees</div>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">
      <span class="badge-soft">📅 {{ now()->format('d M Y') }}</span>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">⬅ Back</a>
      <a class="btn btn-primary btn-sm" href="{{ route('admin.employees.create') }}">➕ Add Employee</a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success" style="border-radius:16px;">
      ✅ {{ session('success') }}
    </div>
  @endif

  <div class="card card-soft">
    <div class="card-head d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div class="fw-bold">Employee List</div>

      <div class="d-flex gap-2 align-items-center">
        <input id="empSearch" class="form-control form-control-sm" style="min-width:260px"
               placeholder="Search name / phone / email / position...">
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-sm align-middle mb-0">
        <thead>
        <tr>
          <th style="width:70px;">#</th>
          <th>Name</th>
          <th>Position</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Start Date</th>
          <th class="text-end" style="width:120px;">Actions</th>
        </tr>
        </thead>

        <tbody id="empBody">
        @forelse($employees as $e)
          <tr class="trow"
              data-name="{{ strtolower($e->name) }}"
              data-position="{{ strtolower($e->position_name ?? '') }}"
              data-phone="{{ strtolower($e->phone ?? '') }}"
              data-email="{{ strtolower($e->email ?? '') }}">
            <td class="text-muted">{{ $e->id }}</td>

            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="avatar">{{ strtoupper(substr($e->name, 0, 1)) }}</div>
                <div>
                  <div class="fw-semibold">{{ $e->name }}</div>
                  <div class="muted small">ID: {{ $e->id }}</div>
                </div>
              </div>
            </td>

            <td class="fw-semibold">{{ $e->position_name }}</td>
            <td class="muted">{{ $e->phone ?? '-' }}</td>
            <td class="muted">{{ $e->email ?? '-' }}</td>
            <td class="muted">{{ $e->start_date ?? '-' }}</td>

            <td class="text-end">
              <a class="icon-btn icon-edit me-1"
                 title="Edit"
                 href="{{ route('admin.employees.edit', $e->id) }}">
                ✏️
              </a>

              <form class="d-inline" method="POST" action="{{ route('admin.employees.delete', $e->id) }}">
                @csrf
                <button class="icon-btn icon-del"
                        title="Delete"
                        onclick="return confirm('Delete this employee?')">
                  🗑️
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted py-4">No employees</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
  const search = document.getElementById('empSearch');
  const body = document.getElementById('empBody');

  function applyEmpFilter(){
    const q = (search.value || '').toLowerCase().trim();
    const rows = body.querySelectorAll('tr.trow');

    rows.forEach(r => {
      const text =
        (r.dataset.name || '') + ' ' +
        (r.dataset.position || '') + ' ' +
        (r.dataset.phone || '') + ' ' +
        (r.dataset.email || '');

      r.style.display = text.includes(q) ? '' : 'none';
    });
  }

  search?.addEventListener('input', applyEmpFilter);
</script>

    @include('partials.motion-scripts')
</body>
</html>

