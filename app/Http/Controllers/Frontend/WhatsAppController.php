<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\WhatsAppChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    /**
     * Handle WhatsApp click and redirect
     */
    public function redirect(Request $request)
    {
        $phone = Setting::get('whatsapp_phone', '');
        $message = Setting::get('whatsapp_message', 'Hello! I need help with my order.');
        $chatEnabled = Setting::get('whatsapp_chat_enabled', false);

        // Log the click
        $this->logWhatsAppClick($request);

        if (!$phone) {
            return redirect()->back()->with('error', 'WhatsApp is not configured yet.');
        }

        // If chat is enabled, show chat form instead of direct redirect
        if ($chatEnabled) {
            return view('frontend.whatsapp.chat', compact('phone', 'message'));
        }

        // Direct redirect to WhatsApp
        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/{$phone}?text={$encodedMessage}";

        return redirect()->away($whatsappUrl);
    }

    /**
     * Send a chat message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'customer_name' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $chatEnabled = Setting::get('whatsapp_chat_enabled', false);

        if (!$chatEnabled) {
            return response()->json(['error' => 'WhatsApp chat is not enabled.'], 403);
        }

        // Create chat record
        WhatsAppChat::create([
            'phone_number' => $request->phone_number,
            'customer_name' => $request->customer_name,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent. We will get back to you soon!'
        ]);
    }

    /**
     * Get WhatsApp settings for frontend
     */
    public function getSettings()
    {
        $settings = [
            'enabled' => Setting::get('whatsapp_enabled', false),
            'phone' => Setting::get('whatsapp_phone', ''),
            'message' => Setting::get('whatsapp_message', ''),
            'chat_enabled' => Setting::get('whatsapp_chat_enabled', false),
        ];

        return response()->json($settings);
    }

    /**
     * Log WhatsApp click for analytics
     */
    private function logWhatsAppClick(Request $request)
    {
        // For now, we'll just log to Laravel logs
        // In a real implementation, you might want to create a whatsapp_logs table
        // and store user_id, page_url, etc.

        $logData = [
            'user_id' => Auth::id(),
            'page_url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'timestamp' => now(),
        ];

        // Log to Laravel log file
        Log::info('WhatsApp Click', $logData);

        // If you want to store in database, uncomment and create migration:
        // \DB::table('whatsapp_logs')->insert($logData);
    }

    /**
     * Generate WhatsApp URL
     */
    public static function generateWhatsAppUrl($phone, $message = null)
    {
        if (!$phone) {
            return '#';
        }

        $encodedMessage = $message ? urlencode($message) : '';
        return "https://wa.me/{$phone}" . ($encodedMessage ? "?text={$encodedMessage}" : '');
    }
}
