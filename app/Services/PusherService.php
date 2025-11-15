<?php

namespace App\Services;

use App\Models\NotificationSetting;
use Pusher\Pusher;
use Pusher\PusherException;
use Illuminate\Support\Facades\Log;

class PusherService
{
    protected ?Pusher $pusher = null;
    protected ?NotificationSetting $settings = null;

    /**
     * Get Pusher instance.
     */
    public function getPusherInstance(): ?Pusher
    {
        if ($this->pusher !== null) {
            return $this->pusher;
        }

        $settings = $this->getSettings();

        if (!$settings->is_enabled) {
            return null;
        }

        if (!$settings->pusher_app_id || !$settings->pusher_key || !$settings->pusher_secret) {
            return null;
        }

        try {
            $secret = $settings->getDecryptedSecret();
            if (!$secret) {
                Log::error('PusherService: Failed to decrypt Pusher secret');
                return null;
            }

            $this->pusher = new Pusher(
                $settings->pusher_key,
                $secret,
                $settings->pusher_app_id,
                [
                    'cluster' => $settings->pusher_cluster ?? 'ap2',
                    'useTLS' => true,
                ]
            );

            return $this->pusher;
        } catch (PusherException $e) {
            Log::error('PusherService: Pusher initialization failed', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('PusherService: Unexpected error during initialization', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    /**
     * Get notification settings.
     */
    protected function getSettings(): NotificationSetting
    {
        if ($this->settings === null) {
            $this->settings = NotificationSetting::getSettings();
        }

        return $this->settings;
    }

    /**
     * Reset Pusher instance (useful for testing with new credentials).
     */
    public function resetInstance(): void
    {
        $this->pusher = null;
        $this->settings = null;
    }

    /**
     * Set temporary settings for testing (without saving to database).
     */
    public function setTemporarySettings(NotificationSetting $tempSettings): void
    {
        $this->settings = $tempSettings;
        $this->pusher = null; // Reset pusher instance to use new settings
    }

    /**
     * Test Pusher connection.
     */
    public function testConnection(): array
    {
        $settings = $this->getSettings();

        if (!$settings->is_enabled) {
            return [
                'success' => false,
                'message' => 'Notifications are disabled. Please enable them first.',
            ];
        }

        if (!$settings->pusher_app_id || !$settings->pusher_key || !$settings->pusher_secret) {
            return [
                'success' => false,
                'message' => 'Pusher credentials are incomplete. Please fill in all fields.',
            ];
        }

        $pusher = $this->getPusherInstance();

        if (!$pusher) {
            Log::error('PusherService: Test failed - could not create Pusher instance');
            return [
                'success' => false,
                'message' => 'Failed to initialize Pusher. Please check your credentials and try again.',
            ];
        }

        try {
            $result = $pusher->trigger('test-channel', 'test-event', [
                'message' => 'Connection test successful',
                'timestamp' => now()->toDateTimeString(),
            ]);

            return [
                'success' => true,
                'message' => 'Pusher connection test successful! You should see a test event in your Pusher dashboard.',
            ];
        } catch (PusherException $e) {
            Log::error('PusherService: Test failed - PusherException', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            return [
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage() . ' (Code: ' . $e->getCode() . ')',
            ];
        } catch (\Exception $e) {
            Log::error('PusherService: Test failed - Exception', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            return [
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Broadcast notification.
     */
    public function broadcastNotification(array $notificationData): bool
    {
        $pusher = $this->getPusherInstance();

        if (!$pusher) {
            return false;
        }

        try {
            $pusher->trigger(
                'admin-notifications',
                'OrderNotificationCreated',
                $notificationData
            );

            return true;
        } catch (PusherException $e) {
            Log::error('PusherService: Failed to broadcast notification - PusherException', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'notification_id' => $notificationData['id'] ?? null,
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('PusherService: Failed to broadcast notification - Exception', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'notification_id' => $notificationData['id'] ?? null,
            ]);
            return false;
        }
    }

    /**
     * Get Pusher configuration for frontend.
     */
    public function getConfigForFrontend(): array
    {
        $settings = $this->getSettings();

        if (!$settings->is_enabled) {
            return [
                'enabled' => false,
            ];
        }

        return [
            'enabled' => true,
            'key' => $settings->pusher_key,
            'cluster' => $settings->pusher_cluster ?? 'ap2',
        ];
    }
}
