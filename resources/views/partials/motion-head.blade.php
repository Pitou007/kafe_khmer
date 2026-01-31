<style>
    :root {
        --motion-ease: cubic-bezier(.2, .65, .2, 1);
        --motion-fast: 220ms;
        --motion-base: 420ms;
        --motion-slow: 720ms;
    }

    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 1ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 1ms !important;
            scroll-behavior: auto !important;
        }
    }

    body {
        scroll-behavior: smooth;
    }

    body.page-loaded .card,
    body.page-loaded .card-soft,
    body.page-loaded .topbar,
    body.page-loaded .badge-soft,
    body.page-loaded .alert,
    body.page-loaded .table-responsive,
    body.page-loaded .table,
    body.page-loaded .btn,
    body.page-loaded .form-control,
    body.page-loaded .offcanvas,
    body.page-loaded .sidebar-desktop {
        animation: floatIn var(--motion-base) var(--motion-ease) both;
    }

    body.page-loaded .card,
    body.page-loaded .card-soft {
        animation-delay: 40ms;
    }

    body.page-loaded .topbar {
        animation-delay: 80ms;
    }

    body.page-loaded .table-responsive,
    body.page-loaded .table {
        animation-delay: 120ms;
    }

    .reveal {
        opacity: 0;
        transform: translateY(14px);
        transition: opacity var(--motion-base) var(--motion-ease),
            transform var(--motion-base) var(--motion-ease);
    }

    .reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .btn,
    .nav-link,
    .sb-link,
    .sb-dd {
        transition: transform var(--motion-fast) var(--motion-ease),
            box-shadow var(--motion-fast) var(--motion-ease),
            background-color var(--motion-fast) var(--motion-ease),
            color var(--motion-fast) var(--motion-ease);
    }

    .btn:hover,
    .nav-link:hover,
    .sb-link:hover,
    .sb-dd:hover {
        transform: translateY(-1px);
    }

    @keyframes floatIn {
        from {
            opacity: 0;
            transform: translateY(12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

