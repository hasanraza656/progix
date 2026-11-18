<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    private function query(Request $request)
    {
        $q = Lead::query();
        if (array_key_exists((string) $request->query('status'), Lead::STATUSES)) {
            $q->where('status', $request->query('status'));
        }
        if ($s = trim((string) $request->query('q'))) {
            $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%")->orWhere('phone', 'like', "%$s%")->orWhere('service', 'like', "%$s%")->orWhere('message', 'like', "%$s%"));
        }

        return $q->latest();
    }

    public function index(Request $request)
    {
        return view('admin.leads.index', [
            'leads' => $this->query($request)->paginate(15)->withQueryString(),
            'counts' => Lead::selectRaw('status, COUNT(*) n')->groupBy('status')->pluck('n', 'status'),
        ]);
    }

    public function show(Lead $lead)
    {
        return view('admin.leads.show', ['lead' => $lead]);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate(['status' => ['required', Rule::in(array_keys(Lead::STATUSES))], 'notes' => ['nullable', 'string', 'max:5000']]);
        $lead->update($data);

        return back()->with('success', 'Lead updated.');
    }

    public function status(Request $request, Lead $lead)
    {
        $request->validate(['status' => ['required', Rule::in(array_keys(Lead::STATUSES))]]);
        $lead->update(['status' => $request->status]);

        return back()->with('success', 'Status changed to '.Lead::STATUSES[$request->status].'.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted.');
    }

    public function export(Request $request)
    {
        $rows = $this->query($request)->get();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['ID', 'Date', 'Name', 'Phone', 'Email', 'Service', 'Package', 'Best time', 'Message', 'Status', 'Notes', 'Source page']);
            foreach ($rows as $l) {
                fputcsv($out, [$l->id, $l->created_at->format('Y-m-d H:i'), $l->name, $l->phone, $l->email, $l->service, $l->package, $l->preferred_time, $l->message, $l->status, $l->notes, $l->source_page]);
            }
            fclose($out);
        }, 'progix-leads-'.date('Y-m-d').'.csv', ['Content-Type' => 'text/csv']);
    }
}
