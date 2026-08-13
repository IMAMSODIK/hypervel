<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->orderBy('id')->get();

        return view('master.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed formats: jpg, jpeg, png, webp.',
            'image.max' => 'Maximum file size is 2 MB.',
        ]);

        $path = null;
        $disk = 'public';
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
        }

        Service::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'icon' => $validated['icon'] ?? '',
            'image' => $path,
            'disk' => $disk,
            'sort_order' => Service::max('sort_order') + 1,
            'is_active' => true,
        ]);

        return redirect()->route('master.services.index')->with('success', 'Service added successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed formats: jpg, jpeg, png, webp.',
            'image.max' => 'Maximum file size is 2 MB.',
        ]);

        if ($request->boolean('clear_image') && $service->image) {
            if (Storage::disk($service->disk)->exists($service->image)) {
                Storage::disk($service->disk)->delete($service->image);
            }
            $service->image = null;
        }

        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk($service->disk)->exists($service->image)) {
                Storage::disk($service->disk)->delete($service->image);
            }
            $service->image = $request->file('image')->store('services', 'public');
            $service->disk = 'public';
        }

        $service->title = $validated['title'];
        $service->description = $validated['description'] ?? '';
        $service->icon = $validated['icon'] ?? '';
        $service->sort_order = $validated['sort_order'] ?? $service->sort_order;
        $service->is_active = $request->has('is_active') ? $request->boolean('is_active') : $service->is_active;
        $service->save();

        return redirect()->route('master.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if ($service->image && Storage::disk($service->disk)->exists($service->image)) {
            Storage::disk($service->disk)->delete($service->image);
        }

        $service->delete();

        return redirect()->route('master.services.index')->with('success', 'Service deleted successfully.');
    }
}