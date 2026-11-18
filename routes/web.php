<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\SiteController;
use App\Http\Middleware\ComingSoon;
use App\Http\Middleware\TrackVisit;
use Illuminate\Support\Facades\Route;

/* ------------------------------ Public site ------------------------------ */
Route::controller(SiteController::class)->middleware([ComingSoon::class, TrackVisit::class])->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/home-2', 'home2')->name('home2');
    Route::get('/home-3', 'home3')->name('home3');
    Route::get('/about', 'about')->name('about');
    Route::get('/services', 'services')->name('services');
    Route::get('/services/{slug}', 'service')->name('service');
    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('/clients', 'clients')->name('clients');
    Route::get('/testimonials', 'testimonials')->name('testimonials');
    Route::get('/insights', 'blog')->name('blog');
    Route::get('/insights/{slug}', 'post')->name('post');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/privacy-policy', 'privacy')->name('privacy');
    Route::get('/terms', 'terms')->name('terms');
});
Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->middleware(ComingSoon::class)->name('sitemap');
Route::post('/booking', [SiteController::class, 'booking'])->middleware('throttle:6,1')->name('booking');

/* ------------------------- First-install (no terminal) ------------------------- */
Route::get('/system/setup', [SetupController::class, 'show'])->name('setup');
Route::post('/system/setup', [SetupController::class, 'run'])->middleware('throttle:3,1');

/* --------------------------------- Admin --------------------------------- */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [Admin\AuthController::class, 'show'])->name('login');
        Route::post('login', [Admin\AuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('posts', Admin\PostController::class)->except('show');
        Route::patch('posts/{post}/toggle', [Admin\PostController::class, 'toggle'])->name('posts.toggle');
        Route::post('media/upload', [Admin\MediaController::class, 'upload'])->name('media.upload');

        Route::get('leads/export', [Admin\LeadController::class, 'export'])->name('leads.export');
        Route::resource('leads', Admin\LeadController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::patch('leads/{lead}/status', [Admin\LeadController::class, 'status'])->name('leads.status');

        Route::get('account', [Admin\AccountController::class, 'edit'])->name('account');
        Route::put('account/profile', [Admin\AccountController::class, 'profile'])->name('account.profile');
        Route::put('account/password', [Admin\AccountController::class, 'password'])->name('account.password');

        Route::get('settings', [Admin\SettingsController::class, 'edit'])->name('settings');
        Route::put('settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::post('settings/toggle', [Admin\SettingsController::class, 'toggle'])->name('settings.toggle');
        Route::get('settings/preview', [Admin\SettingsController::class, 'preview'])->name('settings.preview');

        Route::get('system', [Admin\SystemController::class, 'index'])->name('system');
        Route::post('system/update', [Admin\SystemController::class, 'update'])->name('system.update');
        Route::post('system/clear-cache', [Admin\SystemController::class, 'clearCache'])->name('system.cache');
        Route::post('system/test-mail', [Admin\SystemController::class, 'testMail'])->name('system.mail');
    });
});
