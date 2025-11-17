<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\WhatsAppChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhatsAppController extends Controller
{
    /**
     * Display WhatsApp settings and chat management dashboard
     */
    public function index()
    {
        $settings = [
            'whatsapp_enabled' => Setting::get('whatsapp_enabled', false),
            'whatsapp_phone' => Setting::get('whatsapp_phone', ''),
            'whatsapp_message' => Setting::get('whatsapp_message', 'Hello! I need help with my order.'),
            'whatsapp_chat_enabled' => Setting::get('whatsapp_chat_enabled', false),
        ];

        $chats = WhatsAppChat::with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_chats' => WhatsAppChat::count(),
            'pending_chats' => WhatsAppChat::where('status', 'pending')->count(),
            'replied_chats' => WhatsAppChat::where('status', 'replied')->count(),
            'closed_chats' => WhatsAppChat::where('status', 'closed')->count(),
        ];

        return view('admin.whatsapp.index', compact('settings', 'chats', 'stats'));
    }

    /**
     * Update WhatsApp settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'whatsapp_enabled' => 'boolean',
            'whatsapp_phone' => 'required_if:whatsapp_enabled,true|string|max:20',
            'whatsapp_message' => 'nullable|string|max:500',
            'whatsapp_chat_enabled' => 'boolean',
        ]);

        Setting::set('whatsapp_enabled', $request->boolean('whatsapp_enabled'));
        Setting::set('whatsapp_phone', $request->whatsapp_phone ?? '');
        Setting::set('whatsapp_message', $request->whatsapp_message ?? '');
        Setting::set('whatsapp_chat_enabled', $request->boolean('whatsapp_chat_enabled'));

        return redirect()->back()->with('success', 'WhatsApp settings updated successfully.');
    }

    /**
     * Show chat details
     */
    public function showChat($id)
    {
        $chat = WhatsAppChat::with('admin')->findOrFail($id);

        // Mark as read if pending
        if ($chat->status === 'pending') {
            $chat->update(['status' => 'read']);
        }

        return view('admin.whatsapp.show', compact('chat'));
    }

    /**
     * Reply to a chat
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $chat = WhatsAppChat::findOrFail($id);

        $chat->update([
            'admin_reply' => $request->admin_reply,
            'admin_id' => Auth::id(),
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }

    /**
     * Update chat status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,read,replied,closed',
        ]);

        $chat = WhatsAppChat::findOrFail($id);

        $updateData = ['status' => $request->status];

        if ($request->status === 'replied' && !$chat->replied_at) {
            $updateData['replied_at'] = now();
            $updateData['admin_id'] = Auth::id();
        }

        $chat->update($updateData);

        return redirect()->back()->with('success', 'Chat status updated successfully.');
    }

    /**
     * Delete a chat
     */
    public function destroy($id)
    {
        $chat = WhatsAppChat::findOrFail($id);
        $chat->delete();

        return redirect()->route('admin.whatsapp.index')->with('success', 'Chat deleted successfully.');
    }

    /**
     * Bulk actions for chats
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_replied,mark_closed,delete',
            'chat_ids' => 'required|array',
            'chat_ids.*' => 'exists:whatsapp_chats,id',
        ]);

        $chats = WhatsAppChat::whereIn('id', $request->chat_ids)->get();

        switch ($request->action) {
            case 'mark_read':
                $chats->each(function ($chat) {
                    if ($chat->status === 'pending') {
                        $chat->update(['status' => 'read']);
                    }
                });
                $message = 'Selected chats marked as read.';
                break;

            case 'mark_replied':
                $chats->each(function ($chat) {
                    $chat->update([
                        'status' => 'replied',
                        'admin_id' => Auth::id(),
                        'replied_at' => now(),
                    ]);
                });
                $message = 'Selected chats marked as replied.';
                break;

            case 'mark_closed':
                $chats->each(function ($chat) {
                    $chat->update(['status' => 'closed']);
                });
                $message = 'Selected chats marked as closed.';
                break;

            case 'delete':
                $chats->each->delete();
                $message = 'Selected chats deleted successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
