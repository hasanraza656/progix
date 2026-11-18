@extends('admin.layout')
@section('title', 'Insights')
@section('heading', 'Insights (Blog)')

@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn--green btn--sm"><x-icon name="plus" :size="16" /> New post</a>
@endsection

@section('content')
<div class="page-head"><div><h2>Insights</h2><p>Write, optimise and publish articles for the website blog.</p></div></div>

<div class="card">
    <div class="tabs">
        @foreach (['' => 'All', 'published' => 'Published', 'scheduled' => 'Scheduled', 'draft' => 'Drafts'] as $k => $label)
            <a href="{{ route('admin.posts.index', array_filter(['status' => $k, 'q' => request('q')])) }}" class="{{ (request('status') ?? '') === $k ? 'on' : '' }}">{{ $label }} <small>{{ $counts[$k === '' ? 'all' : $k] }}</small></a>
        @endforeach
    </div>
    <form class="filters" method="get">
        @if (request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
        <input class="in grow" type="search" name="q" value="{{ request('q') }}" placeholder="Search title, category, keyword…" aria-label="Search posts">
        <button class="btn btn--sm" type="submit"><x-icon name="search" :size="16" /> Search</button>
    </form>

    @if ($posts->isEmpty())
        <div class="empty"><x-icon name="file-text" :size="44" /><p>No posts found.</p><a class="btn btn--green" href="{{ route('admin.posts.create') }}">Write your first post</a></div>
    @else
        <table class="tbl">
            <thead><tr><th>Post</th><th>Category</th><th>Status</th><th>Views</th><th>Updated</th><th></th></tr></thead>
            <tbody>
            @foreach ($posts as $p)
                @php $state = $p->status === 'draft' ? 'draft' : ($p->is_live ? 'published' : 'scheduled'); @endphp
                <tr>
                    <td class="main">
                        <div class="cell-flex">
                            <img class="thumb hide-sm" src="{{ $p->cover_url ?: asset('assets/img/brand/og-image.jpg') }}" alt="" loading="lazy">
                            <div style="min-width:0"><a class="t-title" href="{{ route('admin.posts.edit', $p) }}">{{ $p->title }}</a><span class="t-sub">/insights/{{ $p->slug }}</span></div>
                        </div>
                    </td>
                    <td data-label="Category">{{ $p->category ?: '—' }}</td>
                    <td data-label="Status"><span class="badge b-{{ $state }}">{{ ucfirst($state) }}</span></td>
                    <td data-label="Views">{{ number_format($p->views) }}</td>
                    <td data-label="Updated" class="muted nowrap">{{ $p->updated_at->format('M j, Y') }}</td>
                    <td class="acts-cell">
                        <div class="acts">
                            <a class="icon-b" href="{{ route('post', $p->slug) }}" target="_blank" rel="noopener" aria-label="View on site"><x-icon name="eye" :size="18" /></a>
                            <a class="icon-b" href="{{ route('admin.posts.edit', $p) }}" aria-label="Edit"><x-icon name="pencil" :size="18" /></a>
                            <form method="post" action="{{ route('admin.posts.toggle', $p) }}">@csrf @method('PATCH')<button class="icon-b" aria-label="{{ $p->status === 'published' ? 'Unpublish' : 'Publish' }}" title="{{ $p->status === 'published' ? 'Move to drafts' : 'Publish now' }}"><x-icon :name="$p->status === 'published' ? 'download' : 'upload'" :size="18" /></button></form>
                            <form method="post" action="{{ route('admin.posts.destroy', $p) }}" data-confirm="Delete “{{ $p->title }}”? This cannot be undone.">@csrf @method('DELETE')<button class="icon-b icon-b--danger" aria-label="Delete"><x-icon name="trash" :size="18" /></button></form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pager">
            <span class="muted small">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }}</span>
            <div class="acts">
                @if ($posts->previousPageUrl())<a class="btn btn--line btn--sm" href="{{ $posts->previousPageUrl() }}">&larr; Prev</a>@endif
                @if ($posts->nextPageUrl())<a class="btn btn--line btn--sm" href="{{ $posts->nextPageUrl() }}">Next &rarr;</a>@endif
            </div>
        </div>
    @endif
</div>
@endsection
