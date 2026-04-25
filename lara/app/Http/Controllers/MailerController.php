<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailerController extends Controller
{
    public function index()
    {
        return view('mail.test2');
    }
    public function sendRegistrationMail(Request $request)
    {
        $email = $request->email;
        $subject = "Registration Successful";

        // ✅ render blade view into HTML string
        $html2 = view('emails.registration_success', [
            'email' => $email
        ])->render();

        $to = "marketing1@iitmindia.com";

        $message = $html2;

        $headers = "From: events@iitmindia.com\r\n";
        $headers .= "Cc: harish@iitmindia.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        $sent = mail($to, $subject, $message, $headers);

        return back()->with('status', $sent ? 'Mail Sent' : 'Mail Failed');
    }
}