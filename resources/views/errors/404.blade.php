@php
    $seo = ['title' => 'Page not found', 'description' => 'The page you are looking for could not be found.', 'type' => 'website', 'image' => 'assets/img/brand/og-image.jpg', 'noindex' => true, 'schema' => [], 'crumbs' => []];
@endphp
@extends('layouts.app')

@section('content')
<section class="page-hero not-found">
    <div class="hero-dots" data-dots aria-hidden="true"></div>
    <div class="container text-center">
        <div class="nf-code" data-hero-item>4<span class="mark-o">0</span>4</div>
        <h1 class="h-page" data-hero-item>This page took a <span class="accent">wrong turn</span></h1>
        <p class="lead-text mx-auto" data-hero-item>The page you're looking for doesn't exist or has moved. Let's get you back on track.</p>
        <div class="hero-actions justify-content-center" data-hero-item>
            <a href="{{ route('home') }}" class="btn-p btn-p--ink btn-p--lg">Back to home</a>
            <a href="{{ route('contact') }}" class="btn-p btn-p--line btn-p--lg">Contact us</a>
        </div>
    </div>
</section>
@endsection
