<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

/**
 * When "Coming soon" mode is switched on in the admin panel, visitors get the coming-soon
 * page (HTTP 503 so search engines don't index it). Signed-in admins still see the real site.
 */
class ComingSoon
{
    public function handle(Request $request, Closure $next)
    {
        if (Setting::comingSoon() && ! $request->user()) {
            return response()
                ->view('coming-soon', self::data(), 503)
                ->header('Retry-After', '86400')
                ->header('X-Robots-Tag', 'noindex, nofollow');
        }

        return $next($request);
    }

    public static function data(): array
    {
        $launch = Setting::get('cs_launch');
        try {
            $launchIso = $launch ? \Illuminate\Support\Carbon::parse($launch, config('app.timezone'))->toIso8601String() : null;
        } catch (\Throwable $e) {
            $launchIso = null;
        }

        return [
            'csTitle' => Setting::get('cs_title', 'Something great is on its way'),
            'csMessage' => Setting::get('cs_message', 'We’re putting the finishing touches on our new website. Marketing, web development and AI automation — all under one roof. Leave your details and we’ll let you know the moment we launch.'),
            'csLaunch' => $launchIso,
        ];
    }
}
