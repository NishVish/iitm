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
        $subject = $request->subject;
        $html2 = $request->message;

        $to = $email . ", harish@iitmindia.com";

        $message = "<b>{$html2}</b>";

        $headers = "From: events@iitmindia.com\r\n";
        $headers .= "Cc: harish@iitmindia.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        $sent = mail($to, $subject, $message, $headers);

        return back()->with('status', $sent ? 'Mail Sent' : 'Mail Failed');
    }
}