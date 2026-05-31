<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Mail\MailController;

class MailingController extends Controller
{
    public function massmailing(Request $request)
    {

        $templateId = $request->template_id;

        // Decode JSON mail_data
        $mailData = json_decode($request->mail_data, true);

        // Optional extra fields
        $location = $request->location;
        $promotionName = $request->promotion_name;
        $userName = $request->user_name;

        // Mail controller instance
        $sendmail = new MailController();

        // Loop through each user
        foreach ($mailData as $item) {

            $currentName = $item['name'] ?? '';

            $emails = $item['emails'] ?? [];

            // Loop through emails
            foreach ($emails as $email) {

                $sendmail->sendmail(
                    $currentName,
                    $email,
                    $templateId
                );
                return redirect()->route('mailgateway', [
                    'name' => $currentName,
                    'email' => $email,
                    'template' => $templateId
                ]);
                // Optional log
                \Log::info("Mail Sent", [
                    'name' => $currentName,
                    'email' => $email,
                    'template' => $templateId
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Mass mailing completed'
        ]);
    }


    // public function mailgateway()
    public function mailgateway($name, $email, $template)
    {

        return view("mail.templates", compact("name", "email", "template"));

        // dd($name, $email, $template);
    }

    public function sender(Request $request, $type)
    {
        $name = "Nishant";
        $email = "1";
        $template = "0";

        return view("mail.sender", compact("name", "email", "template"));
    }
}