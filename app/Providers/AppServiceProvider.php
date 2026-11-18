<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Database sessions need the `sessions` table. On a brand-new server (before the
        // terminal-free /system/setup has run) fall back to files for that moment only.
        // The positive result is cached, so normal requests never query for it.
        if (config('session.driver') === 'database') {
            try {
                $ready = Cache::rememberForever('sessions_table_ready', fn () => Schema::hasTable('sessions') ?: null);
            } catch (\Throwable $e) {
                $ready = null;
            }
            if (! $ready) {
                config(['session.driver' => 'file']);
            }
        }

        View::composer('*', function ($view) {
            $contact = config('progix.contact');
            $view->with([
                'site' => config('progix'),
                'wa'   => 'https://wa.me/'.$contact['whatsapp'],
                'comingSoon' => \App\Models\Setting::comingSoon(),
            ]);
        });
    }
}
