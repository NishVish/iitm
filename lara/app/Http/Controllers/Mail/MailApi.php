<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\MailServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class MailApi extends Controller
{
    // Constructor injection - Laravel handles initialization automatically
    public function __construct(private MailServices $mailServices)
    {
        // No manual new instances needed inside here
    }

    public function list()
    {
        $data = [
            'general' => url("api/mail/test/general"),
            'registration' => url("api/mail/test/registration"),
            'enquiry' => url("api/mail/test/enquiry"),
            'test' => url("api/mail/test"),
        ];

        return view('mail.apis', compact('data'));
    }

    public function test()
    {
        $name = 'Nishant';
        $email = 'nishwakarma3@gmail.com';
        $template = 0;

        // Uses constructor service property
        $result = $this->mailServices->sendmail($name, $email, $template);

        return response()->json($result);
    }

    public function sendMail($type)
    {
        if ($type === 'general') {
            return $this->sendGeneralMail();
        } else if ($type === 'test') {
            return $this->test();
        }

        if ($type === 'registration') {
            return $this->sendRegistrationMail();
        }

        if ($type === 'enquiry') {
            return $this->sendEnquiryMail();
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid mail type',
        ], 400);
    }

    public function sendGeneralMail()
    {
        $name = 'Nishant';
        $email = 'nishwakarma3@gmail.com';
        $template = 0;

        // Uses constructor service property
        $this->mailServices->sendmail($name, $email, $template);
    }

    public function sendRegistrationMail()
    {
        // Placeholders fallback to avoid undefined variable faults
        $name = 'Nishant';
        $email = 'marketing1@iitmindia.com';
        $template = 1;

        $data = [
            'company_id' => 'CMP_6a2d28f2da56b',
            'contact_id' => '353320',
            'databasename' => 'iitm-chennai-2026',
            'eventname' => 'iitm-chennai-2026',
            // /353320/
            'print' => false,
            'status' => 'success',
            'message' => 'Your registration has been successfully completed',

            'contactName' => 'Nishant',
            'email' => 'nishwakarma3@gmail.com',
            'mobile' => '7909075199',
            'companyName' => 'ABC Technologies',

            'preview' => false,
            'emailpage' => true,
            'all_dates' => [],
            'venue' => 'Abcd Parkway',

            'sentData' => [
                'contactName' => 'Nishant',
                'email' => 'nishwakarma3@gmail.com',
                'mobile' => '7909075199',
                'company_name' => 'ABC Technologies',
            ],

            'dbData' => [],
        ];

        // Uses constructor service property
        $result = $this->mailServices->sendRegistrationMail($data);

        return view('mail.templates', compact('data'));
    }

    public function sendEnquiryMail()
    {
        return view('mail.templates');
    }

    public function hello()
    {
        return response()->json([
            'message' => 'Hello World',
        ]);
    }

    public function massmailtest(Request $request)
    {
        $data = [
            [
                'name' => 'Nishanth',
                'email' => 'nishwakarma3@gmail.com',
            ],
            [
                'name' => 'Subash',
                'email' => 'marketing1@iitmindia.com',
            ]
        ];

        $response = Http::asJson()->post(url('/api/massmail'), [
            'recipients' => $data,
            'subject' => 'Test Mass Mail',
            'message' => 'This is a test message.'
        ]);

        dd($response->body());
    }

    public function massmail(Request $request)
    {
        $request->validate([
            'recipients' => 'required|array|min:1',
            'recipients.*.email' => 'required|email',
            'recipients.*.name' => 'nullable|string',
        ]);

        foreach ($request->recipients as $recipient) {

            $name = $recipient['name'] ?? '';
            $email = $recipient['email'];

            // echo $recipient;
            // echo "<br>";

            $this->mailServices->sendmail($name, $email, 0);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mass mail processed successfully'
        ]);
    }
}