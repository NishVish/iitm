<?php

namespace App\Http\Controllers\Whatsapp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappServices
{
    /**
     * Send simple text message
     */
    public function sendMessage($to, $message)
    {
        try {
            $token = env('WHATSAPP_TOKEN');
            $phoneId = env('WHATSAPP_PHONE_ID');

            $response = Http::withToken($token)->post(
                "https://graph.facebook.com/v19.0/{$phoneId}/messages",
                [
                    "messaging_product" => "whatsapp",
                    "to" => $to,
                    "type" => "text",
                    "text" => [
                        "body" => $message
                    ]
                ]
            );

            Log::info('WhatsApp message sent', [
                'to' => $to,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'error' => $e->getMessage(),
                'to' => $to
            ]);

            return false;
        }
    }

    /**
     * Format message safely (future-proof)
     */
    public function formatMessage($text)
    {
        return trim($text);
    }
}