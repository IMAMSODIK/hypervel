<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private array $contactKeys = [
        'contact_phone',
        'contact_phone2',
        'contact_email',
        'contact_address',
        'contact_hours',
        'contact_facebook',
        'contact_linkedin',
        'contact_instagram',
        'contact_youtube',
    ];

    public function edit()
    {
        $settings = Setting::getMany($this->contactKeys);

        return view('master.settings.contact', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_phone2' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'contact_hours' => ['nullable', 'string', 'max:200'],
            'contact_facebook' => ['nullable', 'url', 'max:255'],
            'contact_linkedin' => ['nullable', 'url', 'max:255'],
            'contact_instagram' => ['nullable', 'url', 'max:255'],
            'contact_youtube' => ['nullable', 'url', 'max:255'],
        ]);

        foreach ($this->contactKeys as $key) {
            Setting::set($key, $validated[$key] ?? '');
        }

        Setting::flush();

        return redirect()->route('master.settings.contact')->with('success', 'Contact information updated successfully.');
    }
}