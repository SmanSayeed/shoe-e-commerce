<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected PusherService $pusherService;

    public function __construct(PusherService $pusherService)
    {
        $this->pusherService = $pusherService;
    }

    /**
     * Create order notification.
     */
    public function createOrderNotification(Order $order, string $type, string $title, string $message, ?array $data = null): ?Notification
    {
        // Get all admin users
        $adminUsers = User::where('role', 'admin')->get();

        if ($adminUsers->isEmpty()) {
            Log::warning('NotificationService: No admin users found to send notification to');
            return null;
        }

        $notifications = [];

        foreach ($adminUsers as $admin) {
            try {
                $notification = Notification::create([
                    'type' => $type,
                    'title' => $title,
                    'message' => $message,
                    'order_id' => $order->id,
                    'user_id' => $admin->id,
                    'is_read' => false,
                    'notifiable_type' => null, // Not using polymorphic relationship
                    'notifiable_id' => null, // Not using polymorphic relationship
                    'data' => $data ?? [
                        'order_number' => $order->order_number,
                        'order_id' => $order->id,
                        'total_amount' => $order->total_amount,
                        'status' => $order->status,
                        'payment_status' => $order->payment_status,
                    ],
                ]);

                $notifications[] = $notification;
            } catch (\Exception $e) {
                Log::error('NotificationService: Failed to create notification for user', [
                    'user_id' => $admin->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Broadcast to all admins (only if notifications were created)
        if (!empty($notifications)) {
            $this->broadcastNotification($notifications[0]);
        }

        return $notifications[0] ?? null;
    }

    /**
     * Send order success notification.
     */
    public function sendOrderSuccessNotification(Order $order): ?Notification
    {
        return $this->createOrderNotification(
            $order,
            'order_success',
            'New Order Received',
            "Order #{$order->order_number} has been placed successfully. Total: {$order->currency} " . number_format($order->total_amount, 2),
            [
                'order_number' => $order->order_number,
                'order_id' => $order->id,
                'total_amount' => $order->total_amount,
                'currency' => $order->currency,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
            ]
        );
    }

    /**
     * Send order cancelled notification.
     */
    public function sendOrderCancelledNotification(Order $order, ?string $reason = null): ?Notification
    {
        $message = "Order #{$order->order_number} has been cancelled.";
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        return $this->createOrderNotification(
            $order,
            'order_cancelled',
            'Order Cancelled',
            $message,
            [
                'order_number' => $order->order_number,
                'order_id' => $order->id,
                'reason' => $reason,
            ]
        );
    }

    /**
     * Send order failed notification.
     */
    public function sendOrderFailedNotification(Order $order, ?string $reason = null): ?Notification
    {
        $message = "Payment failed for Order #{$order->order_number}.";
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        return $this->createOrderNotification(
            $order,
            'order_failed',
            'Payment Failed',
            $message,
            [
                'order_number' => $order->order_number,
                'order_id' => $order->id,
                'reason' => $reason,
            ]
        );
    }

    /**
     * Send order status changed notification.
     */
    public function sendOrderStatusChangedNotification(Order $order, string $oldStatus, string $newStatus): ?Notification
    {
        return $this->createOrderNotification(
            $order,
            'order_status_changed',
            'Order Status Updated',
            "Order #{$order->order_number} status changed from " . ucfirst($oldStatus) . " to " . ucfirst($newStatus),
            [
                'order_number' => $order->order_number,
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]
        );
    }

    /**
     * Broadcast notification via Pusher.
     */
    protected function broadcastNotification(Notification $notification): void
    {
        // Load order relationship if not already loaded
        if (!$notification->relationLoaded('order')) {
            $notification->load('order');
        }

        $this->pusherService->broadcastNotification([
            'id' => $notification->id,
            'type' => $notification->type,
            'title' => $notification->title,
            'message' => $notification->message,
            'order_id' => $notification->order_id,
            'order_number' => optional($notification->order)->order_number ?? ($notification->data['order_number'] ?? null),
            'is_read' => $notification->is_read,
            'created_at' => $notification->created_at->toDateTimeString(),
            'icon' => $notification->icon,
            'icon_color_class' => $notification->icon_color_class,
        ]);
    }

    /**
     * Get unread count for a user.
     */
    public function getUnreadCount(?int $userId = null): int
    {
        if (!$userId) {
            $userId = auth()->guard('admin')->id();
        }

        if (!$userId) {
            return 0;
        }

        return Notification::forUser($userId)->unread()->count();
    }
}

