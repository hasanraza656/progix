@extends('admin.layout')
@section('title', 'Leads')

@section('actions')
    <a href="{{ route('admin.leads.export', request()->query()) }}" class="btn btn--line btn--sm"><x-icon name="download" :size="16" /> <span class="hide-sm">Export CSV</span></a>
@endsection

@section('content')
<div class="page-head">
    <div><h2>Leads</h2><p>Consultation requests from the website booking forms.</p></div>
</div>

<div class="card">
    <div class="tabs" aria-label="Filter by status">
        <a href="{{ route('admin.leads.index', array_filter(['q' => request('q')])) }}" class="{{ ! request('status') ? 'on' : '' }}">All <small>{{ $counts->sum() }}</small></a>
        @foreach (\App\Models\Lead::STATUSES as $k => $label)
            <a href="{{ route('admin.leads.index', array_filter(['status' => $k, 'q' => request('q')])) }}" class="{{ request('status') === $k ? 'on' : '' }}">{{ $label }} <small>{{ $counts[$k] ?? 0 }}</small></a>
        @endforeach
    </div>
    <form class="filters" method="get">
        @if (request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
        <input class="in grow" type="search" name="q" value="{{ request('q') }}" placeholder="Search name, phone, email, service…" aria-label="Search leads">
        <button class="btn btn--sm" type="submit"><x-icon name="search" :size="16" /> Search</button>
        @if (request('q'))<a class="btn btn--line btn--sm" href="{{ route('admin.leads.index', array_filter(['status' => request('status')])) }}">Clear</a>@endif
    </form>

    @if ($leads->isEmpty())
        <div class="empty"><x-icon name="inbox" :size="44" /><p>No leads found.</p></div>
    @else
        <table class="tbl">
            <thead><tr><th>Lead</th><th>Interested in</th><th>Status</th><th>Received</th><th></th></tr></thead>
            <tbody>
            @foreach ($leads as $l)
                <tr>
                    <td class="main">
                        <a class="t-title" href="{{ route('admin.leads.show', $l) }}">{{ $l->name }} @if ($l->status === 'new')<span class="badge b-new" style="margin-left:6px">New</span>@endif</a>
                        <span class="t-sub">{{ $l->phone }}@if ($l->email) · {{ $l->email }}@endif</span>
                    </td>
                    <td data-label="Interested in">{{ $l->service ?: '—' }}@if ($l->package)<span class="t-sub" style="display:block">{{ \Illuminate\Support\Str::limit($l->package, 38) }}</span>@endif</td>
                    <td data-label="Status"><span class="badge b-{{ $l->status }}">{{ \App\Models\Lead::STATUSES[$l->status] }}</span></td>
                    <td data-label="Received" class="muted nowrap" title="{{ $l->created_at }}">{{ $l->created_at->format('M j, g:i A') }}</td>
                    <td class="acts-cell">
                        <div class="acts">
                            <a class="icon-b" href="{{ $l->wa_link }}" target="_blank" rel="noopener" aria-label="WhatsApp {{ $l->name }}"><x-icon name="whatsapp" :size="18" /></a>
                            <a class="icon-b" href="tel:{{ preg_replace('/[^\d+]/', '', $l->phone) }}" aria-label="Call"><x-icon name="phone" :size="18" /></a>
                            <a class="icon-b" href="{{ route('admin.leads.show', $l) }}" aria-label="Open lead"><x-icon name="eye" :size="18" /></a>
                            <form method="post" action="{{ route('admin.leads.destroy', $l) }}" data-confirm="Delete the lead from {{ $l->name }}? This cannot be undone.">@csrf @method('DELETE')<button class="icon-b icon-b--danger" aria-label="Delete"><x-icon name="trash" :size="18" /></button></form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pager">
            <span class="muted small">Showing {{ $leads->firstItem() }}–{{ $leads->lastItem() }} of {{ $leads->total() }}</span>
            <div class="acts">
                @if ($leads->previousPageUrl())<a class="btn btn--line btn--sm" href="{{ $leads->previousPageUrl() }}">&larr; Prev</a>@endif
                @if ($leads->nextPageUrl())<a class="btn btn--line btn--sm" href="{{ $leads->nextPageUrl() }}">Next &rarr;</a>@endif
            </div>
        </div>
    @endif
</div>
@endsection
