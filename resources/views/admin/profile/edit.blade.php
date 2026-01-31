@extends('admin.layouts.app')

@section('title','Edit Profile')

@push('styles')
<style>
    .card-soft {
        background: rgba(255,255,255,.92);
        border: 1px solid rgba(15,23,42,.06);
        border-radius: 18px;
        box-shadow: 0 12px 35px rgba(2,6,23,.10);
    }

    body.theme-dark .card-soft {
        background: rgba(15,23,42,.90);
        border-color: rgba(148,163,184,.16);
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0 fw-bold">Edit Profile</h4>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.profile.show') }}" class="btn btn-dark btn-sm">Back</a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger" style="border-radius:16px;">
        <div class="fw-bold mb-1">Please fix the errors below.</div>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card-soft">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">New password</label>
                    <input class="form-control" name="password" type="password" autocomplete="new-password" placeholder="Leave blank to keep current">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirm password</label>
                    <input class="form-control" name="password_confirmation" type="password" autocomplete="new-password">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Save changes</button>
                <a class="btn btn-outline-dark" href="{{ route('admin.profile.show') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

