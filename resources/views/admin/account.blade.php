@extends('admin.layout')
@section('title', 'My account')
@section('own-errors', '1')

@section('content')
<div class="page-head"><div><h2>My account</h2><p>Update your profile and keep your password secure.</p></div></div>

<div class="grid g2" style="align-items:start">
    <form class="card" method="post" action="{{ route('admin.account.profile') }}">
        @csrf @method('PUT')
        <div class="card-h"><h2>Profile</h2></div>
        <div class="card-b">
            @if (session('success') && ! $errors->hasAny(['current_password', 'password']))@endif
            <div class="field {{ $errors->has('name') ? 'has-error' : '' }}"><label for="name">Full name</label>
                <input class="in" id="name" name="name" value="{{ old('name', $user->name) }}" required>@error('name')<span class="err">{{ $message }}</span>@enderror</div>
            <div class="field {{ $errors->has('email') ? 'has-error' : '' }}"><label for="email">Email (used to sign in)</label>
                <input class="in" id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>@error('email')<span class="err">{{ $message }}</span>@enderror</div>
            <button class="btn" type="submit">Save profile</button>
        </div>
    </form>

    <form class="card" method="post" action="{{ route('admin.account.password') }}" autocomplete="off">
        @csrf @method('PUT')
        <div class="card-h"><h2>Change password</h2><x-icon name="lock" :size="20" /></div>
        <div class="card-b">
            <div class="field {{ $errors->has('current_password') ? 'has-error' : '' }}"><label for="current_password">Current password</label>
                <div class="input-group"><input class="in" id="current_password" type="password" name="current_password" autocomplete="current-password" required><button type="button" class="eye" data-eye aria-label="Show password"><x-icon name="eye" :size="18" /></button></div>
                @error('current_password')<span class="err">{{ $message }}</span>@enderror</div>
            <div class="field {{ $errors->has('password') ? 'has-error' : '' }}"><label for="password">New password <span class="hint">min. 8 characters, letters &amp; numbers</span></label>
                <div class="input-group"><input class="in" id="password" type="password" name="password" autocomplete="new-password" required minlength="8" data-strength><button type="button" class="eye" data-eye aria-label="Show password"><x-icon name="eye" :size="18" /></button></div>
                <div class="meter" style="margin-top:4px"><i id="strengthBar" style="width:0;transition:width .3s"></i></div>
                @error('password')<span class="err">{{ $message }}</span>@enderror</div>
            <div class="field"><label for="password_confirmation">Confirm new password</label>
                <input class="in" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required></div>
            <button class="btn btn--green" type="submit">Update password</button>
        </div>
    </form>
</div>
@endsection
