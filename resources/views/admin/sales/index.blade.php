@extends('admin.layouts.app')

@section('title','Sales')

@push('styles')
<style>
    .card-soft{
        background: rgba(255,255,255,.92);
        border: 1px solid rgba(15,23,42,.06);
        border-radius: 18px;
        box-shadow: 0 12px 35px rgba(2,6,23,.10);
        overflow: hidden;
    }

    .pay-badge{
        font-weight: 900;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        border: 1px solid rgba(15,23,42,.10);
        background: rgba(255,255,255,.75);
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
    }

    /* table baseline */
    .table thead th,
    .table tbody td{
        white-space: nowrap;
        vertical-align: middle;
    }

    /* better scroll for very small devices */
    .table-responsive{
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* sticky header (nice when scrolling) */
    .table thead th{
        position: sticky;
        top: 0;
        z-index: 2;
        background: rgba(255,255,255,.96);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(15,23,42,.08) !important;
    }

    /* invoice text nice (ellipsis) */
    .invoice-cell{
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* pagination wrap on mobile */
    .pagination{
        flex-wrap: wrap;
        gap: 6px;
    }

    @media (max-width: 576px){
        .invoice-cell{ max-width: 120px; }
        .btn-sm{ padding: 6px 10px; }
        .table thead th,
        .table tbody td{ font-size: 12px; }
        .pay-badge{ font-size: 11px; padding: 5px 9px; }
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0 fw-bold">📦 Sales</h4>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">⬅ Back</a>
</div>

<div class="card-soft">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>

                        <!-- Hide on small screens -->
                        <th class="d-none d-lg-table-cell">Cashier</th>
                        <th class="d-none d-lg-table-cell">Customer</th>

                        <th>Payment</th>
                        <th class="text-end">Final</th>

                        <!-- Hide on small screens -->
                        <th class="d-none d-xl-table-cell">Date</th>

                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sales as $s)
                        @php
                            $pay = strtolower($s->payment_type ?? 'cash');
                            $cls = $pay === 'cash' ? 'text-success'
                                : ($pay === 'qr' ? 'text-info' : 'text-warning');
                        @endphp

                        <tr>
                            <td class="text-muted">{{ $s->id }}</td>

                            <td class="fw-semibold invoice-cell" title="{{ $s->invoice_number }}">
                                {{ $s->invoice_number }}
                            </td>

                            <!-- Hide on small screens -->
                            <td class="d-none d-lg-table-cell">{{ $s->cashier_name }}</td>
                            <td class="d-none d-lg-table-cell">{{ $s->customer_name ?? '-' }}</td>

                            <td>
                                <span class="pay-badge {{ $cls }}">{{ strtoupper($pay) }}</span>
                            </td>

                            <td class="text-end fw-bold">{{ number_format($s->final_total, 2) }}</td>

                            <!-- Hide on small screens -->
                            <td class="d-none d-xl-table-cell text-muted">
                                {{ \Carbon\Carbon::parse($s->created_at)->format('d M Y H:i') }}
                            </td>

                            <td class="text-end">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.sales.show',$s->id) }}">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No sales yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection

