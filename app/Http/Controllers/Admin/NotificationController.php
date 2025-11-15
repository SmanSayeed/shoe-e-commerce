<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $userId = auth()->guard('admin')->id();

        $query = Notification::forUser($userId)->latest();

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        // Filter by read status
        if ($request->has('status')) {
            if ($request->status === 'read') {
                $query->read();
            } elseif ($request->status === 'unread') {
                $query->unread();
            }
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $notifications = $query->with('order')->paginate(20)->withQueryString();

        $unreadCount = $this->notificationService->getUnreadCount($userId);

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Get notifications for dropdown (API).
     */
    public function getNotifications(Request $request)
    {
        $userId = auth()->guard('admin')->id();
        $limit = $request->get('limit', 10);

        $notifications = Notification::forUser($userId)
            ->with('order')
            ->latest()
            ->limit($limit)
            ->get();

        $unreadCount = $this->notificationService->getUnreadCount($userId);

        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'order_id' => $notification->order_id,
                    'order_number' => optional($notification->order)->order_number ?? ($notification->data['order_number'] ?? null),
                    'is_read' => $notification->is_read,
                    'icon' => $notification->icon,
                    'icon_color_class' => $notification->icon_color_class,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'created_at_full' => $notification->created_at->toDateTimeString(),
                ];
            }),
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Get unread count (API).
     */
    public function getUnreadCount()
    {
        $userId = auth()->guard('admin')->id();
        $count = $this->notificationService->getUnreadCount($userId);

        return response()->json(['count' => $count]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $userId = auth()->guard('admin')->id();
        $notification = Notification::forUser($userId)->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $userId = auth()->guard('admin')->id();

        Notification::forUser($userId)->unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.',
        ]);
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread($id)
    {
        $userId = auth()->guard('admin')->id();
        $notification = Notification::forUser($userId)->findOrFail($id);

        $notification->markAsUnread();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as unread.',
        ]);
    }
}

