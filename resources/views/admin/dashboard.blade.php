<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --bg: #f6f7fb;
      --text: #0f172a;
      --muted: #64748b;

      --brand1: #7c3aed;
      --brand2: #06b6d4;
      --brand3: #f97316;

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

    .theme-dark {
      --bg: #0b1220;
      --text: #e2e8f0;
      --muted: #94a3b8;
      --shadow: 0 14px 40px rgba(2, 6, 23, .35);
    }

    .theme-dark .topbar,
    .theme-dark .card-soft,
    .theme-dark .mobile-topbar {
      background: rgba(15, 23, 42, .88);
      border-color: rgba(148, 163, 184, .16);
      color: var(--text);
    }

    .theme-dark .badge-soft {
      background: linear-gradient(90deg, rgba(124, 58, 237, .18), rgba(6, 182, 212, .12));
      border-color: rgba(148, 163, 184, .22);
      color: #e2e8f0;
    }

    .theme-dark .text-muted {
      color: var(--muted) !important;
    }

    .theme-dark .theme-toggle {
      border-color: rgba(148, 163, 184, .25);
      background: rgba(15, 23, 42, .75);
      color: #e2e8f0;
    }

    .theme-dark .btn-outline-dark {
      color: #e2e8f0;
      border-color: rgba(148, 163, 184, .35);
    }

    .theme-dark .btn-outline-dark:hover {
      background: rgba(148, 163, 184, .12);
      color: #fff;
    }

    /* ---------------- Sidebar ---------------- */
    .sidebar-desktop {
      width: 270px;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background: linear-gradient(180deg, #0b1220, #0b1220 40%, #0a1020);
      border-right: 1px solid rgba(255, 255, 255, .06);
      color: #fff;
      padding: 18px 14px;
      z-index: 1030;
      animation: slideInLeft .5s ease;
    }

    @media (min-width: 992px) {
      .content-responsive {
        margin-left: 270px;
        padding: 26px;
      }

      .mobile-topbar {
        display: none !important;
      }
    }

    @media (max-width: 991.98px) {
      .content-responsive {
        margin-left: 0;
        padding: 12px;
      }
    }

    .brand {
      font-size: 16px;
      font-weight: 900;
      padding: 12px 12px;
      border-radius: 16px;
      background: linear-gradient(90deg, rgba(124, 58, 237, .22), rgba(6, 182, 212, .10));
      border: 1px solid rgba(255, 255, 255, .09);
      box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
      margin-bottom: 14px;
    }

    .side-link {
      color: rgba(255, 255, 255, .85);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 14px;
      margin-bottom: 6px;
      transition: all .18s ease;
    }

    .side-link:hover {
      transform: translateX(3px);
      background: rgba(255, 255, 255, .10);
      color: #fff;
    }

    .side-link.active {
      background: linear-gradient(90deg, rgba(124, 58, 237, .38), rgba(6, 182, 212, .15));
      border: 1px solid rgba(255, 255, 255, .10);
      box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
      color: #fff;
    }

    .sidebar-sub {
      margin-left: 12px;
      padding-left: 16px;
      border-left: 2px solid rgba(255, 255, 255, .12);
      font-size: 14px;
    }

    .sidebar-sub2 {
      margin-left: 24px;
      padding-left: 16px;
      border-left: 2px dashed rgba(255, 255, 255, .12);
      font-size: 13px;
    }

    /* ---------------- Mobile topbar ---------------- */
    .mobile-topbar {
      background: rgba(255, 255, 255, .75);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(15, 23, 42, .06);
    }

    /* ---------------- Topbar ---------------- */
    .topbar {
      background: rgba(255, 255, 255, .78);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(15, 23, 42, .06);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 16px 18px;
      animation: fadeUp .6s ease;
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
      font-weight: 700;
      font-size: 13px;
    }

    /* ---------------- Cards ---------------- */
    .card-soft {
      background: rgba(255, 255, 255, .88);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(15, 23, 42, .06);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
      position: relative;
      transition: transform .18s ease, box-shadow .18s ease;
      animation: fadeUp .7s ease;
    }

    .card-soft:hover {
      transform: translateY(-3px);
      box-shadow: 0 18px 45px rgba(2, 6, 23, .12);
    }

    .stat-title {
      color: var(--muted);
      font-size: 13px;
      font-weight: 800;
      letter-spacing: .2px;
    }

    .stat-value {
      font-size: 28px;
      font-weight: 950;
      margin-top: 6px;
    }

    .stat-card::before {
      content: "";
      position: absolute;
      inset: 0 0 auto 0;
      height: 5px;
      background: linear-gradient(90deg, var(--brand1), var(--brand2));
    }

    .stat-card.orange::before {
      background: linear-gradient(90deg, var(--brand3), #f59e0b);
    }

    .stat-card.cyan::before {
      background: linear-gradient(90deg, var(--brand2), #22c55e);
    }

    .stat-card.purple::before {
      background: linear-gradient(90deg, var(--brand1), #ec4899);
    }

    /* ---------------- Buttons ---------------- */
    .btn-primary {
      border: 0;
      background: linear-gradient(90deg, var(--brand1), var(--brand2));
      box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
      transition: all .18s ease;
    }

    .btn-primary:hover {
      filter: brightness(1.05);
      transform: translateY(-1px);
    }

    .theme-toggle {
      border: 1px solid rgba(15, 23, 42, .12);
      background: rgba(255, 255, 255, .85);
      border-radius: 999px;
      padding: 6px 10px;
      font-weight: 700;
      font-size: 12px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .theme-toggle .theme-icon {
      width: 18px;
      display: inline-flex;
      justify-content: center;
    }

    /* Chart container */
    .chart-wrap {
      padding: 8px 4px 0;
    }

    /* ---------------- Animations ---------------- */
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

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-16px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
  </style>
    @include('partials.motion-head')
</head>

<body>
  
  {{-- MOBILE TOPBAR --}}
  <div class="mobile-topbar d-lg-none sticky-top shadow-sm p-2 d-flex align-items-center justify-content-between">
    <button class="btn btn-dark btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
      ☰ Menu
    </button>
    <div class="fw-bold">☕ Kafe Khmer</div>
    <div style="width:40px;"></div>
  </div>

  {{-- DESKTOP SIDEBAR --}}
  <div class="sidebar-desktop d-none d-lg-block">
    <div class="brand">☕ Kafe Khmer Admin</div>
    @include('admin.partials.sidebar-menu')
  </div>

  {{-- MOBILE SIDEBAR --}}
  <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileSidebar"
    style="width:270px;background:linear-gradient(180deg,#0b1220,#0a1020);color:#fff;">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title text-white">☕ Kafe Khmer Admin</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
      <div style="padding:18px 14px;">
        @include('admin.partials.sidebar-menu')
      </div>
    </div>
  </div>

  {{-- CONTENT --}}
  <div class="content-responsive">

    {{-- TOPBAR --}}
    <div class="topbar d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div>
        <h4 class="mb-0 fw-bold">Dashboard</h4>
        <div class="text-muted small">Overview of your store performance</div>
      </div>

      <div class="d-flex gap-2 align-items-center flex-wrap">
        <span class="badge-soft">Today: {{ now()->format('d M Y') }}</span>
        
        <a class="btn btn-primary btn-sm" href="{{ route('admin.pos') }}">Open POS</a>
        
        <button class="theme-toggle" type="button" data-theme-toggle aria-pressed="false">
          <span class="theme-icon" aria-hidden="true"></span>
          <span class="theme-label">Dark mode</span>
        </button>
      </div>
    </div>

    {{-- STATS --}}
    <div class="row g-3 mt-2">
      <div class="col-md-3 col-sm-6">
        <div class="card card-soft stat-card purple">
          <div class="card-body">
            <div class="stat-title">Products</div>
            <div class="stat-value">{{ number_format($productsCount) }}</div>
            <div class="text-muted small">Total items in stock list</div>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="card card-soft stat-card cyan">
          <div class="card-body">
            <div class="stat-title">Sales</div>
            <div class="stat-value">{{ number_format($salesCount) }}</div>
            <div class="text-muted small">Total invoices created</div>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="card card-soft stat-card orange">
          <div class="card-body">
            <div class="stat-title">Today Revenue</div>
            <div class="stat-value">${{ number_format($todayRevenue, 2) }}</div>
            <div class="text-muted small">Sum of final total today</div>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="card card-soft stat-card purple">
          <div class="card-body">
            <div class="stat-title">Users</div>
            <div class="stat-value">{{ number_format($usersCount) }}</div>
            <div class="text-muted small">Admin/cashiers in system</div>
          </div>
        </div>
      </div>
    </div>

    {{-- CHART + QUICK ACTION --}}
    <div class="row g-3 mt-1">
      <div class="col-lg-8">
        <div class="card card-soft">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h5 class="mb-0 fw-bold">Sales (Last 7 Days)</h5>
              <span class="text-muted small">📈 Revenue chart</span>
            </div>
            <div class="chart-wrap">
              <canvas id="salesChart" height="120"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card card-soft">
          <div class="card-body">
            <h5 class="mb-3 fw-bold">Quick Actions</h5>
            <a href="{{ route('admin.pos') }}" class="btn btn-primary w-100 mb-2">🧾 Open POS</a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-outline-dark w-100 mb-2">➕ Add Product</a>
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-dark w-100 mb-2">🏷️ Create
              Promotion</a>
            <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-dark w-100">📊 View Sales</a>
            <hr>
            <div class="text-muted small">
              Tip: Add Products first → then use POS to create sales.
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <script>
    // close mobile sidebar when click menu item
    document.querySelectorAll('#mobileSidebar a').forEach(a => {
      a.addEventListener('click', () => {
        const el = document.getElementById('mobileSidebar');
        const instance = bootstrap.Offcanvas.getInstance(el);
        if (instance) instance.hide();
      });
    });

    // chart
    const labels = @json($labels);
    const data = @json($data);

    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Revenue',
          data,
          tension: 0.35,
          fill: true,
          pointRadius: 3,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        interaction: {
          mode: 'index',
          intersect: false
        },
        plugins: {
          legend: {
            display: true
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return ' $' + Number(context.raw || 0).toLocaleString();
              }
            }
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>

    @include('partials.motion-scripts')
</body>

</html>






