<?php

namespace App\Http\Controllers\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\MailingController;


class MailController extends Controller
{


    public function sendmail($name, $email, $template)
    {


        $data = [
            'name' => $name,
            'email' => $email,
            'template' => $template
        ];

        dd($data);
        return redirect()->route('mailgateway', [
            'name' => $name,
            'email' => $email,
            'template' => $template
        ]);


        $mailGateway = new MailingController();
        $mailGateway->mailgateway($name, $email, $template);

        $uid = md5(uniqid(time()));

        $to = $email;
        $subject = "Registration Successful";

        $html = view('emails.registration_success', compact('data'))->render();

        $header = "From: events@iitmindia.com\r\n";
        // $header .= "Cc: harish@iitmindia.com\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/alternative; boundary=\"$uid\"\r\n";

        $body = "--$uid\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $html . "\r\n\r\n";
        $body .= "--$uid--";

        $staus = mail($to, $subject, $body, $header);
        // echo $staus;
        $sendtstatus = $staus ? 'Mail Sent' : 'Mail Failed';
    }


    public function template()
    {

        return view('mail.templates');



    }
}