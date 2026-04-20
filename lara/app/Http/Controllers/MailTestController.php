<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailTestController extends Controller
{
    public function index()
    {
        $smtp = [
            'mailer' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'username' => config('mail.mailers.smtp.username'),
            'from_address' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
        ];

        return view('mail.test', compact('smtp'));
    }

    public function send(Request $request)
    {
        // 🔍 Log incoming request
        Log::info('Mail Test Request', $request->all());

        try {
            // ✅ Validate
            $validated = $request->validate([
                'email' => 'required|email',
                'body' => 'required'
            ]);

            // 🔍 Dump data (optional - comment if not needed)
            // dd($validated);

            // ✅ Send mail
            Mail::html($validated['body'], function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Test Mail Debug');
            });

            // 🔍 Log success
            Log::info('Mail sent successfully to: ' . $validated['email']);

            return back()->with([
                'success' => 'Mail sent successfully!',
                'debug' => $validated
            ]);

        } catch (\Exception $e) {

            // ❌ Log error
            Log::error('Mail sending failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with([
                'error' => 'Mail failed: ' . $e->getMessage()
            ]);
        }
    }
}