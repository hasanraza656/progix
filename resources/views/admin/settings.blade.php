@extends('admin.layout')
@section('title', 'Site settings')
@section('own-errors', '1')

@section('actions')
    <a href="{{ route('admin.settings.preview') }}" target="_blank" class="btn btn--line btn--sm"><x-icon name="eye" :size="16" /> <span class="hide-sm">Preview page</span></a>
@endsection

@section('content')
<div class="page-head"><div><h2>Site settings</h2><p>Control whether the public website is live or showing a “Coming soon” page.</p></div></div>

<form method="post" action="{{ route('admin.settings.update') }}" class="grid split" style="align-items:start">
    @csrf @method('PUT')

    <div class="stack">
        <div class="card">
            <div class="card-h"><h2>Coming soon mode</h2>
                <span class="badge {{ $enabled ? 'b-qualified' : 'b-published' }}" id="modeBadge">{{ $enabled ? 'ON — site hidden' : 'OFF — site is live' }}</span>
            </div>
            <div class="card-b">
                <label class="switch-row" for="coming_soon">
                    <span class="switch"><input type="checkbox" id="coming_soon" name="coming_soon" value="1" @checked(old('coming_soon', $enabled)) role="switch"><i></i></span>
                    <span><strong>Show the “Coming soon” page to visitors</strong><small>While this is on, the public website is hidden (search engines are told to come back later). You stay able to see the full site while signed in to the admin.</small></span>
                </label>

                <div class="field" style="margin-top:22px">
                    <label for="cs_title">Headline <span class="counter" data-count-for="cs_title" data-min="10" data-max="60"></span></label>
                    <input class="in" id="cs_title" name="cs_title" maxlength="120" value="{{ old('cs_title', $title) }}" placeholder="Something great is on its way">
                    @error('cs_title')<span class="err">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label for="cs_message">Message</label>
                    <textarea class="in" id="cs_message" name="cs_message" rows="4" maxlength="500" placeholder="We’re putting the finishing touches on our new website…">{{ old('cs_message', $message) }}</textarea>
                    @error('cs_message')<span class="err">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label for="cs_launch">Launch date &amp; time <span class="hint">optional — shows a live countdown</span></label>
                    <input class="in" type="datetime-local" id="cs_launch" name="cs_launch" value="{{ old('cs_launch', $launch ? \Illuminate\Support\Carbon::parse($launch)->format('Y-m-d\TH:i') : '') }}">
                    @error('cs_launch')<span class="err">{{ $message }}</span>@enderror
                </div>
                <div class="acts" style="justify-content:flex-start">
                    <button class="btn btn--green" type="submit">Save settings</button>
                    <a class="btn btn--line" href="{{ route('admin.settings.preview') }}" target="_blank">Preview</a>
                </div>
            </div>
        </div>
    </div>

    <div class="stack">
        <div class="card">
            <div class="card-h"><h2>How it works</h2></div>
            <div class="card-b">
                <ul class="pill-list" style="display:grid;gap:0">
                    <li><span>Visitors</span><strong>See the coming soon page</strong></li>
                    <li><span>You (signed in)</span><strong>See the full website + a banner</strong></li>
                    <li><span>Search engines</span><strong>Told to retry later (503)</strong></li>
                    <li><span>“Notify me” form</span><strong>Saved in Leads + emailed</strong></li>
                    <li><span>Admin &amp; /system pages</span><strong>Always available</strong></li>
                </ul>
            </div>
        </div>
    </div>
</form>
@endsection
