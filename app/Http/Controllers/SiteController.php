<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Mail\BookingRequest;
use App\Models\Lead;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    /** Build the SEO payload consumed by layouts/app.blade.php */
    private function page(string $view, array $seo, array $data = [])
    {
        $seo += ['type' => 'website', 'image' => 'assets/img/brand/og-image.jpg', 'noindex' => false, 'schema' => [], 'crumbs' => []];

        return view($view, $data + ['seo' => $seo]);
    }

    private function findService(string $slug): array
    {
        $service = collect(config('progix.services'))->firstWhere('slug', $slug);
        abort_if(! $service, 404);

        return $service;
    }

    public function home()
    {
        return $this->page('pages.home', [
            'title' => 'Progix Digital | Social Media, Web & AI Automation Agency',
            'raw_title' => true,
            'description' => 'Progix Digital offers social media management, paid ads, SEO content, web development and AI automation. 1,200+ projects. Get a free quote in 24 hours.',
            'schema' => ['faq' => config('progix.faqs'), 'reviews' => true],
        ], ['posts' => $this->latestPosts(3)]);
    }

    private function latestPosts(int $n)
    {
        try {
            return Post::published()->latest('published_at')->take($n)->get();
        } catch (\Throwable $e) {
            return collect(); // database not migrated yet
        }
    }

    /** Alternative homepage design (option 2) — kept out of search results. */
    public function home2()
    {
        return $this->page('pages.home2', [
            'title' => 'Progix Digital | Social Media, Web & AI Automation Agency',
            'raw_title' => true,
            'description' => 'Progix Digital offers social media management, paid ads, SEO content, web development and AI automation. 1,200+ projects. Get a free quote in 24 hours.',
            'canonical' => url('/'),
            'noindex' => true,
        ], ['posts' => $this->latestPosts(3)]);
    }

    /** Alternative homepage design (option 3) — kept out of search results. */
    public function home3()
    {
        return $this->page('pages.home3', [
            'title' => 'Progix Digital | Social Media, Web & AI Automation Agency',
            'raw_title' => true,
            'description' => 'Progix Digital offers social media management, paid ads, SEO content, web development and AI automation. 1,200+ projects. Get a free quote in 24 hours.',
            'canonical' => url('/'),
            'noindex' => true,
        ], ['posts' => $this->latestPosts(3)]);
    }

    public function about()
    {
        return $this->page('pages.about', [
            'title' => 'About Us — Our Story, Mission & Team',
            'description' => 'Meet Progix Digital: a digital solutions company combining creativity, technology and strategy. Led by founder Samin Sajid with 10+ years of experience and 1,200+ projects.',
            'crumbs' => [['About', null]],
        ]);
    }

    public function services()
    {
        return $this->page('pages.services', [
            'title' => 'Digital Marketing, Web Development & AI Services',
            'description' => 'Explore every Progix Digital service: social media marketing, paid ads, SEO content, web development, AI chatbots, automation and branding — all under one roof.',
            'crumbs' => [['Services', null]],
        ]);
    }

    public function service(string $slug)
    {
        $service = $this->findService($slug);

        return $this->page('pages.service', [
            'title' => $service['meta_title'],
            'description' => $service['meta_desc'],
            'crumbs' => [['Services', route('services')], [$service['title'], null]],
            'schema' => ['service' => $service, 'faq' => $service['faqs']],
        ], ['service' => $service]);
    }

    public function pricing()
    {
        return $this->page('pages.pricing', [
            'title' => 'Pricing — Transparent Packages for Every Stage',
            'description' => 'Clear, affordable pricing: social media from $199/mo, ads management from $199/mo, websites from $129, AI agents from $99. No hidden fees. Book a free consultation.',
            'crumbs' => [['Pricing', null]],
            'schema' => ['faq' => array_slice(config('progix.faqs'), 1, 5)],
        ]);
    }

    public function clients()
    {
        return $this->page('pages.clients', [
            'title' => 'Our Clients — Brands That Trust Progix Digital',
            'description' => 'From global names like DHL and PepsiCo to fast-growing startups: see the brands Progix Digital has helped grow across 37+ industries.',
            'crumbs' => [['Clients', null]],
        ]);
    }

    public function testimonials()
    {
        return $this->page('pages.testimonials', [
            'title' => 'Client Reviews & Case Studies',
            'description' => 'Read verified 5-star client reviews and real case studies. Top Rated Plus on Upwork with 100% job success and 14,500+ hours worked.',
            'crumbs' => [['Reviews & Case Studies', null]],
            'schema' => ['reviews' => true],
        ]);
    }

    public function blog()
    {
        return $this->page('pages.blog', [
            'title' => 'Insights — Marketing, Web & AI Guides',
            'description' => 'Practical guides on social media, paid ads, SEO content, web development and AI automation from the Progix Digital team.',
            'crumbs' => [['Insights', null]],
        ], ['posts' => Post::published()->latest('published_at')->paginate(9)]);
    }

    public function post(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $isAdmin = (bool) auth()->user();
        abort_if(! $post->is_live && ! $isAdmin, 404);

        if (! $isAdmin && $post->is_live) {
            Post::whereKey($post->id)->toBase()->increment('views'); // no updated_at bump: keeps "last updated" honest
        }

        $related = Post::published()->where('id', '!=', $post->id)
            ->orderByRaw('category = ? desc', [$post->category])->latest('published_at')->take(3)->get();

        return $this->page('pages.post', [
            'title' => $post->seo_title,
            'description' => $post->seo_description,
            'type' => 'article',
            'image' => $post->og_image ?: ($post->cover_image ?: 'assets/img/brand/og-image.jpg'),
            'canonical' => $post->canonical_url ?: null,
            'noindex' => $post->noindex || ! $post->is_live,
            'crumbs' => [['Insights', route('blog')], [$post->title, null]],
            'schema' => ['article' => $post],
        ], ['post' => $post, 'related' => $related]);
    }
    public function contact()
    {
        return $this->page('pages.contact', [
            'title' => 'Contact Us — Book a Free Consultation',
            'description' => 'Talk to Progix Digital. Book a free consultation, message us on WhatsApp or send your project and get a scope and price within 24 hours.',
            'crumbs' => [['Contact', null]],
            'schema' => ['contact' => true, 'faq' => array_slice(config('progix.faqs'), 0, 5)],
        ]);
    }

    public function privacy()
    {
        return $this->page('pages.legal', [
            'title' => 'Privacy Policy',
            'description' => 'How Progix Digital collects, uses and protects your information.',
            'crumbs' => [['Privacy Policy', null]],
        ], ['kind' => 'privacy']);
    }

    public function terms()
    {
        return $this->page('pages.legal', [
            'title' => 'Terms of Service',
            'description' => 'The terms that apply when you use the Progix Digital website and services.',
            'crumbs' => [['Terms of Service', null]],
        ], ['kind' => 'terms']);
    }

    public function sitemap(): Response
    {
        $urls = collect(['home', 'about', 'services', 'pricing', 'clients', 'testimonials', 'blog', 'contact', 'privacy', 'terms'])
            ->map(fn ($r) => route($r))
            ->merge(collect(config('progix.services'))->map(fn ($s) => route('service', $s['slug'])))
            ->merge(Post::published()->pluck('slug')->map(fn ($s) => route('post', $s)));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $u) {
            $prio = $u === route('home') ? '1.0' : ((str_contains($u, '/services') || str_contains($u, 'pricing')) ? '0.9' : '0.7');
            $xml .= '  <url><loc>'.$u.'</loc><lastmod>'.now()->toDateString().'</lastmod><priority>'.$prio."</priority></url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    /** Emails the consultation request to the team (the page also opens WhatsApp). */
    public function booking(Request $request)
    {
        if ($request->filled('website')) { // honeypot
            return response()->json(['ok' => true]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:160'],
            'service' => ['nullable', 'string', 'max:160'],
            'package' => ['nullable', 'string', 'max:200'],
            'time' => ['nullable', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        $lead = Lead::create([
            'name' => $data['name'], 'phone' => $data['phone'], 'email' => $data['email'] ?? null,
            'service' => $data['service'] ?? null, 'package' => $data['package'] ?? null,
            'preferred_time' => $data['time'] ?? null, 'message' => $data['message'] ?? null,
            'source_page' => substr((string) $request->headers->get('referer'), 0, 250),
            'ip' => $request->ip(), 'user_agent' => substr((string) $request->userAgent(), 0, 250),
        ]);

        $notify = config('mail.notify') ?: [config('mail.from.address')];
        $page = $request->headers->get('referer');

        // The lead is already stored, so reply to the visitor immediately and send the emails
        // right after the response (on LiteSpeed/PHP-FPM the visitor does not wait for SMTP).
        app()->terminating(function () use ($data, $lead, $notify, $page) {
            $sent = false;

            // Shared SMTP hosts occasionally drop the first connection, so retry once.
            for ($attempt = 1; $attempt <= 2 && ! $sent; $attempt++) {
                try {
                    Mail::to($notify)->send(new BookingRequest($data, $page));
                    $sent = true;
                } catch (\Throwable $e) {
                    report($e);
                    usleep(600000);
                }
            }

            if ($sent && ! empty($data['email'])) {
                try {
                    Mail::to($data['email'])->send(new BookingConfirmation($data));
                } catch (\Throwable $e) {
                    report($e); // the team notification already went out
                }
            }

            $lead->update(['mail_sent' => $sent]);
        });

        return response()->json(['ok' => true]);
    }
}