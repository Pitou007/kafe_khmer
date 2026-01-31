@extends('admin.layouts.app')

@section('title','Profile')

@push('styles')
<style>
    .card-soft {
        background: rgba(255,255,255,.92);
        border: 1px solid rgba(15,23,42,.06);
        border-radius: 18px;
        box-shadow: 0 12px 35px rgba(2,6,23,.10);
        overflow: hidden;
    }

    body.theme-dark .card-soft {
        background: rgba(15,23,42,.90);
        border-color: rgba(148,163,184,.16);
    }

    .avatar {
        width: 96px;
        height: 96px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        font-weight: 900;
        font-size: 28px;
        color: #fff;
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        box-shadow: 0 12px 25px rgba(2,6,23,.18);
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 18px;
        align-items: center;
    }

    @media (max-width: 576px) {
        .profile-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .avatar {
            margin: 0 auto;
        }
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0 fw-bold">Profile</h4>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm">Back</a>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-sm">Edit</a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success" style="border-radius:16px;">
        {{ session('success') }}
    </div>
@endif

<div class="card-soft">
    <div class="card-body p-4">
        <div class="profile-grid">
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h5 class="mb-1 fw-bold">{{ $user->name }}</h5>
                <div class="text-muted">{{ $user->email }}</div>
                <div class="mt-2">
                    <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                </div>
            </div>
        </div>

        <hr>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="text-muted small">Account created</div>
                <div class="fw-semibold">
                    {{ optional($user->created_at)->format('d M Y H:i') }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Email verified</div>
                <div class="fw-semibold">
                    {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y H:i') : 'Not verified' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

