@extends('admin.layout')
@php $isNew = ! $post->exists; @endphp
@section('title', $isNew ? 'New post' : 'Edit post')
@section('heading', $isNew ? 'New post' : 'Edit post')

@push('head')<link rel="stylesheet" href="{{ asset('assets/admin/vendor/quill.snow.css') }}">@endpush

@section('actions')
    <a href="{{ route('admin.posts.index') }}" class="btn btn--line btn--sm"><x-icon name="arrow-left" :size="16" /> <span class="hide-sm">All posts</span></a>
    @unless ($isNew)<a href="{{ route('post', $post->slug) }}" target="_blank" class="btn btn--line btn--sm"><x-icon name="eye" :size="16" /> <span class="hide-sm">View</span></a>@endunless
@endsection

@section('content')
@php $v = fn ($k, $d = null) => old($k, $post->{$k} ?? $d); @endphp
<form method="post" enctype="multipart/form-data" id="postForm" data-seo
      action="{{ $isNew ? route('admin.posts.store') : route('admin.posts.update', $post) }}"
      data-site="{{ url('/insights') }}">
    @csrf
    @unless ($isNew) @method('PUT') @endunless

    <div class="editor-grid">
        {{-- ============ MAIN COLUMN ============ --}}
        <div class="stack">
            <div class="card"><div class="card-b">
                <div class="field {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="title">Title <span class="counter" data-count-for="title" data-min="30" data-max="70"></span></label>
                    <input class="in title-in" type="text" id="title" name="title" value="{{ $v('title') }}" placeholder="Write a clear, keyword-rich headline" required maxlength="180">
                    @error('title')<span class="err">{{ $message }}</span>@enderror
                </div>
                <div class="field {{ $errors->has('slug') ? 'has-error' : '' }}" style="margin-bottom:0">
                    <label for="slug">URL slug <span class="hint">auto-generated from the title</span></label>
                    <div class="slug-row"><span>/insights/</span><input class="in" type="text" id="slug" name="slug" value="{{ $v('slug') }}" placeholder="my-article-url" maxlength="190"></div>
                    @error('slug')<span class="err">{{ $message }}</span>@enderror
                </div>
            </div></div>

            <div class="card">
                <div class="card-h"><h2>Content</h2><span class="muted small" id="wordCount">0 words</span></div>
                <div class="card-b" style="padding:0">
                    <div id="editor" data-initial>{!! $v('content') !!}</div>
                    <textarea name="content" id="content" hidden>{{ $v('content') }}</textarea>
                </div>
            </div>

            <div class="card"><div class="card-b">
                <div class="field" style="margin-bottom:0">
                    <label for="excerpt">Excerpt <span class="counter" data-count-for="excerpt" data-min="80" data-max="200"></span></label>
                    <textarea class="in" id="excerpt" name="excerpt" rows="3" maxlength="500" placeholder="A short summary shown on blog cards and used as the fallback meta description.">{{ $v('excerpt') }}</textarea>
                    @error('excerpt')<span class="err">{{ $message }}</span>@enderror
                </div>
            </div></div>

            {{-- ============ SEO ============ --}}
            <div class="card" id="seo">
                <div class="card-h"><h2>SEO optimisation</h2><span class="muted small">Search preview &amp; live checklist</span></div>
                <div class="card-b">
                    <div class="field">
                        <label for="focus_keyword">Focus keyword <span class="hint">the phrase you want this post to rank for</span></label>
                        <input class="in" type="text" id="focus_keyword" name="focus_keyword" value="{{ $v('focus_keyword') }}" placeholder="e.g. social media strategy for small business" maxlength="120">
                    </div>

                    <div class="lbl" style="margin-bottom:8px">Google preview
                        <span class="seg" style="padding:3px"><a href="#" class="on" data-serp="desktop">Desktop</a><a href="#" data-serp="mobile">Mobile</a></span>
                    </div>
                    <div class="serp" id="serp"><div class="u" id="serpUrl"></div><div class="t" id="serpTitle"></div><div class="d" id="serpDesc"></div></div>

                    <div class="field" style="margin-top:20px">
                        <label for="meta_title">SEO title <span class="counter" data-count-for="meta_title" data-min="40" data-max="60"></span></label>
                        <input class="in" type="text" id="meta_title" name="meta_title" value="{{ $v('meta_title') }}" maxlength="120" placeholder="Defaults to the post title">
                        @error('meta_title')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label for="meta_description">Meta description <span class="counter" data-count-for="meta_description" data-min="120" data-max="160"></span></label>
                        <textarea class="in" id="meta_description" name="meta_description" rows="3" maxlength="320" placeholder="Compelling summary with the focus keyword and a call to action (120–160 characters).">{{ $v('meta_description') }}</textarea>
                        @error('meta_description')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div class="row2">
                        <div class="field {{ $errors->has('canonical_url') ? 'has-error' : '' }}">
                            <label for="canonical_url">Canonical URL <span class="hint">optional</span></label>
                            <input class="in" type="url" id="canonical_url" name="canonical_url" value="{{ $v('canonical_url') }}" placeholder="https://…">
                            @error('canonical_url')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div class="field"><label>Indexing</label>
                            <label class="check" style="min-height:46px"><input type="checkbox" name="noindex" value="1" @checked($v('noindex'))> Hide from search engines (noindex)</label>
                        </div>
                    </div>

                    <div class="score" style="margin-top:6px">
                        <div class="ring" id="ring"><span id="ringNum">0</span></div>
                        <div><strong style="color:var(--ink);font-size:17px" id="scoreLabel">SEO score</strong><p class="muted small" style="margin:2px 0 0" id="scoreHint">Fill in the fields to see your score.</p></div>
                    </div>
                    <div class="checks" id="checks"></div>
                </div>
            </div>
        </div>

        {{-- ============ SIDEBAR ============ --}}
        <div class="stack sticky">
            <div class="card">
                <div class="card-h"><h2>Publish</h2></div>
                <div class="card-b">
                    <div class="field"><label>Current status</label>
                        @php $st = $post->status === 'draft' || ! $post->exists ? 'draft' : ($post->is_live ? 'published' : 'scheduled'); @endphp
                        <div><span class="badge b-{{ $st }}">{{ ucfirst($st) }}</span> <span class="hint">use the buttons below to change it</span></div></div>
                    <div class="field"><label for="published_at">Publish date <span class="hint">future date = scheduled</span></label>
                        <input class="in" type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
                        @error('published_at')<span class="err">{{ $message }}</span>@enderror</div>
                    <div class="field"><label for="category">Category</label>
                        <input class="in" list="cats" type="text" id="category" name="category" value="{{ $v('category') }}" placeholder="e.g. Social Media" maxlength="80">
                        <datalist id="cats">@foreach ($categories as $c)<option value="{{ $c }}">@endforeach</datalist></div>
                    <div class="field" style="margin-bottom:0"><label for="author_name">Author</label>
                        <input class="in" type="text" id="author_name" name="author_name" value="{{ $v('author_name') }}" maxlength="120"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-h"><h2>Cover image</h2></div>
                <div class="card-b">
                    <label class="cover-box" for="cover">
                        <img id="coverPreview" src="{{ $post->cover_url }}" alt="" @if (! $post->cover_url) hidden @endif>
                        <span id="coverHint" @if ($post->cover_url) hidden @endif><x-icon name="image" :size="32" /><br><strong style="color:var(--ink)">Click to upload</strong><br><span class="small muted">JPG, PNG, WebP · max 5 MB</span></span>
                        <input type="file" id="cover" name="cover" accept="image/jpeg,image/png,image/webp,image/gif">
                    </label>
                    @error('cover')<span class="err">{{ $message }}</span>@enderror
                    @if ($post->cover_image)<label class="check" style="margin-top:10px"><input type="checkbox" name="remove_cover" value="1"> Remove current image</label>@endif
                    <div class="field" style="margin:14px 0 0"><label for="cover_alt">Image alt text <span class="hint">describe the image</span></label>
                        <input class="in" type="text" id="cover_alt" name="cover_alt" value="{{ $v('cover_alt') }}" maxlength="190"></div>
                </div>
            </div>

        </div>
    </div>

    <div class="save-bar">
        <span class="grow hide-sm" id="saveHint">@unless ($isNew)Last saved {{ $post->updated_at->diffForHumans() }}@endunless</span>
        @unless ($isNew)<button type="button" class="btn btn--danger" data-delete-post><x-icon name="trash" :size="16" /> <span class="hide-sm">Delete</span></button>@endunless
        <button type="submit" name="status" value="draft" class="btn btn--line" data-save="draft">Save as draft</button>
        <button type="submit" name="status" value="published" class="btn btn--green" data-save="published">{{ $isNew ? 'Publish' : 'Save & publish' }}</button>
    </div>
</form>

@unless ($isNew)
    <form id="deletePost" method="post" action="{{ route('admin.posts.destroy', $post) }}" data-confirm="Delete “{{ $post->title }}” permanently?" hidden>@csrf @method('DELETE')</form>
@endunless
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/vendor/quill.min.js') }}"></script>
    <script src="{{ asset('assets/admin/post-editor.js') }}?v={{ @filemtime(public_path('assets/admin/post-editor.js')) }}" defer></script>
@endpush
