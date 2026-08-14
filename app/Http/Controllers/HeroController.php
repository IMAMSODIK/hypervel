<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    private array $heroKeys = [
        'hero_title',
        'hero_subtitle',
        'hero_video',
    ];

    public function edit()
    {
        $settings = Setting::getMany($this->heroKeys);

        return view('master.hero.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'hero_video_url' => ['nullable', 'url', 'max:500'],
            'hero_video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm', 'max:51200'],
        ]);

        Setting::set('hero_title', $validated['hero_title'] ?? '');
        Setting::set('hero_subtitle', $validated['hero_subtitle'] ?? '');

        $current = Setting::get('hero_video', '');

        if ($request->hasFile('hero_video_file')) {
            if ($current && ! str_starts_with($current, 'http')) {
                if (Storage::disk('public')->exists($current)) {
                    Storage::disk('public')->delete($current);
                }
            }
            $path = $request->file('hero_video_file')->store('hero_videos', 'public');
            Setting::set('hero_video', $path);
        } elseif (! empty($validated['hero_video_url'])) {
            if ($current && ! str_starts_with($current, 'http')) {
                if (Storage::disk('public')->exists($current)) {
                    Storage::disk('public')->delete($current);
                }
            }
            Setting::set('hero_video', $validated['hero_video_url']);
        } elseif ($request->boolean('clear_hero_video')) {
            if ($current && ! str_starts_with($current, 'http')) {
                if (Storage::disk('public')->exists($current)) {
                    Storage::disk('public')->delete($current);
                }
            }
            Setting::set('hero_video', '');
        }

        Setting::flush();

        return redirect()->route('master.hero.index')->with('success', 'Hero section updated successfully.');
    }
}
