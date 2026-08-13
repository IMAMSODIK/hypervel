<?php

namespace App\Http\Controllers;

use App\Models\AuthBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthBannerController extends Controller
{
    public function index()
    {
        $banners = AuthBanner::orderBy('sort_order')->orderBy('id')->get();

        return view('master.auth-banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'image.required' => 'Please select a banner image.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed formats: jpg, jpeg, png, webp.',
            'image.max' => 'Maximum file size is 2 MB.',
        ]);

        $path = $request->file('image')->store('auth_banners', 'public');

        AuthBanner::create([
            'title' => $validated['title'],
            'image' => $path,
            'disk' => 'public',
            'sort_order' => AuthBanner::max('sort_order') + 1,
            'is_active' => true,
        ]);

        return redirect()->route('master.auth.banner')->with('success', 'Banner added successfully.');
    }

    public function update(Request $request, AuthBanner $auth_banner)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $auth_banner->update([
            'title' => $validated['title'] ?? $auth_banner->title,
            'sort_order' => $validated['sort_order'] ?? $auth_banner->sort_order,
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('master.auth.banner')->with('success', 'Banner updated successfully.');
    }

    public function destroy(AuthBanner $auth_banner)
    {
        if ($auth_banner->disk && Storage::disk($auth_banner->disk)->exists($auth_banner->image)) {
            Storage::disk($auth_banner->disk)->delete($auth_banner->image);
        }

        $auth_banner->delete();

        return redirect()->route('master.auth.banner')->with('success', 'Banner deleted successfully.');
    }
}