<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    private array $keys = [
        'about_title',
        'about_subtitle',
        'about_description',
        'about_image1',
        'about_image2',
        'about_bullets',
    ];

    public function edit()
    {
        $settings = Setting::getMany($this->keys);

        $bullets = $settings['about_bullets'] ?? '';
        $bullets = $bullets ? explode('|', $bullets) : [];

        return view('master.about.index', compact('settings', 'bullets'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'about_title' => ['nullable', 'string', 'max:255'],
            'about_subtitle' => ['nullable', 'string', 'max:500'],
            'about_description' => ['nullable', 'string'],
            'about_bullets' => ['nullable', 'array'],
            'about_bullets.*' => ['nullable', 'string', 'max:255'],
            'about_image1' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'about_image2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        Setting::set('about_title', $validated['about_title'] ?? '');
        Setting::set('about_subtitle', $validated['about_subtitle'] ?? '');
        Setting::set('about_description', $validated['about_description'] ?? '');

        $bullets = array_filter($validated['about_bullets'] ?? [], fn ($v) => trim($v) !== '');
        Setting::set('about_bullets', implode('|', $bullets));

        foreach (['about_image1', 'about_image2'] as $key) {
            if ($request->hasFile($key)) {
                $current = Setting::get($key, '');
                if ($current) {
                    $rel = str_replace('/storage/', '', $current);
                    if (Storage::disk('public')->exists($rel)) {
                        Storage::disk('public')->delete($rel);
                    }
                }
                $path = $request->file($key)->store('about_images', 'public');
                Setting::set($key, Storage::disk('public')->url($path));
            }
        }

        if ($request->boolean('clear_image1')) {
            $this->deleteImage('about_image1');
        }
        if ($request->boolean('clear_image2')) {
            $this->deleteImage('about_image2');
        }

        Setting::flush();

        return redirect()->route('master.about.index')->with('success', 'About section updated successfully.');
    }

    public function page()
    {
        $settings = Setting::getMany($this->keys);
        $bullets = $settings['about_bullets'] ?? '';
        $bullets = $bullets ? explode('|', $bullets) : [];

        return view('about.index', compact('settings', 'bullets'));
    }

    private function deleteImage(string $key): void
    {
        $current = Setting::get($key, '');
        if ($current) {
            $rel = str_replace('/storage/', '', $current);
            if (Storage::disk('public')->exists($rel)) {
                Storage::disk('public')->delete($rel);
            }
        }
        Setting::set($key, '');
    }
}