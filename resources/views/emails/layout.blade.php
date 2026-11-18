<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light">
<title>@yield('title')</title>
<style>
  @media only screen and (max-width: 620px) {
    .container { width: 100% !important; }
    .px { padding-left: 22px !important; padding-right: 22px !important; }
    .stack { display: block !important; width: 100% !important; }
    .btn-full { display: block !important; width: 100% !important; box-sizing: border-box; }
    .h1 { font-size: 26px !important; line-height: 32px !important; }
  }
</style>
</head>
<body style="margin:0;padding:0;background:#eef3ee;-webkit-text-size-adjust:100%;">
{{-- hidden preheader --}}
<div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">@yield('preheader')&#8199;&#847;&#8199;&#847;&#8199;&#847;&#8199;&#847;&#8199;&#847;</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef3ee;">
<tr><td align="center" style="padding:32px 14px;">

  <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" style="width:600px;max-width:600px;">

    {{-- Header --}}
    <tr><td style="background:#0e1411;border-radius:24px 24px 0 0;padding:30px 40px 26px;" class="px">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>
        <td align="left"><img src="{{ $message->embed(public_path('assets/img/brand/logo-light.png')) }}" alt="Progix Digital" width="150" style="display:block;border:0;height:auto;"></td>
        <td align="right" style="font-family:Arial,Helvetica,sans-serif;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:#1ac27e;font-weight:bold;">@yield('badge')</td>
      </tr></table>
    </td></tr>
    <tr><td style="background-color:#1ac27e;height:4px;line-height:4px;font-size:0;">&nbsp;</td></tr>

    {{-- Body --}}
    <tr><td style="background:#ffffff;padding:40px 40px 12px;font-family:Arial,Helvetica,sans-serif;color:#44504a;" class="px">
      @yield('content')
    </td></tr>

    {{-- Footer --}}
    <tr><td style="background:#ffffff;padding:8px 40px 36px;border-radius:0 0 24px 24px;" class="px">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #e4e9e4;"><tr>
        <td style="padding-top:22px;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:19px;color:#6c7871;">
          @yield('footer')
          <strong style="color:#0e1411;">Progix Digital</strong> &middot; We Build. We Grow. We Automate.<br>
          <a href="mailto:{{ $site['contact']['email'] }}" style="color:#0c7f50;text-decoration:none;">{{ $site['contact']['email'] }}</a> @if ($site['contact']['address'])&nbsp;&middot;&nbsp; {{ $site['contact']['address'] }}@endif
        </td>
      </tr></table>
    </td></tr>

  </table>

  <p style="margin:18px 0 0;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#8d9a92;">&copy; {{ date('Y') }} Progix Digital. All rights reserved.</p>
</td></tr>
</table>
</body>
</html>
