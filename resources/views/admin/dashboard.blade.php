@extends('admin.layout')
@section('title', 'Dashboard')

@php
    $hour = (int) now()->format('G');
    $greet = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
    $d = fn ($v) => $v === null ? ['—', 'flat'] : [($v > 0 ? '▲ ' : ($v < 0 ? '▼ ' : '')).abs($v).'%', $v > 0 ? '' : ($v < 0 ? 'down' : 'flat')];
    $devTotal = max(1, $devices->sum());
@endphp

@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn--green btn--sm"><x-icon name="plus" :size="16" /> <span class="hide-sm">New post</span></a>
@endsection

@section('content')
<div class="page-head">
    <div>
        <h2>{{ $greet }}, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }} 👋</h2>
        <p>Here's how Progix Digital is performing.</p>
    </div>
    <div class="seg" role="tablist" aria-label="Date range">
        @foreach ([7 => '7 days', 14 => '14 days', 30 => '30 days', 90 => '90 days'] as $r => $l)
            <a href="?range={{ $r }}" class="{{ $range === $r ? 'on' : '' }}">{{ $l }}</a>
        @endforeach
    </div>
</div>

<div class="site-state {{ $comingSoon ? 'is-off' : '' }}">
    <span><span class="dot"></span>{{ $comingSoon ? 'Coming soon mode is ON — visitors see the coming soon page.' : 'Your website is LIVE.' }}</span>
    <form method="post" action="{{ route('admin.settings.toggle') }}" data-confirm="{{ $comingSoon ? 'Make the website live for everyone?' : 'Hide the website and show the Coming soon page to all visitors?' }}">@csrf
        <button class="btn btn--sm {{ $comingSoon ? 'btn--green' : 'btn--line' }}" type="submit">{{ $comingSoon ? 'Go live' : 'Switch to Coming soon' }}</button>
    </form>
</div>

<div class="grid g4">
    @foreach ([
        ['users', 'Visitors', number_format($visitors), $visitorsDelta, 'Today: '.number_format($today)],
        ['eye', 'Page views', number_format($views), $viewsDelta, 'Last '.$range.' days'],
        ['inbox', 'New leads', number_format($leadsRange), $leadsDelta, $newLeads.' awaiting reply'],
        ['file-text', 'Published posts', number_format($postsPublished), null, $postsDraft.' drafts'],
    ] as [$ico, $label, $num, $delta, $sub])
        @php [$dt, $dc] = $d($delta); @endphp
        <div class="card kpi">
            <div class="kpi-top"><span class="kpi-ico"><x-icon :name="$ico" :size="20" /></span>@if ($delta !== null || $label !== 'Published posts')<span class="delta {{ $dc }}" title="vs previous {{ $range }} days">{{ $dt }}</span>@endif</div>
            <div class="kpi-num">{{ $num }}</div>
            <div class="kpi-lbl">{{ $label }} <span class="muted" style="font-weight:500">· {{ $sub }}</span></div>
        </div>
    @endforeach
</div>

<div class="grid split" style="margin-top:20px">
    <div class="card">
        <div class="card-h"><h2>Traffic overview</h2><div class="legend"><span>Page views</span><span>Visitors</span></div></div>
        <div class="card-b">
            <div class="chart" role="img" aria-label="Daily visitors and page views">
                @foreach ($series as $row)
                    <div class="bar" tabindex="0">
                        <span class="tip">{{ $row['date']->format('D, M j') }} · {{ $row['visitors'] }} visitors · {{ $row['views'] }} views</span>
                        <i style="height: {{ max(1.5, $row['views'] / $max * 100) }}%"><b style="height: {{ $row['views'] ? min(100, $row['visitors'] / max(1, $row['views']) * 100) : 0 }}%"></b></i>
                    </div>
                @endforeach
            </div>
            <div class="chart-x"><span>{{ $series->first()['date']->format('M j') }}</span><span>{{ $series->last()['date']->format('M j') }}</span></div>
            @if ($views === 0)<p class="muted small" style="margin:14px 0 0">No traffic recorded yet — visits to the public website will appear here automatically.</p>@endif
        </div>
    </div>

    <div class="card">
        <div class="card-h"><h2>Lead pipeline</h2><a class="small" style="font-weight:700;color:var(--green-700)" href="{{ route('admin.leads.index') }}">View all</a></div>
        <div class="card-b">
            @php $tot = max(1, $totalLeads); @endphp
            <div class="meter" aria-hidden="true"><i style="width: {{ ($leadCounts['new'] ?? 0) / $tot * 100 }}%"></i><i style="width: {{ (($leadCounts['contacted'] ?? 0) + ($leadCounts['qualified'] ?? 0)) / $tot * 100 }}%"></i><i style="width: {{ ($leadCounts['won'] ?? 0) / $tot * 100 }}%"></i></div>
            <ul style="margin-top:12px">
                @foreach (\App\Models\Lead::STATUSES as $k => $label)
                    <li class="list-row"><span class="badge b-{{ $k }}">{{ $label }}</span><strong style="color:var(--ink)">{{ $leadCounts[$k] ?? 0 }}</strong></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="grid g3" style="margin-top:20px">
    <div class="card">
        <div class="card-h"><h2>Top pages</h2></div>
        <div class="card-b">
            @forelse ($topPages as $p)
                <div class="list-row"><span class="path" title="{{ $p->path }}">{{ $p->path === '/' ? 'Home' : $p->path }}</span><span class="bar-bg"><i style="width: {{ $p->views / max(1, $topPages->first()->views) * 100 }}%"></i></span><strong style="color:var(--ink)">{{ number_format($p->views) }}</strong></div>
            @empty<p class="muted">No data yet.</p>@endforelse
        </div>
    </div>
    <div class="card">
        <div class="card-h"><h2>Traffic sources</h2></div>
        <div class="card-b">
            @forelse ($sources as $s)
                <div class="list-row"><span class="path">{{ $s->src }}</span><span class="bar-bg"><i style="width: {{ $s->n / max(1, $sources->first()->n) * 100 }}%"></i></span><strong style="color:var(--ink)">{{ number_format($s->n) }}</strong></div>
            @empty<p class="muted">No data yet.</p>@endforelse
        </div>
    </div>
    <div class="card">
        <div class="card-h"><h2>Devices</h2></div>
        <div class="card-b">
            @foreach (['mobile' => 'Mobile', 'desktop' => 'Desktop', 'tablet' => 'Tablet'] as $k => $label)
                @php $n = $devices[$k] ?? 0; @endphp
                <div style="margin-bottom:14px"><div class="list-row" style="border:0;padding:0 0 6px"><span>{{ $label }}</span><strong style="color:var(--ink)">{{ round($n / $devTotal * 100) }}%</strong></div><div class="meter"><i style="width: {{ $n / $devTotal * 100 }}%"></i></div></div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid split" style="margin-top:20px">
    <div class="card">
        <div class="card-h"><h2>Recent leads</h2><a href="{{ route('admin.leads.index') }}" class="btn btn--line btn--sm">All leads</a></div>
        @if ($recentLeads->isEmpty())
            <div class="empty"><x-icon name="inbox" :size="40" /><p>No leads yet. Submissions from the website booking form land here.</p></div>
        @else
            <table class="tbl">
                <thead><tr><th>Lead</th><th>Service</th><th>Status</th><th>Received</th><th></th></tr></thead>
                <tbody>
                @foreach ($recentLeads as $l)
                    <tr>
                        <td class="main"><a class="t-title" href="{{ route('admin.leads.show', $l) }}">{{ $l->name }}</a><span class="t-sub">{{ $l->phone }}</span></td>
                        <td data-label="Service">{{ $l->service ?: '—' }}</td>
                        <td data-label="Status"><span class="badge b-{{ $l->status }}">{{ \App\Models\Lead::STATUSES[$l->status] }}</span></td>
                        <td data-label="Received" class="muted nowrap">{{ $l->created_at->diffForHumans() }}</td>
                        <td class="acts-cell"><div class="acts"><a class="icon-b" href="{{ $l->wa_link }}" target="_blank" aria-label="WhatsApp"><x-icon name="whatsapp" :size="18" /></a><a class="icon-b" href="{{ route('admin.leads.show', $l) }}" aria-label="Open"><x-icon name="eye" :size="18" /></a></div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="card">
        <div class="card-h"><h2>Most read insights</h2></div>
        <div class="card-b">
            @forelse ($topPosts as $p)
                <div class="list-row"><a class="path" style="max-width:75%" href="{{ route('admin.posts.edit', $p) }}">{{ $p->title }}</a><strong style="color:var(--ink)">{{ number_format($p->views) }} <span class="muted small" style="font-weight:500">views</span></strong></div>
            @empty<p class="muted">No posts yet.</p>@endforelse
        </div>
    </div>
</div>
@endsection
