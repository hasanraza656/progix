@extends('emails.layout')

@php
    $first = explode(' ', trim($data['name']))[0];
    $rows = [
        'Service' => $data['service'] ?? 'Not sure yet — we\'ll help you choose',
        'Package' => $data['package'] ?? null,
        'Best time to reach you' => $data['time'] ?? 'Anytime',
        'Phone / WhatsApp' => $data['phone'],
    ];
    $steps = [
        ['1', 'We review your request', 'Our team reads every message personally — usually the same day.'],
        ['2', 'We reach out', 'Expect a WhatsApp message or call at your preferred time.'],
        ['3', 'You get a scope & price', 'A clear proposal within 24 hours. No pressure, no jargon.'],
    ];
@endphp

@section('title', 'We received your request')
@section('badge', 'Request received')
@section('preheader', 'Thanks '.$first.'! We got your request and will be in touch within 24 hours.')

@section('content')
<table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:22px;"><tr>
  <td style="width:56px;height:56px;background:#1ac27e;border-radius:28px;text-align:center;font-family:Arial,Helvetica,sans-serif;font-size:28px;line-height:56px;color:#0e1411;font-weight:bold;">&#10003;</td>
</tr></table>

<h1 class="h1" style="margin:0 0 12px;font-family:Arial,Helvetica,sans-serif;font-size:32px;line-height:38px;letter-spacing:-0.8px;color:#0e1411;">Thanks {{ $first }}, we've got your request!</h1>
<p style="margin:0 0 30px;font-size:16px;line-height:26px;color:#44504a;">
  Your free consultation request is in safe hands. One of our team will contact you
  <strong style="color:#0e1411;">within 24 hours</strong> with a clear scope and price for your project.
</p>

{{-- Next steps --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f9f6;border:1px solid #e4e9e4;border-radius:18px;margin-bottom:26px;">
  <tr><td style="padding:22px 26px 6px;font-family:Arial,Helvetica,sans-serif;font-size:11px;letter-spacing:1.4px;text-transform:uppercase;font-weight:bold;color:#6c7871;">What happens next</td></tr>
  @foreach ($steps as [$n, $title, $text])
  <tr><td style="padding:12px 26px {{ $loop->last ? '24px' : '4px' }};">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>
      <td width="44" valign="top"><div style="width:32px;height:32px;border-radius:16px;background:#0e1411;color:#1ac27e;text-align:center;font-family:Arial,Helvetica,sans-serif;font-weight:bold;font-size:14px;line-height:32px;">{{ $n }}</div></td>
      <td valign="top" style="font-family:Arial,Helvetica,sans-serif;">
        <div style="font-size:16px;font-weight:bold;color:#0e1411;margin-bottom:2px;">{{ $title }}</div>
        <div style="font-size:14px;line-height:21px;color:#6c7871;">{{ $text }}</div>
      </td>
    </tr></table>
  </td></tr>
  @endforeach
</table>

{{-- Summary --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e4e9e4;border-radius:18px;">
  <tr><td style="padding:20px 26px 6px;font-family:Arial,Helvetica,sans-serif;font-size:11px;letter-spacing:1.4px;text-transform:uppercase;font-weight:bold;color:#6c7871;">Your request summary</td></tr>
  <tr><td style="padding:0 26px 16px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
      @foreach ($rows as $label => $value)
        @if (! empty($value))
        <tr>
          <td style="padding:10px 0;border-top:1px solid #eef2ee;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#6c7871;width:160px;vertical-align:top;">{{ $label }}</td>
          <td style="padding:10px 0;border-top:1px solid #eef2ee;font-family:Arial,Helvetica,sans-serif;font-size:15px;color:#0e1411;font-weight:bold;vertical-align:top;">{{ $value }}</td>
        </tr>
        @endif
      @endforeach
      @if (! empty($data['message']))
        <tr>
          <td colspan="2" style="padding:12px 0 4px;border-top:1px solid #eef2ee;font-family:Arial,Helvetica,sans-serif;">
            <div style="font-size:13px;color:#6c7871;margin-bottom:6px;">Your message</div>
            <div style="font-size:15px;line-height:23px;color:#0e1411;white-space:pre-line;">{{ $data['message'] }}</div>
          </td>
        </tr>
      @endif
    </table>
  </td></tr>
</table>

{{-- CTA --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:30px;background:#0e1411;border-radius:18px;">
  <tr><td style="padding:26px 28px;" align="left">
    <div style="font-family:Arial,Helvetica,sans-serif;font-size:19px;font-weight:bold;color:#ffffff;margin-bottom:6px;">Want a faster reply?</div>
    <div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;color:#aab6af;margin-bottom:18px;">Message us on WhatsApp and we'll pick it up right away.</div>
    <a class="btn-full" href="https://wa.me/{{ $site['contact']['whatsapp'] }}?text={{ rawurlencode('Hi Progix Digital, I just sent a consultation request.') }}" style="display:inline-block;background:#25d366;color:#062b14;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;text-decoration:none;padding:14px 26px;border-radius:999px;text-align:center;">Chat on WhatsApp</a>
  </td></tr>
</table>

<div style="height:28px;line-height:28px;font-size:0;">&nbsp;</div>
@endsection

@section('footer')
<span style="display:block;margin-bottom:10px;">You're receiving this because you requested a consultation on our website. Didn't send it? Just ignore this email.</span>
@endsection
