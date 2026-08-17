<?php

namespace App\Http\Controllers\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\MailingController;


class MailController extends Controller
{


    public function template()
    {

        return view('mail.templates');



    }

    public function test()
    {

        return view('mail.test');
    }

    public function MassMailDashboard()
    {

        return view('mail.massmail.index');


    }
}