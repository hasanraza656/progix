<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Sign in · Progix Admin</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}">
</head>
<body>
<main class="auth">
    <form class="auth-card" method="post" action="{{ route('admin.login.attempt') }}" novalidate>
        @csrf
        <img class="logo" src="{{ asset('assets/img/brand/logo.webp') }}" width="1033" height="309" alt="Progix Digital">
        <h1>Welcome <em>back</em></h1>
        <p class="sub">Sign in to manage leads, insights and site settings.</p>

        @if (session('success'))<div class="flash">{{ session('success') }}</div>@endif

        <div class="field {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email">Email</label>
            <input class="in" type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username" autofocus required>
            @error('email')<span class="err">{{ $message }}</span>@enderror
        </div>
        <div class="field">
            <label for="password">Password</label>
            <div class="input-group">
                <input class="in" type="password" id="password" name="password" autocomplete="current-password" required>
                <button class="eye" type="button" aria-label="Show password" onclick="var i=document.getElementById('password');i.type=i.type==='password'?'text':'password'"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
            </div>
            @error('password')<span class="err">{{ $message }}</span>@enderror
        </div>
        <label class="check" style="margin-bottom:22px"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
        <button class="btn btn--green btn--block" type="submit" style="min-height:52px;font-size:16px">Sign in</button>
        <p class="small muted" style="text-align:center;margin:20px 0 0"><a href="{{ route('home') }}">&larr; Back to website</a></p>
    </form>
</main>
</body>
</html>
