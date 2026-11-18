@extends('admin.layout')
@section('title', $lead->name)
@section('heading', 'Lead')

@section('actions')
    <a href="{{ route('admin.leads.index') }}" class="btn btn--line btn--sm"><x-icon name="arrow-left" :size="16" /> <span class="hide-sm">All leads</span></a>
@endsection

@section('content')
<div class="page-head">
    <div>
        <h2>{{ $lead->name }} <span class="badge b-{{ $lead->status }}" style="vertical-align:middle;margin-left:6px">{{ \App\Models\Lead::STATUSES[$lead->status] }}</span></h2>
        <p>Received {{ $lead->created_at->format('M j, Y \a\t g:i A') }} · {{ $lead->created_at->diffForHumans() }}</p>
    </div>
    <div class="acts">
        <a class="btn btn--wa" href="{{ $lead->wa_link }}?text={{ rawurlencode('Hi '.$lead->name.', this is Progix Digital — thanks for reaching out!') }}" target="_blank" rel="noopener"><x-icon name="whatsapp" :size="18" /> WhatsApp</a>
        <a class="btn btn--line" href="tel:{{ preg_replace('/[^\d+]/', '', $lead->phone) }}"><x-icon name="phone" :size="18" /> Call</a>
        @if ($lead->email)<a class="btn btn--line" href="mailto:{{ $lead->email }}"><x-icon name="mail" :size="18" /> Email</a>@endif
    </div>
</div>

<div class="grid split">
    <div class="stack">
        <div class="card">
            <div class="card-h"><h2>Request details</h2></div>
            <div class="card-b">
                <dl class="kv">
                    <div><dt>Name</dt><dd>{{ $lead->name }}</dd></div>
                    <div><dt>Phone</dt><dd><a href="tel:{{ preg_replace('/[^\d+]/', '', $lead->phone) }}">{{ $lead->phone }}</a></dd></div>
                    <div><dt>Email</dt><dd>@if ($lead->email)<a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a>@else — @endif</dd></div>
                    <div><dt>Service</dt><dd>{{ $lead->service ?: 'Not sure yet' }}</dd></div>
                    <div><dt>Package</dt><dd>{{ $lead->package ?: '—' }}</dd></div>
                    <div><dt>Best time</dt><dd>{{ $lead->preferred_time ?: 'Anytime' }}</dd></div>
                    <div><dt>Source page</dt><dd>@if ($lead->source_page)<a href="{{ $lead->source_page }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit($lead->source_page, 50) }}</a>@else — @endif</dd></div>
                    <div><dt>Notification email</dt><dd><span class="{{ $lead->mail_sent ? 'ok-dot' : 'bad-dot' }}"></span>{{ $lead->mail_sent ? 'Sent to team' : 'Not delivered — check System page' }}</dd></div>
                </dl>
                @if ($lead->message)
                    <p class="lbl" style="margin:18px 0 8px">Project details</p>
                    <div class="msg-box">{{ $lead->message }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="stack">
        <form class="card" method="post" action="{{ route('admin.leads.update', $lead) }}">
            @csrf @method('PUT')
            <div class="card-h"><h2>Status & notes</h2></div>
            <div class="card-b">
                <div class="status-pick" style="margin-bottom:18px">
                    @foreach (\App\Models\Lead::STATUSES as $k => $label)
                        <label><input type="radio" name="status" value="{{ $k }}" @checked($lead->status === $k)><span>{{ $label }}</span></label>
                    @endforeach
                </div>
                <div class="field"><label for="notes">Internal notes</label><textarea class="in" id="notes" name="notes" rows="6" placeholder="Call summary, budget, next steps…">{{ old('notes', $lead->notes) }}</textarea></div>
                <button class="btn btn--green btn--block" type="submit">Save changes</button>
            </div>
        </form>
        <form class="card" method="post" action="{{ route('admin.leads.destroy', $lead) }}" data-confirm="Delete this lead permanently?">
            @csrf @method('DELETE')
            <div class="card-b"><button class="btn btn--danger btn--block" type="submit"><x-icon name="trash" :size="16" /> Delete lead</button></div>
        </form>
    </div>
</div>
@endsection
