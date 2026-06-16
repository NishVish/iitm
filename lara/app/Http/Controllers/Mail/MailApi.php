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

public function sendRegistrationMail(Request $request)
{

    
    $input = $request->all();

    $data = [
        'company_id'   => $input['company_id'] ?? null,
        'contact_id'   => $input['contact_id'] ?? null,
        'databasename' => $input['databasename'] ?? null,
        'eventname'    => $input['eventname'] ?? null,

        'status'       => $input['status'] ?? 'success',
        'message'      => $input['message'] ?? '',

        'contactName'  => $input['contactName'] ?? null,
        'email'        => $input['email'] ?? null,
        'mobile'       => $input['mobile'] ?? null,
        'companyName'  => $input['companyName'] ?? null,
        'venue'        => $input['venue'] ?? null,

        // normalize checkboxes
        'print'        => $request->boolean('print'),
        'preview'      => $request->boolean('preview'),
        'emailpage'    => $request->boolean('emailpage'),

        'all_dates'    => $input['all_dates'] ?? [],
    ];

    $result = $this->mailServices->sendRegistrationMail($data);

    return view('mail.templates', compact('data'));
}


    public function send(Request $request,$type){

        dd(request->all());


    }



    public function formvalidation(Request $request){


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