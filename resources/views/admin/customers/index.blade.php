<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customers</title>

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
      animation:softPulse 6s ease-in-out infinite;
    }
    .blob.one{ left:-160px; top:-140px; background:rgba(124,58,237,.42); }
    .blob.two{ right:-170px; top:-100px; background:rgba(6,182,212,.36); animation-delay:1.4s; }
    .blob.three{ left:35%; bottom:-260px; background:rgba(124,58,237,.22); animation-delay:.8s; }

    .page-wrap{ padding:18px 0; position:relative; z-index:2; }

    @keyframes fadeUp{
      from{ opacity:0; transform:translateY(18px); }
      to{ opacity:1; transform:translateY(0); }
    }
    @keyframes softPulse{
      0%,100%{ opacity:.45; transform:translateY(0); }
      50%{ opacity:.75; transform:translateY(-6px); }
    }

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
      animation:fadeUp .65s ease both;
    }

    .card-head{
      padding:14px 16px;
      border-bottom:1px solid rgba(15,23,42,.06);
      background:linear-gradient(90deg, rgba(124,58,237,.10), rgba(6,182,212,.08));
      font-weight:800;
    }

    .btn{ border-radius:14px; font-weight:800; }
    .btn-primary{
      border:0;
      background:linear-gradient(90deg, var(--brand1), var(--brand2));
      box-shadow:0 10px 25px rgba(124,58,237,.18);
      transition:transform .18s ease, filter .18s ease;
    }
    .btn-primary:hover{ transform:translateY(-1px); filter:brightness(1.05); }

    .chip{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:7px 10px;
      border-radius:999px;
      background:rgba(255,255,255,.75);
      border:1px solid rgba(15,23,42,.08);
      font-weight:800;
      color:#111827;
      white-space:nowrap;
    }

    .table thead th{
      font-size:12px;
      color:var(--muted);
      letter-spacing:.02em;
      border-bottom:1px solid rgba(15,23,42,.08) !important;
      white-space:nowrap;
      background:rgba(249,250,251,.8);
    }
    .table tbody td{
      border-top:1px solid rgba(15,23,42,.06);
      vertical-align:middle;
    }
    .trow:hover{ background:rgba(124,58,237,.06); }

    .pill{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding:7px 10px;
      border-radius:999px;
      font-weight:900;
      font-size:12px;
      border:1px solid rgba(15,23,42,.10);
      white-space:nowrap;
    }
    .pill-yes{ background:#dcfce7; color:#166534; }
    .pill-no{ background:#e5e7eb; color:#374151; }

    .searchbox{
      border-radius:14px;
      border:1px solid rgba(15,23,42,.10);
      background:rgba(255,255,255,.75);
    }

    @media (max-width: 575.98px){
      .table td, .table th{ white-space:nowrap; }
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
    <div class="topbar d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
      <div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <h4 class="mb-0 fw-bold">
            <i class="bi bi-people me-2"></i>Customers
          </h4>

          <span class="badge-soft">
            <i class="bi bi-shield-check"></i> Admin
          </span>
        </div>
        <div class="text-muted small">Members / Walk-in customers</div>
      </div>

      <div class="d-flex gap-2 flex-wrap">
        <span class="badge-soft">
          <i class="bi bi-calendar3"></i> {{ now()->format('d M Y') }}
        </span>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">
          <i class="bi bi-arrow-left"></i> Back
        </a>

        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-circle"></i> Add
        </a>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success" style="border-radius:14px;">
        <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
      </div>
    @endif

    <!-- FILTER CARD -->
    <div class="card card-soft mb-3">
      <div class="card-body">
        <div class="row g-2 align-items-end">
          <div class="col-12 col-md-6">
            <label class="form-label mb-1">Search</label>
            <input id="searchCustomer" class="form-control searchbox" placeholder="Search name / phone / email...">
          </div>

          <div class="col-12 col-md-3">
            <label class="form-label mb-1">Member</label>
            <select id="memberFilter" class="form-select searchbox">
              <option value="all">All</option>
              <option value="yes">Member only</option>
              <option value="no">Non-member only</option>
            </select>
          </div>

          <div class="col-12 col-md-3 d-grid">
            <button class="btn btn-dark" type="button" onclick="resetFilter()">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- SUMMARY -->
    @php
      $totalCustomers = $customers->count();
      $totalMembers = $customers->where('is_member', 1)->count();
      $totalPoints = (int) $customers->sum('points');
    @endphp

    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4">
        <div class="card card-soft">
          <div class="card-body">
            <div class="text-muted small">Total Customers</div>
            <div class="fs-4 fw-bold">{{ number_format($totalCustomers) }}</div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card card-soft">
          <div class="card-body">
            <div class="text-muted small">Total Members</div>
            <div class="fs-4 fw-bold">{{ number_format($totalMembers) }}</div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card card-soft">
          <div class="card-body">
            <div class="text-muted small">Total Points</div>
            <div class="fs-4 fw-bold">{{ number_format($totalPoints) }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- TABLE CARD -->
    <div class="card card-soft">
      <div class="card-head d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
          <i class="bi bi-list-ul me-2"></i>Customer List
        </div>
        <span class="chip">
          <i class="bi bi-collection"></i> Rows: <span id="rowCount">{{ $customers->count() }}</span>
        </span>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm align-middle mb-0" id="customersTable">
            <thead>
              <tr>
                <th style="width:70px;">#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th class="text-center">Points</th>
                <th class="text-center">Member</th>
                <th class="text-end" style="width:190px;">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($customers as $c)
                <tr class="trow"
                    data-name="{{ strtolower($c->name) }}"
                    data-phone="{{ strtolower($c->phone ?? '') }}"
                    data-email="{{ strtolower($c->email ?? '') }}"
                    data-member="{{ $c->is_member ? 'yes' : 'no' }}">
                  <td class="text-muted">{{ $c->id }}</td>

                  <td class="fw-semibold">
                    <div class="d-flex align-items-center gap-2">
                      <span class="badge-soft" style="padding:6px 10px;">
                        <i class="bi bi-person"></i>
                      </span>
                      <span>{{ $c->name }}</span>
                    </div>
                  </td>

                  <td>{{ $c->phone ?? '-' }}</td>
                  <td>{{ $c->email ?? '-' }}</td>

                  <td class="text-center">
                    <span class="badge-soft">
                      <i class="bi bi-star-fill"></i> {{ $c->points }}
                    </span>
                  </td>

                  <td class="text-center">
                    @if($c->is_member)
                      <span class="pill pill-yes"><i class="bi bi-check-circle"></i> YES</span>
                    @else
                      <span class="pill pill-no"><i class="bi bi-x-circle"></i> NO</span>
                    @endif
                  </td>

                  <td class="text-end">
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('admin.customers.edit', $c->id) }}">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <form class="d-inline" method="POST"
                          action="{{ route('admin.customers.delete', $c->id) }}"
                          onsubmit="return confirm('Delete this customer?')">
                      @csrf
                      <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash3"></i> Delete
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-muted text-center py-4">
                    <i class="bi bi-inbox me-1"></i>No customers
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

  <script>
    const searchInput = document.getElementById('searchCustomer');
    const memberFilter = document.getElementById('memberFilter');
    const rowCount = document.getElementById('rowCount');

    function applyFilter(){
      const q = (searchInput.value || '').toLowerCase().trim();
      const m = memberFilter.value;

      let shown = 0;

      document.querySelectorAll('#customersTable tbody tr').forEach(tr => {
        const name = tr.dataset.name || '';
        const phone = tr.dataset.phone || '';
        const email = tr.dataset.email || '';
        const member = tr.dataset.member || 'no';

        const matchText = (name.includes(q) || phone.includes(q) || email.includes(q));
        const matchMember = (m === 'all') ? true : (member === m);

        const ok = matchText && matchMember;
        tr.style.display = ok ? '' : 'none';
        if(ok) shown++;
      });

      if(rowCount) rowCount.innerText = shown;
    }

    function resetFilter(){
      searchInput.value = '';
      memberFilter.value = 'all';
      applyFilter();
    }

    searchInput.addEventListener('input', applyFilter);
    memberFilter.addEventListener('change', applyFilter);
  </script>

    @include('partials.motion-scripts')
</body>
</html>

