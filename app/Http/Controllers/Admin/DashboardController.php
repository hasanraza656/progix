<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = in_array((int) $request->query('range'), [7, 30, 90], true) ? (int) $request->query('range') : 14;
        $from = today()->subDays($range - 1);
        $prevFrom = $from->copy()->subDays($range);

        $uniq = fn ($q) => (int) $q->distinct()->count(DB::raw("CONCAT(visited_on, visitor_hash)"));

        $cur = Visit::where('visited_on', '>=', $from);
        $prev = Visit::whereBetween('visited_on', [$prevFrom, $from->copy()->subDay()]);

        $visitors = $uniq(clone $cur);
        $views = (clone $cur)->count();
        $prevVisitors = $uniq(clone $prev);
        $prevViews = (clone $prev)->count();

        // daily series
        $daily = Visit::where('visited_on', '>=', $from)
            ->selectRaw('visited_on as d, COUNT(*) as views, COUNT(DISTINCT visitor_hash) as visitors')
            ->groupBy('d')->get()->keyBy(fn ($r) => Carbon::parse($r->d)->toDateString());
        $series = collect(range(0, $range - 1))->map(function ($i) use ($from, $daily) {
            $d = $from->copy()->addDays($i);
            $row = $daily->get($d->toDateString());

            return ['date' => $d, 'views' => (int) ($row->views ?? 0), 'visitors' => (int) ($row->visitors ?? 0)];
        });

        $topPages = Visit::where('visited_on', '>=', $from)->selectRaw('path, COUNT(*) as views')->groupBy('path')->orderByDesc('views')->limit(6)->get();
        $sources = Visit::where('visited_on', '>=', $from)->selectRaw("COALESCE(referrer_host, 'Direct / none') as src, COUNT(*) as n")->groupBy('src')->orderByDesc('n')->limit(6)->get();
        $devices = Visit::where('visited_on', '>=', $from)->selectRaw('device, COUNT(*) as n')->groupBy('device')->pluck('n', 'device');

        $leadCounts = Lead::selectRaw('status, COUNT(*) n')->groupBy('status')->pluck('n', 'status');
        $leadsRange = Lead::where('created_at', '>=', $from)->count();
        $leadsPrev = Lead::whereBetween('created_at', [$prevFrom, $from->copy()->subDay()->endOfDay()])->count();

        return view('admin.dashboard', [
            'range' => $range,
            'visitors' => $visitors, 'views' => $views,
            'visitorsDelta' => $this->delta($visitors, $prevVisitors), 'viewsDelta' => $this->delta($views, $prevViews),
            'leadsRange' => $leadsRange, 'leadsDelta' => $this->delta($leadsRange, $leadsPrev),
            'today' => Visit::where('visited_on', today())->distinct()->count('visitor_hash'),
            'series' => $series, 'max' => max(1, $series->max('views')),
            'topPages' => $topPages, 'sources' => $sources, 'devices' => $devices,
            'leadCounts' => $leadCounts, 'newLeads' => (int) ($leadCounts['new'] ?? 0), 'totalLeads' => $leadCounts->sum(),
            'recentLeads' => Lead::latest()->take(5)->get(),
            'postsPublished' => Post::published()->count(), 'postsDraft' => Post::where('status', 'draft')->count(),
            'topPosts' => Post::orderByDesc('views')->take(5)->get(),
        ]);
    }

    private function delta(int $now, int $before): ?float
    {
        if ($before === 0) {
            return $now > 0 ? 100.0 : null;
        }

        return round(($now - $before) / $before * 100, 1);
    }
}
