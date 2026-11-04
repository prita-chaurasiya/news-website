<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function about(): Response
    {
        return Inertia::render('Static/About');
    }

    public function contact(): Response
    {
        return Inertia::render('Static/Contact');
    }

    public function privacy(): Response
    {
        return Inertia::render('Static/Privacy');
    }

    public function terms(): Response
    {
        return Inertia::render('Static/Terms');
    }

    public function advertise(): Response
    {
        return Inertia::render('Static/Advertise');
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'department' => ['required', 'string', 'in:editorial,advertising,general,corrections'],
            'subject' => ['required', 'string', 'min:3', 'max:200'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        ContactMessage::create([
            ...$validated,
            'status' => 'unread',
        ]);

        return redirect()->back()->with('success', 'Your dispatch has been received by our editorial bureau. We will review and respond shortly.');
    }
}
