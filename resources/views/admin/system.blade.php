@extends('admin.layout')
@section('title', 'System updates')

@section('content')
<div class="page-head"><div><h2>System &amp; updates</h2><p>Run new migrations and clear caches with one click — no terminal needed.</p></div></div>

<div class="grid split" style="align-items:start">
    <div class="stack">
        <div class="card">
            <div class="card-h">
                <h2>One-click update</h2>
                @if (count($pending))<span class="badge b-qualified">{{ count($pending) }} pending migration{{ count($pending) > 1 ? 's' : '' }}</span>@else<span class="badge b-published">Database up to date</span>@endif
            </div>
            <div class="card-b">
                <p>After uploading new code to the server, press the button. It will:</p>
                <ol style="padding-left:20px;list-style:decimal;margin:0 0 16px;color:var(--ink-2)">
                    <li>run any <strong>new database migrations</strong> (<code>php artisan migrate --force</code>)</li>
                    <li><strong>clear</strong> the config, route, view and application caches</li>
                    <li>optionally <strong>rebuild</strong> the caches for maximum speed</li>
                </ol>
                @if (count($pending))
                    <div class="flash" style="background:var(--amber-100);color:var(--amber);border-color:#f3dca5"><x-icon name="alert" :size="20" /><span>Pending: {{ implode(', ', array_map(fn ($m) => preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/', '', $m), $pending)) }}</span></div>
                @endif
                <form method="post" action="{{ route('admin.system.update') }}" data-busy="Updating…">
                    @csrf
                    <label class="check" style="margin-bottom:16px"><input type="checkbox" name="rebuild" value="1" checked> Rebuild caches afterwards (recommended on live server)</label>
                    <div class="acts" style="justify-content:flex-start">
                        <button class="btn btn--green" type="submit"><x-icon name="refresh" :size="18" /> Run update now</button>
                    </div>
                </form>
                @if ($lastRun)<p class="muted small" style="margin:14px 0 0">Last run: {{ $lastRun['at'] }} by {{ $lastRun['by'] }} — {{ $lastRun['ok'] ? 'successful' : 'failed' }}.</p>@endif
            </div>
        </div>

        @if (session('log'))
            <div class="card">
                <div class="card-h"><h2>Update log</h2></div>
                <div class="card-b"><div class="log">@foreach (session('log') as $step)<span class="{{ $step['ok'] ? 'step' : 'fail' }}">{{ $step['ok'] ? '✔' : '✖' }} {{ $step['label'] }}</span>
{{ $step['output'] ?: '(done)' }}

@endforeach</div></div>
            </div>
        @endif

        <div class="card">
            <div class="card-h"><h2>Maintenance tools</h2></div>
            <div class="card-b">
                <div class="acts" style="justify-content:flex-start;flex-wrap:wrap">
                    <form method="post" action="{{ route('admin.system.cache') }}" data-busy="Clearing…">@csrf<button class="btn btn--line" type="submit"><x-icon name="trash" :size="16" /> Clear all caches</button></form>
                    <form method="post" action="{{ route('admin.system.mail') }}" data-busy="Sending…">@csrf<button class="btn btn--line" type="submit"><x-icon name="mail" :size="16" /> Send test email to me</button></form>
                </div>
                <p class="muted small" style="margin:14px 0 0">Use “Clear all caches” after editing <code>.env</code> or config files on the server.</p>
            </div>
        </div>
    </div>

    <div class="stack">
        <div class="card">
            <div class="card-h"><h2>Health check</h2></div>
            <div class="card-b"><ul class="pill-list">
                @foreach ($checks as $label => $ok)
                    <li><span>{{ $label }}</span><strong><span class="{{ $ok ? 'ok-dot' : 'bad-dot' }}" style="margin:0"></span></strong></li>
                @endforeach
            </ul></div>
        </div>
        <div class="card">
            <div class="card-h"><h2>Server info</h2></div>
            <div class="card-b"><ul class="pill-list">
                @foreach ($info as $label => $value)<li><span class="muted">{{ $label }}</span><strong>{{ $value }}</strong></li>@endforeach
                <li><span class="muted">Migrations run</span><strong>{{ $ranCount }}</strong></li>
            </ul></div>
        </div>
    </div>
</div>
@endsection
