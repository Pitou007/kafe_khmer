<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            color: #0f172a;
        }

        body.theme-dark {
            background: #0b1220;
            color: #e2e8f0;
            --bs-body-bg: #0b1220;
            --bs-body-color: #e2e8f0;
            --bs-border-color: rgba(148, 163, 184, 0.2);
        }

        body.theme-dark .text-muted {
            color: #94a3b8 !important;
        }

        body.theme-dark .card,
        body.theme-dark .table,
        body.theme-dark .modal-content {
            background-color: rgba(15, 23, 42, 0.9);
            color: #e2e8f0;
        }

        body.theme-dark .table {
            --bs-table-color: #e2e8f0;
            --bs-table-bg: rgba(15, 23, 42, 0.9);
            --bs-table-border-color: rgba(148, 163, 184, 0.2);
        }

        body.theme-dark .btn-outline-dark {
            color: #e2e8f0;
            border-color: rgba(148, 163, 184, 0.35);
        }

        body.theme-dark .btn-outline-dark:hover {
            background: rgba(148, 163, 184, 0.12);
            color: #fff;
        }
    </style>
    @stack('styles')
    @include('partials.motion-head')
</head>

<body>
    <div class="d-flex" style="min-height:100vh;">
        {{-- Sidebar --}}
        <aside class="text-white p-3" style="width:280px; background:#0b1220;">
            @include('admin.partials.sidebar-menu') {{-- your sidebar blade --}}
        </aside>

        {{-- Content --}}
        <main class="flex-grow-1 p-3">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @include('partials.motion-scripts')
</body>

</html>

