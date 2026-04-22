<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show the site settings form.
     */
    public function index(): View
    {
        $settings = Setting::pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Save all site settings.
     */
    public function update(SettingRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $booleanKeys = ['cod_enabled', 'bkash_enabled', 'nagad_enabled', 'maintenance_mode'];

        $settingsToSave = [];

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $settingsToSave['site_logo'] = $request->file('site_logo')->store('settings', 'public');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $settingsToSave['site_favicon'] = $request->file('site_favicon')->store('settings', 'public');
        }

        // Map remaining scalar fields
        $scalarFields = ['site_name', 'phone', 'email', 'address', 'about_us', 'whatsapp', 'facebook_url', 'instagram_url', 'delivery_charge'];
        foreach ($scalarFields as $field) {
            $settingsToSave[$field] = $validated[$field] ?? null;
        }

        // Boolean toggles — checkbox absent = 0
        foreach ($booleanKeys as $key) {
            $settingsToSave[$key] = $request->boolean($key) ? '1' : '0';
        }

        Setting::setMany($settingsToSave);

        return back()->with('success', 'সেটিংস সফলভাবে সেভ হয়েছে।');
    }
}
