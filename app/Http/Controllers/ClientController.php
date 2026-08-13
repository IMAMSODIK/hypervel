<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('sort_order')->orderBy('id')->get();

        return view('master.clients.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'website' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'logo.image' => 'The file must be an image.',
            'logo.mimes' => 'Allowed: jpg, jpeg, png, webp, svg.',
            'logo.max' => 'Max size 1MB.',
        ]);

        $path = $request->hasFile('logo') ? $request->file('logo')->store('clients', 'public') : null;

        Client::create([
            'name' => $validated['name'],
            'logo' => $path,
            'disk' => 'public',
            'website' => $validated['website'] ?? '',
            'sort_order' => $validated['sort_order'] ?? (Client::max('sort_order') + 1),
            'is_active' => true,
        ]);

        return redirect()->route('master.clients.index')->with('success', 'Client added successfully.');
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'website' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'logo.image' => 'The file must be an image.',
            'logo.mimes' => 'Allowed: jpg, jpeg, png, webp, svg.',
            'logo.max' => 'Max size 1MB.',
        ]);

        if ($request->boolean('clear_logo') && $client->logo) {
            if (Storage::disk($client->disk)->exists($client->logo)) {
                Storage::disk($client->disk)->delete($client->logo);
            }
            $client->logo = null;
        }

        if ($request->hasFile('logo')) {
            if ($client->logo && Storage::disk($client->disk)->exists($client->logo)) {
                Storage::disk($client->disk)->delete($client->logo);
            }
            $client->logo = $request->file('logo')->store('clients', 'public');
            $client->disk = 'public';
        }

        $client->name = $validated['name'];
        $client->website = $validated['website'] ?? '';
        $client->sort_order = $validated['sort_order'] ?? $client->sort_order;
        $client->is_active = $request->has('is_active');
        $client->save();

        return redirect()->route('master.clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        if ($client->logo && Storage::disk($client->disk)->exists($client->logo)) {
            Storage::disk($client->disk)->delete($client->logo);
        }
        $client->delete();

        return redirect()->route('master.clients.index')->with('success', 'Client deleted successfully.');
    }
}