@php
    // ACTIVE GROUPS
    $openPOS = request()->routeIs('admin.pos*') || request()->routeIs('admin.sales.*');

    $openEmployee = request()->routeIs('admin.employees.*')
        || request()->routeIs('admin.suppliers.*')
        || request()->routeIs('admin.attendance.*');

    $openMember = request()->routeIs('admin.customers.*');

    $openProducts = request()->routeIs('admin.products.*') || request()->routeIs('admin.promotions.*');

    $openReports = request()->routeIs('admin.reports.*');

    $openStock = request()->routeIs('admin.transactions.*');

    $openTxReport = request()->routeIs('admin.reports.transactions');

    $openSettings = request()->routeIs('admin.categories.*') || request()->routeIs('admin.positions.*');

    $openProfile = request()->routeIs('admin.profile.*');
@endphp

<style>
    /* ===== Sidebar UI Upgrade (only for sidebar) ===== */
    .sb-brand {
        font-size: 16px;
        font-weight: 900;
        padding: 12px 12px;
        border-radius: 16px;
        background: linear-gradient(90deg, rgba(124,58,237,.24), rgba(6,182,212,.12));
        border: 1px solid rgba(255,255,255,.09);
        box-shadow: 0 10px 30px rgba(0,0,0,.25);
        margin-bottom: 14px;
        animation: sbFade .45s ease;
    }

    .sb-section {
        margin-top: 12px;
        margin-bottom: 8px;
        padding: 0 10px;
        font-size: 11px;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: rgba(255,255,255,.55);
    }

    .sb-link {
        color: rgba(255,255,255,.86);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 14px;
        margin-bottom: 6px;
        transition: all .18s ease;
        position: relative;
        overflow: hidden;
        animation: sbFadeUp .55s ease;
    }

    .sb-link-btn {
        border: 0;
        background: transparent;
        width: 100%;
        text-align: left;
    }

    .sb-link-btn .theme-icon {
        width: 18px;
        display: inline-flex;
        justify-content: center;
    }

    .sb-link:hover {
        transform: translateX(3px);
        background: rgba(255,255,255,.10);
        color: #fff;
    }

    /* Active indicator bar + glow */
    .sb-link.active {
        background: linear-gradient(90deg, rgba(124,58,237,.38), rgba(6,182,212,.16));
        border: 1px solid rgba(255,255,255,.10);
        box-shadow: 0 10px 25px rgba(124,58,237,.18);
        color: #fff;
    }
    .sb-link.active::before {
        content:"";
        position:absolute;
        left:0; top:0; bottom:0;
        width: 4px;
        background: linear-gradient(180deg, #7c3aed, #06b6d4);
        border-radius: 0 10px 10px 0;
    }

    /* Dropdown header */
    .sb-dd {
        background: transparent;
        border: 0;
        width: 100%;
        color: rgba(255,255,255,.86);
        text-align: left;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 14px;
        margin-bottom: 6px;
        transition: all .18s ease;
        animation: sbFadeUp .55s ease;
    }

    .sb-dd:hover {
        transform: translateX(2px);
        background: rgba(255,255,255,.10);
        color: #fff;
    }

    /* Rotate chevron when expanded */
    .sb-dd .chev {
        margin-left: auto;
        transition: transform .18s ease;
        opacity: .85;
    }
    .sb-dd[aria-expanded="true"] .chev {
        transform: rotate(180deg);
    }

    /* Sub links */
    .sb-sub {
        margin-left: 12px;
        padding-left: 16px;
        border-left: 2px solid rgba(255,255,255,.12);
        font-size: 14px;
    }
    .sb-sub2 {
        margin-left: 24px;
        padding-left: 16px;
        border-left: 2px dashed rgba(255,255,255,.12);
        font-size: 13px;
    }

    /* Smooth collapse (Bootstrap collapse is instant sometimes) */
    .collapse {
        transition: height .22s ease;
    }

    /* Profile box */
    .sb-userbox {
        margin-top: 14px;
        padding: 12px;
        border-radius: 16px;
        background: linear-gradient(90deg, rgba(255,255,255,.08), rgba(255,255,255,.04));
        border: 1px solid rgba(255,255,255,.08);
        box-shadow: 0 10px 28px rgba(0,0,0,.20);
        animation: sbFadeUp .65s ease;
    }
    .sb-userbox .muted {
        font-size: 12px;
        color: rgba(255,255,255,.70);
    }
    .sb-userbox .name {
        font-weight: 900;
        font-size: 14px;
    }
    .sb-pill {
        display:inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        margin-top: 8px;
        color: #fff;
        background: linear-gradient(90deg, rgba(124,58,237,.70), rgba(6,182,212,.55));
        border: 1px solid rgba(255,255,255,.10);
    }

    /* Logout button style */
    .sb-logout {
        border-radius: 14px;
        font-weight: 700;
        transition: transform .18s ease;
    }
    .sb-logout:hover { transform: translateY(-1px); }

    @keyframes sbFade {
        from { opacity:0; transform: translateY(8px); }
        to { opacity:1; transform: translateY(0); }
    }
    @keyframes sbFadeUp {
        from { opacity:0; transform: translateY(10px); }
        to { opacity:1; transform: translateY(0); }
    }
</style>

<div class="sb-section">Main</div>
<a class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
   href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>

<div class="sb-section">Operations</div>

{{-- POS --}}
<button class="sb-dd" type="button" data-bs-toggle="collapse" data-bs-target="#menuPOS"
        aria-expanded="{{ $openPOS ? 'true' : 'false' }}">
    🧾 POS <span class="chev">▾</span>
</button>
<div class="collapse {{ $openPOS ? 'show' : '' }}" id="menuPOS">
    <a class="sb-link sb-sub {{ request()->routeIs('admin.pos') ? 'active' : '' }}"
       href="{{ route('admin.pos') }}">Open POS</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}"
       href="{{ route('admin.sales.index') }}">Sales (Invoices)</a>
</div>

{{-- STOCK --}}
<button class="sb-dd" type="button" data-bs-toggle="collapse" data-bs-target="#menuStock"
        aria-expanded="{{ $openStock ? 'true' : 'false' }}">
    🧰 Stock <span class="chev">▾</span>
</button>
<div class="collapse {{ $openStock ? 'show' : '' }}" id="menuStock">
    <a class="sb-link sb-sub {{ request()->routeIs('admin.transactions.in*') ? 'active' : '' }}"
       href="{{ route('admin.transactions.in') }}">Stock In</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.transactions.out*') ? 'active' : '' }}"
       href="{{ route('admin.transactions.out') }}">Stock Out</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.transactions.transfer*') ? 'active' : '' }}"
       href="{{ route('admin.transactions.transfer') }}">Transfer</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.transactions.broken*') ? 'active' : '' }}"
       href="{{ route('admin.transactions.broken') }}">Broken</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}"
       href="{{ route('admin.transactions.index') }}">History</a>
</div>

<div class="sb-section">Management</div>

{{-- EMPLOYEE --}}
<button class="sb-dd" type="button" data-bs-toggle="collapse" data-bs-target="#menuEmployee"
        aria-expanded="{{ $openEmployee ? 'true' : 'false' }}">
    👨‍💼 Employee <span class="chev">▾</span>
</button>
<div class="collapse {{ $openEmployee ? 'show' : '' }}" id="menuEmployee">
    <a class="sb-link sb-sub {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"
       href="{{ route('admin.employees.index') }}">Employee CRUD</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}"
       href="{{ route('admin.suppliers.index') }}">Suppliers CRUD</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}"
       href="{{ route('admin.attendance.index') }}">Attendance</a>
</div>

{{-- MEMBER --}}
<button class="sb-dd" type="button" data-bs-toggle="collapse" data-bs-target="#menuMember"
        aria-expanded="{{ $openMember ? 'true' : 'false' }}">
    🧑‍🤝‍🧑 Member <span class="chev">▾</span>
</button>
<div class="collapse {{ $openMember ? 'show' : '' }}" id="menuMember">
    <a class="sb-link sb-sub {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
       href="{{ route('admin.customers.index') }}">Member / Customer CRUD</a>
</div>

{{-- PRODUCTS --}}
<button class="sb-dd" type="button" data-bs-toggle="collapse" data-bs-target="#menuProducts"
        aria-expanded="{{ $openProducts ? 'true' : 'false' }}">
    📦 Products <span class="chev">▾</span>
</button>
<div class="collapse {{ $openProducts ? 'show' : '' }}" id="menuProducts">
    <a class="sb-link sb-sub {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
       href="{{ route('admin.products.index') }}">Products CRUD</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}"
       href="{{ route('admin.promotions.index') }}">Promotion CRUD</a>
</div>

{{-- REPORTS --}}
<button class="sb-dd" type="button" data-bs-toggle="collapse" data-bs-target="#menuReports"
        aria-expanded="{{ $openReports ? 'true' : 'false' }}">
    📊 Reports <span class="chev">▾</span>
</button>
<div class="collapse {{ $openReports ? 'show' : '' }}" id="menuReports">
    <a class="sb-link sb-sub {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}"
       href="{{ route('admin.reports.sales') }}">Sales Report</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.reports.stock') ? 'active' : '' }}"
       href="{{ route('admin.reports.stock') }}">Stock Report</a>

    {{-- Transactions Report (nested) --}}
    <button class="sb-dd mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#menuTxReport"
            aria-expanded="{{ $openTxReport ? 'true' : 'false' }}">
        🧾 Transactions Report <span class="chev">▾</span>
    </button>

    <div class="collapse {{ $openTxReport ? 'show' : '' }}" id="menuTxReport">
        <a class="sb-link sb-sub2 {{ (request('type')==='in') && $openTxReport ? 'active' : '' }}"
           href="{{ route('admin.reports.transactions', ['type'=>'in']) }}">• Stock in</a>

        <a class="sb-link sb-sub2 {{ (request('type')==='out') && $openTxReport ? 'active' : '' }}"
           href="{{ route('admin.reports.transactions', ['type'=>'out']) }}">• Stock out</a>

        <a class="sb-link sb-sub2 {{ (request('type')==='transfer') && $openTxReport ? 'active' : '' }}"
           href="{{ route('admin.reports.transactions', ['type'=>'transfer']) }}">• Transfer</a>

        <a class="sb-link sb-sub2 {{ (request('type')==='broken') && $openTxReport ? 'active' : '' }}"
           href="{{ route('admin.reports.transactions', ['type'=>'broken']) }}">• Broken</a>

        <a class="sb-link sb-sub2 {{ (!request('type') || request('type')==='all') && $openTxReport ? 'active' : '' }}"
           href="{{ route('admin.reports.transactions', ['type'=>'all']) }}">• All</a>
    </div>
</div>

<div class="sb-section">System</div>

{{-- SETTINGS --}}
<button class="sb-dd" type="button" data-bs-toggle="collapse" data-bs-target="#menuSettings"
        aria-expanded="{{ $openSettings ? 'true' : 'false' }}">
    ⚙️ Setting & Product <span class="chev">▾</span>
</button>
<div class="collapse {{ $openSettings ? 'show' : '' }}" id="menuSettings">
    <a class="sb-link sb-sub {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
       href="{{ route('admin.categories.index') }}">Categories CRUD</a>

    <a class="sb-link sb-sub {{ request()->routeIs('admin.positions.*') ? 'active' : '' }}"
       href="{{ route('admin.positions.index') }}">Position CRUD</a>
</div>

<div class="sb-section">Account</div>

<a class="sb-link {{ $openProfile ? 'active' : '' }}"
   href="{{ route('admin.profile.show') }}">Profile</a>

<button class="sb-link sb-link-btn" type="button" data-theme-toggle aria-pressed="false">
    <span class="theme-icon" aria-hidden="true"></span>
    <span class="theme-label">Dark mode</span>
</button>

{{-- Logged in box --}}
<div class="sb-userbox">
    <div class="muted">Logged in</div>
    <div class="name">{{ auth()->user()->name }}</div>
    <span class="sb-pill">Role: {{ auth()->user()->role }}</span>
</div>

<form class="mt-3" method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn btn-light w-100 btn-sm sb-logout" type="submit">🚪 Logout</button>
</form>

<script>
    (function () {
        const storageKey = 'kk-theme';
        const body = document.body;

        const moonSvg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20.9 14.5A9 9 0 0 1 9.5 3.1a.75.75 0 0 0-.9-.94A10.5 10.5 0 1 0 21.84 15.4a.75.75 0 0 0-.94-.9z" fill="currentColor"/></svg>';
        const sunSvg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0-5a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1zm0 18a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0v-1a1 1 0 0 1 1-1zm10-8a1 1 0 0 1-1 1h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1zM4 12a1 1 0 0 1-1 1H2a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1zm15.07-7.07a1 1 0 0 1 0 1.42l-.71.7a1 1 0 1 1-1.42-1.4l.71-.72a1 1 0 0 1 1.42 0zM6.06 17.94a1 1 0 0 1 0 1.41l-.7.71a1 1 0 1 1-1.42-1.42l.71-.7a1 1 0 0 1 1.41 0zm12.32 1.41a1 1 0 0 1-1.42 0l-.7-.71a1 1 0 1 1 1.41-1.41l.71.7a1 1 0 0 1 0 1.42zM6.06 6.06a1 1 0 0 1-1.42 0l-.7-.71A1 1 0 0 1 5.36 3.94l.7.7a1 1 0 0 1 0 1.42z" fill="currentColor"/></svg>';

        function applyTheme(mode) {
            if (mode === 'dark') {
                body.classList.add('theme-dark');
            } else {
                body.classList.remove('theme-dark');
            }

            const toggles = Array.from(document.querySelectorAll('[data-theme-toggle]'));
            toggles.forEach(btn => {
                const isDark = body.classList.contains('theme-dark');
                const icon = btn.querySelector('.theme-icon');
                const label = btn.querySelector('.theme-label');
                if (icon) icon.innerHTML = isDark ? sunSvg : moonSvg;
                if (label) label.textContent = isDark ? 'Light mode' : 'Dark mode';
                btn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            });
        }

        function bindToggles() {
            const toggles = Array.from(document.querySelectorAll('[data-theme-toggle]'));
            toggles.forEach(btn => {
                if (btn.dataset.themeBound === '1') return;
                btn.dataset.themeBound = '1';
                btn.addEventListener('click', () => {
                    const next = body.classList.contains('theme-dark') ? 'light' : 'dark';
                    localStorage.setItem(storageKey, next);
                    applyTheme(next);
                });
            });
        }

        const saved = localStorage.getItem(storageKey);
        const initial = saved === 'dark' ? 'dark' : 'light';
        applyTheme(initial);
        bindToggles();

        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(initial);
            bindToggles();
        });
    })();
</script>

