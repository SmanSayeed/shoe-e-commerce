<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use App\Services\PusherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NotificationSettingsController extends Controller
{
    protected PusherService $pusherService;

    public function __construct(PusherService $pusherService)
    {
        $this->pusherService = $pusherService;
    }

    /**
     * Display notification settings page.
     */
    public function index()
    {
        $settings = NotificationSetting::getSettings();

        $pusherConfig = $this->pusherService->getConfigForFrontend();

        return view('admin.notification-settings.index', compact('settings', 'pusherConfig'));
    }

    /**
     * Update notification settings.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pusher_app_id' => 'nullable|string|max:255',
            'pusher_key' => 'nullable|string|max:255',
            'pusher_secret' => 'nullable|string|max:255',
            'pusher_cluster' => 'nullable|string|max:50',
            'is_enabled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $settings = NotificationSetting::getSettings();

        // Only update secret if provided (to avoid overwriting with empty)
        $updateData = [
            'pusher_app_id' => $request->pusher_app_id,
            'pusher_key' => $request->pusher_key,
            'pusher_cluster' => $request->pusher_cluster ?? 'ap2',
            'is_enabled' => $request->has('is_enabled'),
        ];

        $settings->fill($updateData);

        // Handle secret separately using fill to trigger the setter
        if ($request->filled('pusher_secret')) {
            $settings->fill(['pusher_secret' => $request->pusher_secret]);
        }

        $settings->save();

        return redirect()->route('admin.notification-settings.index')
            ->with('success', 'Notification settings updated successfully!');
    }

    /**
     * Test Pusher connection.
     */
    public function testConnection(Request $request)
    {

        // Temporarily update settings with form values for testing
        $settings = NotificationSetting::getSettings();
        $originalSettings = [
            'pusher_app_id' => $settings->pusher_app_id,
            'pusher_key' => $settings->pusher_key,
            'pusher_secret' => $settings->pusher_secret,
            'pusher_cluster' => $settings->pusher_cluster,
            'is_enabled' => $settings->is_enabled,
        ];

        try {
            // Temporarily set form values for testing (create a temporary settings object)
            $tempSettings = new NotificationSetting();
            $tempData = [
                'pusher_app_id' => $request->input('pusher_app_id', $settings->pusher_app_id),
                'pusher_key' => $request->input('pusher_key', $settings->pusher_key),
                'pusher_cluster' => $request->input('pusher_cluster', $settings->pusher_cluster ?? 'ap2'),
                'is_enabled' => $request->input('is_enabled') == '1' || $request->input('is_enabled') === true,
            ];

            if ($request->filled('pusher_secret')) {
                $tempData['pusher_secret'] = $request->pusher_secret;
            } else {
                // Use existing encrypted secret from database (don't decrypt, just copy)
                $tempSettings->setAttribute('pusher_secret', $settings->pusher_secret);
            }

            $tempSettings->fill($tempData);

            // Temporarily replace settings
            $this->pusherService->setTemporarySettings($tempSettings);

            // Reset Pusher instance to use new settings
            $this->pusherService->resetInstance();

            $result = $this->pusherService->testConnection();

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('NotificationSettingsController: Test connection exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Test failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get Pusher config for frontend (API).
     */
    public function getConfig()
    {
        $config = $this->pusherService->getConfigForFrontend();

        return response()->json($config);
    }
}
