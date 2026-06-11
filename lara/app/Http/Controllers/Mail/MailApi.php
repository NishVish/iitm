<?php

namespace App\Http\Controllers\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\MailingController;
use App\Http\Controllers\Mail\MailServices;
use Illuminate\Validation\Rules\Email;


class MailApi extends Controller
{


    public function sendmail($name, $email, $template)
    {

        $mailServices = new MailServices();
        $mailServices->sendmail($name, $email, $template);


    }
    public function hello()
    {


    }

    public function test()
    {
        // echo "calling Test Api";

        $mailServices = new MailServices();

        $mailServices->sendmail("nishant", "nishwakarma3@gmail.com", 0);

        return json_encode([
            "status" => true,
            "to" => "nishant",
            "email" => "nishwakarma3@gmail.com",
            "templateid" => 0,
            "message" => "Mail Sent"
        ]);

    }

}