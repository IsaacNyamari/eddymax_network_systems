<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $messages = Message::latest()->where("read", false)
            ->get();

        $unreadCount = Message::where('read', false)->count();

        return view('dashboard.admin.messages.index', compact('messages', 'unreadCount'));
    }

    public function show(Message $message)
    {
        return response()->json([
            'message' => $message,
            'formatted_date' => $message->created_at->format('M d, Y'),
            'formatted_time' => $message->created_at->format('h:i A'),
        ]);
    }

    public function markAsRead(Message $message)
    {
        $message->update(['read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAsUnread(Message $message)
    {
        $message->update(['read' => false]);

        return response()->json(['success' => true]);
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json(['success' => true]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_unread,delete',
            'message_ids' => 'required|array',
        ]);

        switch ($request->action) {
            case 'mark_read':
                Message::whereIn('id', $request->message_ids)->update(['read' => true]);
                break;

            case 'mark_unread':
                Message::whereIn('id', $request->message_ids)->update(['read' => false]);
                break;

            case 'delete':
                Message::whereIn('id', $request->message_ids)->delete();
                break;
        }

        return response()->json(['success' => true]);
    }
}
