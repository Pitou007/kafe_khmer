<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay by QR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('partials.motion-head')
</head>

<body class="bg-light">
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Scan to Pay</h4>
            <div class="text-muted">Sale #{{ $saleId }}</div>
        </div>
        <a class="btn btn-dark btn-sm" href="{{ route('admin.pos') }}">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body text-center">

            <p class="mb-2">Scan this QR with your banking app</p>

            {{-- ✅ Your static QR from storage/app/public/qr/myqr.png --}}
            <img src="{{ asset('storage/qr/myqr.png') }}"
                 alt="QR"
                 style="max-width:320px;width:100%;height:auto;"
                 onerror="this.style.display='none'; document.getElementById('qrError').classList.remove('d-none');">

            <div id="qrError" class="alert alert-danger mt-3 d-none">
                QR image not found. Check: <b>php artisan storage:link</b> and file path: <b>storage/app/public/qr/myqr.png</b>
            </div>

            <div id="statusBox" class="alert alert-warning mt-4 mb-0 d-flex align-items-center justify-content-center gap-2">
                <span id="loadingSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span id="statusText">Waiting for payment verification...</span>
            </div>

            <form class="mt-3" method="POST" action="{{ route('admin.sales.verifyPayment', $saleId) }}">
                @csrf
                <button type="submit" class="btn btn-success">
                    Mark as Paid
                </button>
            </form>

        </div>
    </div>
</div>

<script>
    const SALE_ID = @json($saleId);
    const STATUS_URL = @json(route('admin.pos.payment_status', $saleId));
    const RECEIPT_URL = @json(route('admin.pos.receipt', $saleId));

    async function checkStatus() {
        try {
            const res = await fetch(STATUS_URL, { headers: { 'Accept': 'application/json' }});
            const data = await res.json();

            if ((data.payment_status || '').toLowerCase() === 'paid') {
                const box = document.getElementById('statusBox');
                box.className = 'alert alert-success mt-4 mb-0 d-flex align-items-center justify-content-center gap-2';
                document.getElementById('loadingSpinner').style.display = 'none';
                document.getElementById('statusText').innerText = 'Payment success ✅ Redirecting to receipt...';

                setTimeout(() => window.location.href = RECEIPT_URL, 1200);
                return;
            }
        } catch (e) {
            // ignore polling errors
        }

        setTimeout(checkStatus, 2000);
    }

    checkStatus();
</script>

    @include('partials.motion-scripts')
</body>
</html>

