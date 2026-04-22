<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;


class BadgeController extends Controller
{
    public function badgepreview()
    {
        $alldata = [
            'contactName' => 'John Doe',
            'companyName' => 'ABC Technologies',
            'email' => 'john@example.com',
            'mobile' => '9876543210'
        ];

        $event = [
            [
                'name' => 'IITM Kolkata',
                'venue_details' => 'Kolkata Exhibition Center'
            ]
        ];

        $badge_color = '#a42627';

        return view('badge.badge', compact('alldata', 'event', 'badge_color'));
    }

public function downloadBadge(Request $request)
{
    // $email = $request->email;
    // $mobile = $request->mobile;
$mobile = 7909075199;
$email = 'nishwakarma3@gmail.com';

// dd($mobile,$email);
    $database = new DatabaseController();

$contactid = DB::table('contact_email as e')
    ->join('contact_mobile as m', 'e.contact_id', '=', 'm.contact_id')
    ->where('e.email', $email)
    ->where('m.mobile', $mobile)
    ->where('e.is_primary', 1)
    ->where('m.is_primary', 1)
    ->value('e.contact_id');

// fallback if not found
if (!$contactid) {
    $contactid = DB::table('contact_mobile')
        ->where('mobile', $mobile)
        ->value('contact_id');
}// dd($contactid);
    $contactdata = DB::table('contact')
        ->where('contact_id', $contactid)
        ->first();

    $companyData = null;
    if (!empty($contactdata->company_id)) {
        $companyData = DB::table('company_data')
            ->where('company_id', $contactdata->company_id)
            ->first();
    }

    $mobileRecord = DB::table('contact_mobile')
        ->where('contact_id', $contactid)
        ->where('is_primary', 1)
        ->first();

    $emailRecord = DB::table('contact_email')
        ->where('contact_id', $contactid)
        ->where('is_primary', 1)
        ->first();

    return view('web.registration.successpage.badge', compact('email', 'mobile'));
}

public function generatebadge($company_id, $contact_id, $db)
{
    // $company_id = 'CMP_69e8618721e5b';     
    $contactdatafromcompanyid=  DB::table('contact')->where('company_id', $company_id)->first();
    
    // dd($contactdatafromcompanyid);
    $contactid= $contactdatafromcompanyid->contact_id;// contact details
    // company details whre entrytype = online reingstionra latest wher db = db
   $contactdata= DB::table('contact')->where('contact_id', $contact_id)->first();
   $companydata= DB::table('company_data')->where('company_id', $company_id)->first();
    
   
   $nosuccespage = true;
    $data = [
        'company_id' => $company_id,
        'contact_id' => $contact_id,
'contactName' => $contactdatafromcompanyid->name,
        'email' => $email ?? 'marketing1@iitmindia.com',
        'mobile' => $mobile ?? '7909075199',
        'companyName' => $companydata->company_name ?? 'ABC Technologies',
        'emailpage'=>false,

        'db' => $db,
        'print' => true,
        'preview' => true

    ];
    // dd($data);
return view('web.registration.success', compact('data','nosuccespage'));
}

}