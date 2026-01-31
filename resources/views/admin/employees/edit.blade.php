<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Employee</title>
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

    .form-control, .form-select{
      border-radius: 14px;
      padding: .72rem .9rem;
    }

    .field{
      position: relative;
    }
    .field .icon{
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      width: 34px;
      height: 34px;
      border-radius: 12px;
      display: grid;
      place-items: center;
      background: rgba(15,23,42,.06);
      border: 1px solid rgba(15,23,42,.06);
      font-size: 16px;
    }
    .field input, .field select{
      padding-left: 56px;
    }
    .hint{
      color: var(--muted);
      font-size: 12px;
      margin-top: 6px;
    }

    .btn{
      border-radius: 14px;
      font-weight: 900;
    }
    .btn-primary{
      border: 0;
      background: linear-gradient(90deg, var(--brand1), var(--brand2));
      box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
      transition: all .18s ease;
    }
    .btn-primary:hover{ transform: translateY(-1px); filter: brightness(1.05); }

    .btn-dark{ border-radius: 14px; }

    /* Loading button */
    .btn-loading{
      pointer-events: none;
      opacity: .9;
    }
    .btn-loading .spinner{
      width: 18px;
      height: 18px;
      border: 2px solid rgba(255,255,255,.55);
      border-top-color: rgba(255,255,255,1);
      border-radius: 999px;
      display: inline-block;
      animation: spin .7s linear infinite;
      vertical-align: middle;
      margin-right: 10px;
    }
    @keyframes spin{ to{ transform: rotate(360deg); } }

    /* Error box */
    .alert{
      border-radius: 16px;
      border: 1px solid rgba(15,23,42,.08);
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
        <h4 class="mb-0 fw-bold">✏️ Edit Employee</h4>
        <span class="badge-soft">Update employee profile</span>
      </div>
      <div class="text-muted small">Make sure data is correct before saving.</div>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">
      <span class="badge-soft">👤 {{ $employee->name }}</span>
      <a href="{{ route('admin.employees.index') }}" class="btn btn-dark btn-sm">⬅ Back</a>
    </div>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <div class="fw-bold mb-1">❌ Please fix these errors:</div>
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card card-soft">
        <div class="card-head d-flex justify-content-between align-items-center">
          <div class="fw-bold">Employee Information</div>
          <div class="text-muted small">ID: {{ $employee->id }}</div>
        </div>

        <div class="card-body p-4">
          <form id="empForm" method="POST" action="{{ route('admin.employees.update', $employee->id) }}">
            @csrf

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Name</label>
                <div class="field">
                  <div class="icon">👤</div>
                  <input name="name" class="form-control"
                         value="{{ old('name', $employee->name) }}" required>
                </div>
                <div class="hint">Employee full name</div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Position</label>
                <div class="field">
                  <div class="icon">💼</div>
                  <select name="position_id" class="form-select" required>
                    @foreach ($positions as $pos)
                      <option value="{{ $pos->id }}"
                        @selected(old('position_id', $employee->position_id) == $pos->id)>
                        {{ $pos->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="hint">Choose role/position</div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Phone</label>
                <div class="field">
                  <div class="icon">📞</div>
                  <input name="phone" class="form-control"
                         value="{{ old('phone', $employee->phone) }}"
                         placeholder="012 345 678">
                </div>
                <div class="hint">Optional</div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <div class="field">
                  <div class="icon">✉️</div>
                  <input name="email" type="email" class="form-control"
                         value="{{ old('email', $employee->email) }}"
                         placeholder="example@gmail.com">
                </div>
                <div class="hint">Optional</div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Start Date</label>
                <div class="field">
                  <div class="icon">📅</div>
                  <input name="start_date" type="date" class="form-control"
                         value="{{ old('start_date', $employee->start_date) }}">
                </div>
                <div class="hint">When employee started working</div>
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button id="saveBtn" class="btn btn-primary flex-grow-1" type="submit">
                ✅ Update Employee
              </button>
              <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-dark">Cancel</a>
            </div>

          </form>
        </div>
      </div>
    </div>

    {{-- SIDE CARD --}}
    <div class="col-lg-4">
      <div class="card card-soft">
        <div class="card-head">
          <div class="fw-bold">Tips</div>
        </div>
        <div class="card-body">
          <div class="text-muted small mb-2">✅ Use real phone number format</div>
          <div class="text-muted small mb-2">✅ Email should be unique (if you use it)</div>
          <div class="text-muted small">✅ Start date helps for HR reports</div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  // Loading animation on submit
  const form = document.getElementById('empForm');
  const btn  = document.getElementById('saveBtn');

  form?.addEventListener('submit', () => {
    btn.classList.add('btn-loading');
    btn.innerHTML = `<span class="spinner"></span> Updating...`;
  });
</script>

    @include('partials.motion-scripts')
</body>
</html>

