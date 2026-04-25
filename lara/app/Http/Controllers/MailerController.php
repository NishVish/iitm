<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailerController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        return view('mail.test2');
    }
    public function quickmailtest2()
    {
        $headers = "From: events@iitmindia.com\r\n";
        $headers .= "Cc: nishwakarma3@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        $sent = mail('marketing1@iitmindia.com', "test", "test", $headers);
        if ($sent) {
            return back()->with('status', 'Mail Sent');
        } else {
            return back()->with('status', 'Mail Failed');
        }

    }
    public function quickmailtest($preview = false)
    {
        // dd($email, $data);
        $data = null;
        if (!$data || $data == 'xyz') {

            $data = [
                'company_id' => $newCompanyId ?? '1',
                'contact_id' => $newContactId ?? '1',
                'databasename' => $databasenew ?? '1',
                'eventname' => $eventname ?? 'IITM Kolkata 2026',
                'print' => false,
                'status' => 'success',
                'message' => 'Your registration has been successfully completed',
                'contactName' => $contactName ?? 'Nishant',
                'email' => $email ?? 'marketing1@iitmindia.com',
                'mobile' => $mobile ?? '7909075199',
                'companyName' => $companyName ?? 'ABC Technologies',
                'preview' => false,
                'emailpage' => true,
                'all_dates' => $all_dates ?? [],
                'venue' => $venue ?? '',


                'sentData' => [
                    'contactName' => $contactName ?? 'Nishant',
                    'email' => $email ?? 'marketing1@iitmindia.com',
                    'mobile' => $mobile ?? '7909075199',
                    'company_name' => $companyName ?? 'ABC Technologies',


                ],
                'dbData' => $dbData ?? [],
            ];


        }
        echo "<pre>";
        echo "thsi is Mailer Function";
        echo "thsi is data";
        print_r($data);
        echo "</pre>";


        $subject = "Registration Successful";
        if ($preview) {
            return view('emails.registration_success', compact('data'));
        }
        // dd($data);

        // ✅ render blade view into HTML string
        $html2 = view('emails.registration_success', compact('data'))->render();

        $to = 'nishwakarma3@gmail.com';

        $message = $html2;

        $headers = "From: events@iitmindia.com\r\n";
        $headers .= "Cc: harish@iitmindia.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        $sent = mail($to, $subject, $message, $headers);
        $sendtstatus = $sent ? 'Mail Sent' : 'Mail Failed';
        echo $sendtstatus;
        $this->quickmailtest2();
        exit;

    }
    public function sendRegistrationMaitest($email, $data)
    {
        $subject = "Registration Successful";

        $html2 = $data;

        $to = $email;
        $message = $html2;

        $headers = "From: events@iitmindia.com\r\n";
        $headers .= "Cc: harish@iitmindia.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        $sent = mail($to, $subject, $message, $headers);

        return back()->with([
            'status' => $sent ? 'Mail Sent' : 'Mail Failed',
            'email' => $to,
            'subject' => $subject,
            'message' => $message,
            'headers' => $headers,
            'sent' => $sent
        ]);
    }
    public function sendRegistrationMail($email, $data)
    {
        // dd($email, $data);
        if (!$data || $data == 'xyz') {

            $data = [
                'company_id' => $newCompanyId ?? '1',
                'contact_id' => $newContactId ?? '1',
                'databasename' => $databasenew ?? '1',
                'eventname' => $eventname ?? 'IITM Kolkata 2026',
                'print' => false,
                'status' => 'success',
                'message' => 'Your registration has been successfully completed',
                'contactName' => $contactName ?? 'Nishant',
                'email' => $email ?? 'marketing1@iitmindia.com',
                'mobile' => $mobile ?? '7909075199',
                'companyName' => $companyName ?? 'ABC Technologies',
                'preview' => false,
                'emailpage' => true,
                'all_dates' => $all_dates ?? [],
                'venue' => $venue ?? '',


                'sentData' => [
                    'contactName' => $contactName ?? 'Nishant',
                    'email' => $email ?? 'marketing1@iitmindia.com',
                    'mobile' => $mobile ?? '7909075199',
                    'company_name' => $companyName ?? 'ABC Technologies',


                ],
                'dbData' => $dbData ?? [],
            ];


        }
        echo "<pre>";
        echo "thsi is Mailer Function";
        echo "thsi is data";
        print_r($data);
        echo "</pre>";


        $subject = "Registration Successful";
        // return view('emails.registration_success', compact('data'));
        // dd($data);

        // ✅ render blade view into HTML string
        $html2 = view('emails.registration_success', compact('data'))->render();

        $to = $email;

        $message = $html2;

        $headers = "From: events@iitmindia.com\r\n";
        $headers .= "Cc: harish@iitmindia.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        $sent = mail($to, $subject, $message, $headers);
        $sendtstatus = $sent ? 'Mail Sent' : 'Mail Failed';
        echo $sendtstatus;
        exit;
        return back()->with('status', $sendtstatus);
    }
}