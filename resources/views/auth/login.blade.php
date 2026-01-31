<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #0b1220;
            --card: rgba(255, 255, 255, .10);
            --border: rgba(255, 255, 255, .16);
            --text: #e5e7eb;
            --muted: #a7b0c0;
            --brand1: #7c3aed;
            --brand2: #06b6d4;
            --shadow: 0 18px 55px rgba(0, 0, 0, .35);
            --radius: 22px;
        }

        body {
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(900px 420px at 10% 0%, rgba(124, 58, 237, .35), transparent 55%),
                radial-gradient(900px 420px at 90% 10%, rgba(6, 182, 212, .28), transparent 55%),
                radial-gradient(700px 360px at 50% 100%, rgba(249, 115, 22, .18), transparent 60%),
                linear-gradient(180deg, #070b14, #0b1220 55%, #070b14);
            overflow-x: hidden;
        }

        .auth-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 12px;
        }

        .glass {
            border-radius: var(--radius);
            background: var(--card);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
            overflow: hidden;
            animation: popIn .55s ease;
            width: 100%;
            max-width: 460px;
        }

        .glass-top {
            padding: 18px 20px;
            background: linear-gradient(90deg, rgba(124, 58, 237, .22), rgba(6, 182, 212, .18));
            border-bottom: 1px solid rgba(255, 255, 255, .14);
        }

        .logo {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 16px 38px rgba(124, 58, 237, .25);
            font-size: 22px;
        }

        .h-title {
            font-weight: 950;
            margin: 0;
            letter-spacing: .2px;
        }

        .sub {
            color: var(--muted);
            font-size: 14px;
            margin-top: 4px;
        }

        .glass-body {
            padding: 22px 20px 18px;
        }

        /* inputs */
        .form-label {
            color: rgba(229, 231, 235, .92);
            font-weight: 700;
        }

        .form-control {
            border-radius: 16px;
            padding: 12px 14px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .16);
            color: var(--text);
            transition: .18s ease;
        }

        .form-control::placeholder {
            color: rgba(167, 176, 192, .75);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, .10);
            border-color: rgba(6, 182, 212, .55);
            box-shadow: 0 0 0 .18rem rgba(6, 182, 212, .18);
            color: var(--text);
        }

        /* password toggle */
        .pw-wrap {
            position: relative;
        }

        .pw-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .14);
            color: var(--text);
            border-radius: 12px;
            padding: 6px 10px;
            font-weight: 800;
            font-size: 12px;
            transition: .18s ease;
        }

        .pw-btn:hover {
            transform: translateY(-50%) scale(1.02);
            background: rgba(255, 255, 255, .14);
        }

        /* remember switch (custom) */
        .switch-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            user-select: none;
        }

        .switch {
            position: relative;
            width: 52px;
            height: 30px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .18);
            transition: .18s ease;
            cursor: pointer;
            flex: 0 0 auto;
        }

        .switch::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 4px;
            width: 22px;
            height: 22px;
            border-radius: 999px;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, .88);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .25);
            transition: .18s ease;
        }

        .switch-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .switch-input:checked+.switch {
            background: linear-gradient(90deg, rgba(124, 58, 237, .85), rgba(6, 182, 212, .85));
            border-color: rgba(255, 255, 255, .22);
            box-shadow: 0 14px 35px rgba(124, 58, 237, .20);
        }

        .switch-input:checked+.switch::after {
            left: 26px;
            background: #fff;
        }

        .switch-label {
            color: var(--muted);
            font-weight: 700;
        }

        /* buttons */
        .btn-brand {
            border: 0;
            border-radius: 999px;
            padding: 12px 14px;
            font-weight: 900;
            background: linear-gradient(90deg, var(--brand1), var(--brand2));
            box-shadow: 0 18px 40px rgba(124, 58, 237, .22);
            transition: .18s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-brand:hover {
            transform: translateY(-1px);
            filter: brightness(1.04);
        }

        .btn-brand:active {
            transform: translateY(0) scale(.99);
        }

        .btn-brand:disabled {
            opacity: .75;
            cursor: not-allowed;
            transform: none;
            filter: none;
        }

        /* loading spinner inside button */
        .btn-spinner {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, .45);
            border-top-color: #fff;
            display: inline-block;
            animation: spin .75s linear infinite;
            vertical-align: -3px;
            margin-right: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .small-link {
            color: rgba(229, 231, 235, .88);
            text-decoration: none;
            font-weight: 700;
        }

        .small-link:hover {
            text-decoration: underline;
        }

        .muted {
            color: var(--muted);
        }

        /* Toast container */
        .toast-container {
            position: fixed;
            right: 16px;
            bottom: 16px;
            z-index: 3000;
        }

        .toast {
            border-radius: 16px !important;
            overflow: hidden;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .30);
            border: 1px solid rgba(255, 255, 255, .12);
            backdrop-filter: blur(10px);
        }

        .toast .toast-body {
            font-weight: 800;
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
    @include('partials.motion-head')
</head>

<body>
    <div class="auth-wrap">
        <div class="glass">

            <div class="glass-top">
                <div class="d-flex align-items-center gap-3">
                    <div class="logo">☕</div>
                    <div>
                        <h3 class="h-title">Kafe Khmer</h3>
                        <div class="sub">Sign in to continue</div>
                    </div>
                </div>
            </div>

            <div class="glass-body">

                <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com"
                            required autofocus>
                        @error('email')
                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="pw-wrap">
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter password" required>
                            <button type="button" class="pw-btn" onclick="togglePw()">SHOW</button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <label class="switch-wrap">
                            <input class="switch-input" type="checkbox" name="remember" id="remember">
                            <span class="switch"></span>
                            <span class="switch-label">Remember me</span>
                        </label>

                        <a href="#" class="small-link">Forgot password?</a>
                    </div>

                    <button id="loginBtn" type="submit" class="btn btn-brand w-100">
                        🔐 Login
                    </button>
                </form>

                <div class="text-center mt-3">
                    <span class="muted">Don't have an account?</span>
                    <a href="/register" class="small-link ms-1">Register</a>
                </div>

            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePw() {
            const input = document.getElementById('password');
            const btn = document.querySelector('.pw-btn');
            const isPw = input.type === 'password';
            input.type = isPw ? 'text' : 'password';
            btn.textContent = isPw ? 'HIDE' : 'SHOW';
        }

        // Toast helper
        function showToast(message, type = 'danger') {
            const container = document.getElementById('toastContainer');
            const id = 't' + Math.random().toString(16).slice(2);

            const bg = (type === 'success') ? 'bg-success' :
                (type === 'info') ? 'bg-info text-dark' :
                (type === 'warning') ? 'bg-warning text-dark' :
                'bg-danger';

            const html = `
        <div id="${id}" class="toast align-items-center text-white ${bg} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">${escapeHtml(message)}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      `;

            container.insertAdjacentHTML('beforeend', html);
            const el = document.getElementById(id);
            const t = new bootstrap.Toast(el, {
                delay: 2500
            });
            t.show();
            el.addEventListener('hidden.bs.toast', () => el.remove());
        }

        function escapeHtml(str) {
            return String(str || '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", "&#039;");
        }

        // Loading animation on submit
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('loginBtn');

        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.innerHTML = `<span class="btn-spinner"></span> Logging in...`;
        });

        // ===== Show toast from Laravel (session + validation) =====
        @if (session('error'))
            showToast(@json(session('error')), 'danger');
        @endif

        @if (session('success'))
            showToast(@json(session('success')), 'success');
        @endif

        @if ($errors->any())
            // show first error as toast
            showToast(@json($errors->first()), 'danger');
        @endif
    </script>
    @include('partials.motion-scripts')
</body>

</html>

