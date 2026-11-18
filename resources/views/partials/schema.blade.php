@php
    $c = $site['contact'];
    $graph = [];

    $graph[] = [
        '@type' => ['Organization', 'ProfessionalService'],
        '@id' => url('/').'#organization',
        'name' => $site['name'],
        'url' => url('/'),
        'logo' => asset('assets/img/brand/logo.png'),
        'image' => asset('assets/img/brand/og-image.jpg'),
        'slogan' => $site['tagline'],
        'description' => 'Digital agency offering social media marketing, paid advertising, SEO content, web development and AI automation.',
        'founder' => ['@type' => 'Person', 'name' => $site['founder']['name']],
        'email' => $c['email'],
        'telephone' => $c['phone_pk'],
        'areaServed' => 'Worldwide',
        'priceRange' => '$$',
        'sameAs' => collect($site['social'])->pluck('url')->filter(fn ($u) => $u && $u !== '#')->values()->all(),
    ];

    $graph[] = [
        '@type' => 'WebSite',
        '@id' => url('/').'#website',
        'url' => url('/'),
        'name' => $site['name'],
        'publisher' => ['@id' => url('/').'#organization'],
        'inLanguage' => 'en',
    ];

    if (! empty($seo['crumbs'])) {
        $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')]];
        foreach ($seo['crumbs'] as $i => [$label, $href]) {
            $items[] = ['@type' => 'ListItem', 'position' => $i + 2, 'name' => $label, 'item' => $href ?: url()->current()];
        }
        $graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }

    $s = $seo['schema'] ?? [];

    if (! empty($s['faq'])) {
        $graph[] = [
            '@type' => 'FAQPage',
            'mainEntity' => collect($s['faq'])->map(fn ($f) => [
                '@type' => 'Question', 'name' => $f[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
            ])->all(),
        ];
    }

    if (! empty($s['service'])) {
        $sv = $s['service'];
        $graph[] = [
            '@type' => 'Service', 'name' => $sv['title'], 'description' => $sv['meta_desc'],
            'provider' => ['@id' => url('/').'#organization'], 'areaServed' => 'Worldwide',
            'url' => url()->current(),
            'offers' => ['@type' => 'Offer', 'priceCurrency' => 'USD', 'price' => (string) $sv['from'], 'description' => 'Starting price'],
        ];
    }

    if (! empty($s['reviews'])) {
        $graph[] = [
            '@type' => 'Organization', '@id' => url('/').'#organization',
            'aggregateRating' => ['@type' => 'AggregateRating', 'ratingValue' => '5.0', 'bestRating' => '5', 'reviewCount' => (string) count($site['testimonials'])],
            'review' => collect($site['testimonials'])->take(4)->map(fn ($t) => [
                '@type' => 'Review', 'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                'author' => ['@type' => 'Organization', 'name' => 'Verified Upwork client'],
                'reviewBody' => $t['quote'],
            ])->all(),
        ];
    }

    if (! empty($s['article'])) {
        $p = $s['article'];
        $graph[] = [
            '@type' => 'Article', 'headline' => $p->seo_title, 'description' => $p->seo_description,
            'image' => \App\Models\Post::img($p->og_image ?: $p->cover_image),
            'datePublished' => optional($p->published_at ?? $p->created_at)->toIso8601String(), 'dateModified' => $p->updated_at->toIso8601String(),
            'author' => ['@type' => 'Person', 'name' => $p->author_name ?: $site['founder']['name']],
            'publisher' => ['@id' => url('/').'#organization'],
            'mainEntityOfPage' => url()->current(),
            'articleSection' => $p->category, 'keywords' => $p->focus_keyword,
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
