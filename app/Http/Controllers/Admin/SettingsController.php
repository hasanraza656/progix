<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ComingSoon;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings', [
            'enabled' => Setting::comingSoon(),
            'title' => Setting::get('cs_title', ''),
            'message' => Setting::get('cs_message', ''),
            'launch' => Setting::get('cs_launch', ''),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'cs_title' => ['nullable', 'string', 'max:120'],
            'cs_message' => ['nullable', 'string', 'max:500'],
            'cs_launch' => ['nullable', 'date'],
        ]);

        Setting::put([
            'coming_soon' => $request->boolean('coming_soon') ? '1' : '0',
            'cs_title' => $data['cs_title'] ?? '',
            'cs_message' => $data['cs_message'] ?? '',
            'cs_launch' => $data['cs_launch'] ?? '',
        ]);

        return back()->with('success', $request->boolean('coming_soon')
            ? 'Coming soon mode is ON — visitors now see the coming soon page.'
            : 'Coming soon mode is OFF — the website is live.');
    }

    /** One-click switch used from the dashboard. */
    public function toggle()
    {
        $on = ! Setting::comingSoon();
        Setting::put(['coming_soon' => $on ? '1' : '0']);

        return back()->with('success', $on ? 'Coming soon mode is ON — visitors now see the coming soon page.' : 'The website is LIVE.');
    }

    /** Lets admins look at the coming-soon page without switching the mode on. */
    public function preview()
    {
        return response()->view('coming-soon', ComingSoon::data() + ['preview' => true]);
    }
}
