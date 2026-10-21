<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();
        return view('pages.contact', compact('settings'));
    }

    public function submit(Request $request)
    {
        // Anti-spam honeypot check
        if ($request->filled('website_hp')) {
            return redirect()->back()->with('success', 'Thank you! Your message has been received.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'inquiry_type' => 'required|string|in:General Inquiry,Bug Report,Feature Request,Sponsorship/Donation,Enterprise Support',
            'message' => 'required|string|min:10|max:5000',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'inquiry_type' => $validated['inquiry_type'],
            'message' => $validated['message'],
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('contact')->with('success', 'Thank you for reaching out! Your message has been received by the PocketSQL engineering team. We will get back to you within 24-48 hours.');
    }
}
