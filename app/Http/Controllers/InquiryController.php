<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:200'],
            'company' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'] ?? '',
            'phone' => $validated['phone'] ?? '',
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return back()->with('inquiry_success', 'Thank you! Your message has been sent. We will get back to you shortly.');
    }

    public function index()
    {
        $inquiries = Inquiry::latest()->get();

        return view('master.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        if (! $inquiry->is_read) {
            $inquiry->update(['is_read' => true]);
        }

        return view('master.inquiries.show', compact('inquiry'));
    }

    public function markRead(Inquiry $inquiry)
    {
        $inquiry->update(['is_read' => true]);

        return back()->with('success', 'Marked as read.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('master.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}