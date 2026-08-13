<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $stats = Statistic::orderBy('sort_order')->orderBy('id')->get();

        return view('master.statistics.index', compact('stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'value' => ['required', 'string', 'max:20'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'icon' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Statistic::create([
            'label' => $validated['label'],
            'value' => $validated['value'],
            'suffix' => $validated['suffix'] ?? '',
            'icon' => $validated['icon'] ?? '',
            'sort_order' => $validated['sort_order'] ?? Statistic::max('sort_order') + 1,
            'is_active' => true,
        ]);

        return redirect()->route('master.statistics.index')->with('success', 'Statistic added successfully.');
    }

    public function update(Request $request, Statistic $statistic)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'value' => ['required', 'string', 'max:20'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'icon' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $statistic->update([
            'label' => $validated['label'],
            'value' => $validated['value'],
            'suffix' => $validated['suffix'] ?? '',
            'icon' => $validated['icon'] ?? '',
            'sort_order' => $validated['sort_order'] ?? $statistic->sort_order,
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('master.statistics.index')->with('success', 'Statistic updated successfully.');
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();

        return redirect()->route('master.statistics.index')->with('success', 'Statistic deleted successfully.');
    }
}