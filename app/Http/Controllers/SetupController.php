<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

/**
 * Terminal-free first install. Works ONLY while the database has no `users` table,
 * so it cannot be used to tamper with a live site.
 */
class SetupController extends Controller
{
    private function installed(): bool
    {
        try {
            return Schema::hasTable('users');
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function show()
    {
        if ($this->installed()) {
            return redirect()->route('admin.login');
        }

        try {
            \DB::connection()->getPdo();
            $dbError = null;
        } catch (\Throwable $e) {
            $dbError = $e->getMessage();
        }

        return view('admin.setup', ['dbError' => $dbError]);
    }

    public function run()
    {
        abort_if($this->installed(), 404);

        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
            Artisan::call('optimize:clear');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.login')->with('success', 'Installation complete. Sign in with the admin account.');
    }
}
