<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailTestController extends Controller
{
    public function index()
    {
        return view('mail.test');
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'body' => 'required'
        ]);

        Mail::html($request->body, function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Test Mail');
        });

        return back()->with('success', 'Mail sent!');
    }
}