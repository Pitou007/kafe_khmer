<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('partials.motion-head')
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary px-3">
        <span class="navbar-brand">User Dashboard</span>

        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-light btn-sm">Logout</button>
        </form>
    </nav>

    <div class="container py-5">
        <h1>Welcome, {{ auth()->user()->name }}</h1>
        <p class="text-muted">Role: {{ auth()->user()->role }}</p>

        <div class="alert alert-success">
            ✅ You are logged in as USER
        </div>
    </div>

    @include('partials.motion-scripts')
</body>

</html>

