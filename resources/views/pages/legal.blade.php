@extends('layouts.app')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Legal',
    'title' => $kind === 'privacy' ? 'Privacy <span class="accent">Policy</span>' : 'Terms of <span class="accent">Service</span>',
    'lead' => 'Last updated: '.now()->format('F j, Y').'. Draft text — to be reviewed before launch.',
])

<section class="section pt-0">
    <div class="container">
        <div class="legal article">
            @if ($kind === 'privacy')
                <h2>Information we collect</h2>
                <p>When you use the contact or booking forms on this website, you choose what to share — typically your name, phone number, email and project details. These details are used to open a conversation with you on WhatsApp or email. The website itself does not store them on a server.</p>
                <h2>How we use your information</h2>
                <p>We use the information you provide only to respond to your enquiry, prepare a quote and deliver services you request. We do not sell your personal information.</p>
                <h2>Cookies &amp; analytics</h2>
                <p>This website may use basic analytics to understand how visitors use it. You can disable cookies in your browser at any time.</p>
                <h2>Third-party services</h2>
                <p>Links to WhatsApp, Calendly, social networks and payment providers lead to services governed by their own privacy policies.</p>
                <h2>Contact</h2>
                <p>Questions about privacy? Email <a href="mailto:{{ $site['contact']['email'] }}">{{ $site['contact']['email'] }}</a>.</p>
            @else
                <h2>Services</h2>
                <p>{{ $site['name'] }} provides digital marketing, web development, AI and automation services. The scope, deliverables, timeline and price of each project are set out in a written quotation agreed before work begins.</p>
                <h2>Payments</h2>
                <p>Prices on this website are starting or suggested prices and may vary with project scope. Ad spend, hosting, domains and premium plugins are paid separately unless stated otherwise.</p>
                <h2>Revisions &amp; delivery</h2>
                <p>Each package lists the number of revision rounds included. Additional revisions or scope changes may be quoted separately.</p>
                <h2>Intellectual property</h2>
                <p>On receipt of full payment, ownership of the agreed deliverables transfers to the client. We may showcase completed work in our portfolio unless otherwise agreed.</p>
                <h2>Limitation of liability</h2>
                <p>Marketing results depend on many factors outside our control. We commit to professional, diligent work but cannot guarantee specific outcomes.</p>
                <h2>Contact</h2>
                <p>Questions about these terms? Email <a href="mailto:{{ $site['contact']['email'] }}">{{ $site['contact']['email'] }}</a>.</p>
            @endif
        </div>
    </div>
</section>
@endsection
