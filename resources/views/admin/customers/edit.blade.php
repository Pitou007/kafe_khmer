<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Customer</title>

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
        }

        /* animated blobs */
        .bg-blobs {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .blob {
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 999px;
            filter: blur(42px);
            opacity: .35;
            animation: pulse 6s ease-in-out infinite;
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

        @keyframes pulse {

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

        .page-wrap {
            position: relative;
            z-index: 2;
            padding: 18px 0;
        }

        .topbar {
            background: rgba(255, 255, 255, .78);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 16px;
        }

        .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(124, 58, 237, .12), rgba(6, 182, 212, .10));
            border: 1px solid rgba(124, 58, 237, .20);
            font-weight: 800;
            font-size: 13px;
        }

        .card-soft {
            background: rgba(255, 255, 255, .88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .card-head {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(15, 23, 42, .06);
            background: linear-gradient(90deg, rgba(124, 58, 237, .10), rgba(6, 182, 212, .08));
            font-weight: 800;
        }

        .form-label {
            font-weight: 700;
            color: #374151;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .15);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--brand1);
            box-shadow: 0 0 0 .15rem rgba(124, 58, 237, .25);
        }

        .btn {
            border-radius: 14px;
            font-weight: 800;
        }

        .btn-primary {
            border: 0;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 10px 25px rgba(124, 58, 237, .18);
        }
    </style>
    @include('partials.motion-head')
</head>

<body>

    <div class="bg-blobs">
        <div class="blob one"></div>
        <div class="blob two"></div>
    </div>

    <div class="container page-wrap">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center mb-3">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-person-gear me-2"></i>Edit Customer
                    </h4>
                    <span class="badge-soft">
                        <i class="bi bi-people"></i> Customers
                    </span>
                </div>
                <div class="text-muted small">Update customer profile & membership</div>
            </div>

            <a href="{{ route('admin.customers.index') }}" class="btn btn-dark btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <!-- ERROR -->
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
                <i class="bi bi-pencil-square me-2"></i>Customer Information
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $customer->email) }}">
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label">Address</label>
                        <input name="address" class="form-control" value="{{ old('address', $customer->address) }}">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Reward Points</label>
                            <input type="number" min="0" name="points" class="form-control"
                                value="{{ old('points', $customer->points) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Membership Status</label>
                            <select name="is_member" class="form-select">
                                <option value="1" @selected(old('is_member', $customer->is_member) == 1)>
                                    Member
                                </option>
                                <option value="0" @selected(old('is_member', $customer->is_member) == 0)>
                                    Regular
                                </option>
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-4">
                        <i class="bi bi-save"></i> Update Customer
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.motion-scripts')
</body>

</html>

