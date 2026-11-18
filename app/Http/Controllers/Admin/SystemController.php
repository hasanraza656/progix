<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SystemController extends Controller
{
    public function index()
    {
        $migrator = app('migrator');
        $files = $migrator->getMigrationFiles([database_path('migrations')]);
        $ran = $migrator->repositoryExists() ? $migrator->getRepository()->getRan() : [];
        $pending = array_values(array_diff(array_keys($files), $ran));

        try {
            $dbVersion = DB::selectOne('select version() as v')->v;
        } catch (\Throwable $e) {
            $dbVersion = 'unknown';
        }

        $writable = fn ($p) => is_dir($p) ? is_writable($p) : (@mkdir($p, 0775, true) && is_writable($p));

        return view('admin.system', [
            'pending' => $pending,
            'ranCount' => count($ran),
            'info' => [
                'Laravel' => app()->version(),
                'PHP' => PHP_VERSION,
                'Database' => config('database.default').' '.$dbVersion.' · '.config('database.connections.'.config('database.default').'.database'),
                'Environment' => app()->environment().(config('app.debug') ? ' (debug ON)' : ''),
                'Mail' => config('mail.default').' · '.config('mail.mailers.smtp.host').':'.config('mail.mailers.smtp.port'),
                'Notification emails' => implode(', ', config('mail.notify')) ?: '— not set',
                'Server time' => now()->format('Y-m-d H:i:s T'),
            ],
            'checks' => [
                'Uploads folder writable' => $writable(public_path('uploads')),
                'Storage writable' => is_writable(storage_path()),
                'Bootstrap cache writable' => is_writable(base_path('bootstrap/cache')),
                'APP_DEBUG is off' => ! config('app.debug'),
            ],
            'lastRun' => @json_decode(@file_get_contents(storage_path('app/last-update.json')), true),
        ]);
    }

    /** One-click update: run pending migrations, clear every cache, optionally rebuild caches. */
    public function update(Request $request)
    {
        $session = $request->session();
        $root = $request->root();
        $log = [];
        $ok = true;

        $steps = [
            ['migrate', ['--force' => true], 'Run database migrations'],
            ['optimize:clear', [], 'Clear config, route, view and application caches'],
        ];
        if ($request->boolean('rebuild')) {
            $steps[] = ['config:cache', [], 'Rebuild config cache'];
            $steps[] = ['route:cache', [], 'Rebuild route cache'];
            $steps[] = ['view:cache', [], 'Rebuild view cache'];
        }

        foreach ($steps as [$cmd, $args, $label]) {
            try {
                Artisan::call($cmd, $args);
                $log[] = ['ok' => true, 'label' => $label, 'output' => trim(preg_replace('/\e\[[\d;]*m/', '', Artisan::output()))];
            } catch (\Throwable $e) {
                $ok = false;
                $log[] = ['ok' => false, 'label' => $label, 'output' => $e->getMessage()];
                break;
            }
        }

        @file_put_contents(storage_path('app/last-update.json'), json_encode(['at' => now()->toDateTimeString(), 'ok' => $ok, 'by' => $request->user()->email]));

        // config:cache / route:cache boot a fresh application which replaces the global container,
        // so flash data must go into the ORIGINAL session store captured before the commands ran.
        $session->flash($ok ? 'success' : 'error', $ok ? 'System updated successfully.' : 'Update stopped because a step failed.');
        $session->flash('log', $log);

        return new RedirectResponse($root.'/admin/system');
    }

    public function clearCache()
    {
        Artisan::call('optimize:clear');

        return back()->with('success', 'All caches cleared.')->with('log', [['ok' => true, 'label' => 'Clear caches', 'output' => trim(preg_replace('/\e\[[\d;]*m/', '', Artisan::output()))]]);
    }

    public function testMail(Request $request)
    {
        try {
            Mail::to($request->user()->email)->send(new BookingRequest([
                'name' => 'SMTP test', 'phone' => 'n/a', 'service' => 'System check', 'message' => 'If you can read this, outgoing email works.',
            ], url('/')));
        } catch (\Throwable $e) {
            return back()->with('error', 'Mail failed: '.$e->getMessage());
        }

        return back()->with('success', 'Test email sent to '.$request->user()->email.'.');
    }
}
