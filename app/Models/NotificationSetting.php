<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class NotificationSetting extends Model
{
    protected $fillable = [
        'pusher_app_id',
        'pusher_key',
        'pusher_secret',
        'pusher_cluster',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /**
     * Get the encrypted pusher secret.
     */
    public function getEncryptedSecretAttribute(): ?string
    {
        return $this->pusher_secret ? Crypt::encryptString($this->pusher_secret) : null;
    }

    /**
     * Set the pusher secret (encrypt it).
     */
    public function setPusherSecretAttribute($value): void
    {
        if (empty($value)) {
            // Don't update if empty (to preserve existing secret)
            if (!isset($this->attributes['pusher_secret'])) {
                $this->attributes['pusher_secret'] = null;
            }
        } else {
            $this->attributes['pusher_secret'] = Crypt::encryptString($value);
        }
    }

    /**
     * Get the decrypted pusher secret.
     */
    public function getDecryptedSecret(): ?string
    {
        try {
            return $this->pusher_secret ? Crypt::decryptString($this->pusher_secret) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the default notification settings instance.
     */
    public static function getSettings(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'pusher_app_id' => null,
                'pusher_key' => null,
                'pusher_secret' => null,
                'pusher_cluster' => 'ap2',
                'is_enabled' => false,
            ]
        );
    }
}

