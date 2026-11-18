@extends('emails.layout')

@php
    $digits = preg_replace('/\D/', '', $data['phone']);
    $waMsg = rawurlencode('Hi '.$data['name'].', this is Progix Digital — thanks for reaching out! ');
    $rows = [
        'Name' => $data['name'],
        'Phone / WhatsApp' => $data['phone'],
        'Email' => $data['email'] ?? null,
        'Service' => $data['service'] ?? 'Not sure yet',
        'Package' => $data['package'] ?? null,
        'Best time to reach' => $data['time'] ?? 'Anytime',
    ];
@endphp

@section('title', 'New consultation request')
@section('badge', 'New lead')
@section('preheader', $data['name'].' wants a free consultation'.(! empty($data['service']) ? ' · '.$data['service'] : ''))

@section('content')
<table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:18px;"><tr>
  <td style="background:#dff5ea;border-radius:999px;padding:6px 14px;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#0c7f50;">&#9679;&nbsp; New request &middot; {{ $submittedAt }}</td>
</tr></table>

<h1 class="h1" style="margin:0 0 10px;font-family:Arial,Helvetica,sans-serif;font-size:32px;line-height:38px;letter-spacing:-0.8px;color:#0e1411;">{{ $data['name'] }} wants a free consultation</h1>
<p style="margin:0 0 28px;font-size:16px;line-height:25px;color:#44504a;">
  A new request just came in from the website. Reply within 24 hours — it's the promise on the site.
</p>

{{-- Quick actions --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:30px;"><tr>
  <td class="stack" style="padding:0 6px 8px 0;">
    <a class="btn-full" href="https://wa.me/{{ $digits }}?text={{ $waMsg }}" style="display:inline-block;background:#25d366;color:#062b14;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;text-decoration:none;padding:15px 24px;border-radius:999px;text-align:center;">Reply on WhatsApp</a>
  </td>
  <td class="stack" style="padding:0 6px 8px 0;">
    <a class="btn-full" href="tel:+{{ $digits }}" style="display:inline-block;background:#0e1411;color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;text-decoration:none;padding:15px 24px;border-radius:999px;text-align:center;">Call now</a>
  </td>
  @if (! empty($data['email']))
  <td class="stack" style="padding:0 0 8px 0;">
    <a class="btn-full" href="mailto:{{ $data['email'] }}?subject={{ rawurlencode('Your Progix Digital consultation') }}" style="display:inline-block;border:1.5px solid #d6ddd7;color:#0e1411;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;text-decoration:none;padding:13px 22px;border-radius:999px;text-align:center;">Email</a>
  </td>
  @endif
</tr></table>

{{-- Details card --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f9f6;border:1px solid #e4e9e4;border-radius:18px;">
  <tr><td style="padding:22px 26px 8px;font-family:Arial,Helvetica,sans-serif;font-size:11px;letter-spacing:1.4px;text-transform:uppercase;font-weight:bold;color:#6c7871;">Request details</td></tr>
  <tr><td style="padding:0 26px 18px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
      @foreach ($rows as $label => $value)
        @if (! empty($value))
          <tr>
            <td style="padding:11px 0;border-top:1px solid #e4e9e4;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#6c7871;width:150px;vertical-align:top;">{{ $label }}</td>
            <td style="padding:11px 0;border-top:1px solid #e4e9e4;font-family:Arial,Helvetica,sans-serif;font-size:15px;color:#0e1411;font-weight:bold;vertical-align:top;">{{ $value }}</td>
          </tr>
        @endif
      @endforeach
    </table>
  </td></tr>
</table>

@if (! empty($data['message']))
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:18px;border-left:4px solid #1ac27e;background:#ffffff;">
    <tr><td style="padding:6px 0 6px 20px;">
      <div style="font-family:Arial,Helvetica,sans-serif;font-size:11px;letter-spacing:1.4px;text-transform:uppercase;font-weight:bold;color:#6c7871;margin-bottom:8px;">Project details</div>
      <div style="font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;color:#0e1411;white-space:pre-line;">{{ $data['message'] }}</div>
    </td></tr>
  </table>
@endif

<div style="height:28px;line-height:28px;font-size:0;">&nbsp;</div>
@endsection

@section('footer')
<span style="display:block;margin-bottom:10px;">Sent automatically from {{ $page ?: 'the Progix Digital website' }}. A confirmation email was {{ ! empty($data['email']) ? 'sent to '.$data['email'] : 'not sent (no email provided)' }}.</span>
@endsection
