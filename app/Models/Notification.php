<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'custom_notifications';

    protected $fillable = [
        'type',
        'title',
        'message',
        'order_id',
        'user_id',
        'is_read',
        'read_at',
        'data',
        'notifiable_type',
        'notifiable_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the order that this notification belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that this notification belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope a query to filter by user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): bool
    {
        return $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread(): bool
    {
        return $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Get notification icon based on type.
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'order_success' => 'check-circle',
            'order_cancelled' => 'x-circle',
            'order_failed' => 'alert-circle',
            'order_status_changed' => 'info',
            default => 'bell',
        };
    }

    /**
     * Get notification icon color class based on type.
     */
    public function getIconColorClassAttribute(): string
    {
        return match($this->type) {
            'order_success' => 'bg-green-100 text-green-500',
            'order_cancelled' => 'bg-red-100 text-red-500',
            'order_failed' => 'bg-red-100 text-red-500',
            'order_status_changed' => 'bg-blue-100 text-blue-500',
            default => 'bg-slate-100 text-slate-500',
        };
    }
}

