<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Install · Progix</title>
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}">
</head>
<body>
<main class="auth">
    <form class="auth-card" method="post" action="{{ url('/system/setup') }}">
        @csrf
        <img class="logo" src="{{ asset('assets/img/brand/logo.webp') }}" width="1033" height="309" alt="Progix Digital">
        <h1>First-time <em>setup</em></h1>
        <p class="sub">The database tables have not been created yet. One click will create them and add the default admin account.</p>
        @if (session('error'))<div class="flash error">{{ session('error') }}</div>@endif
        @if ($dbError)
            <div class="flash error">Cannot connect to the database. Check DB_* values in <code>.env</code>.<br><small>{{ \Illuminate\Support\Str::limit($dbError, 180) }}</small></div>
        @endif
        <button class="btn btn--green btn--block" type="submit" style="min-height:52px;font-size:16px" @disabled($dbError)>Install now</button>
        <p class="small muted" style="margin:18px 0 0">This page disappears automatically once the installation is complete.</p>
    </form>
</main>
</body>
</html>
