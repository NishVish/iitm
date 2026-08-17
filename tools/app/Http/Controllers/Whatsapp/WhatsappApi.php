<?php

namespace App\Http\Controllers\Whatsapp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Whatsapp\WhatsappServices;

class WhatsappApi extends Controller
{
    // Webhook entry point
    public function handle(Request $request)
    {
        $data = $request->all();

        $from = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'] ?? null;
        $message = $data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'] ?? null;

        if (!$from || !$message) {
            return response()->json(['status' => 'no message']);
        }

        // Step 1: generate reply (temporary logic)
        $reply = $this->generateReply($message);

        // Step 2: send via service
        $whatsapp = new WhatsappServices();
        $whatsapp->sendMessage($from, $reply);

        return response()->json(['status' => 'ok']);
    }

    // Temporary AI / FAQ logic
    private function generateReply($message)
    {
        $message = strtolower($message);

        if (str_contains($message, 'hello')) {
            return "Hi 👋 How can I help you?";
        }

        if (str_contains($message, 'badge')) {
            return "You can collect your badge at the registration desk.";
        }

        return "Thanks for your message. We will get back to you shortly.";
    }
}


