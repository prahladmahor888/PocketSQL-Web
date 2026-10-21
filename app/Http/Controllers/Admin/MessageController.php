<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = ContactMessage::orderBy('created_at', 'desc');

        if ($status && in_array($status, ['unread', 'replied', 'archived'])) {
            $query->where('status', $status);
        }

        $messages = $query->paginate(15);
        $unreadCount = ContactMessage::where('status', 'unread')->count();

        return view('admin.messages', compact('messages', 'unreadCount', 'status'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        return view('admin.message-show', compact('message'));
    }

    public function updateStatus(Request $request, ContactMessage $message)
    {
        $validated = $request->validate([
            'status' => 'required|in:unread,read,replied,archived',
        ]);

        $message->update(['status' => $validated['status']]);

        return back()->with('success', 'Message status updated.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Inquiry deleted successfully.');
    }
}
