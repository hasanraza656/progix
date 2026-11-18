<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;

/** Lightweight, cookie-less, privacy-friendly visit counter for the public site. */
class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            if ($request->isMethod('GET') && $response->getStatusCode() === 200 && ! $request->ajax() && ! $request->user()) {
                $ua = (string) $request->userAgent();
                if ($ua !== '' && ! preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|lighthouse|headless|curl|wget|monitor|uptime/i', $ua)) {
                    $ref = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST) ?: null;
                    if ($ref && $ref === $request->getHost()) {
                        $ref = null;
                    }
                    Visit::create([
                        'visited_on' => today(),
                        'visitor_hash' => sha1($request->ip().'|'.$ua.'|'.today()->toDateString().'|'.config('app.key')),
                        'path' => '/'.ltrim($request->path(), '/'),
                        'referrer_host' => $ref ? substr(preg_replace('/^www\./', '', $ref), 0, 120) : null,
                        'device' => preg_match('/ipad|tablet/i', $ua) ? 'tablet' : (preg_match('/mobi|android|iphone/i', $ua) ? 'mobile' : 'desktop'),
                        'created_at' => now(),
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // tracking must never break a page (e.g. before migrations have run)
        }

        return $response;
    }
}
