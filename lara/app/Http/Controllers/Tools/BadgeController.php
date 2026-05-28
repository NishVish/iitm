<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BadgeController extends Controller
{
    /**
     * 1. THE NAVIGATION
     */
    public function index()
    {
        return view('tools.badgesystem.interface');
    }


    public function showBadges()
    {

    }

    public function getDataforbadge($input = null)
    {

        if ($input == null) {
            $input = '7909075195';
        }

        $mobiledata = DB::table('contact_mobile')->where('mobile', $input)->first();
        $contact = DB::table('contact')->where('contact_id', $mobiledata->contact_id)->first();

        return response()->json($contact);
        // return view('tools.badgesystem.interface', compact('contact'));
    }

    public function badgescanner($id = null)
    {

        if ($id == null) {
            return view('tools.badgesystem.home');
        }

        return view('tools.badgescanner.' . $id);
    }

    public function decodeqrcode(Request $request, $id)
    {

        dd($request->all());
        $qr = $request->qr;

        // decode URL encoded vCard
        $qr = urldecode($qr);

        $data = [];

        if (str_contains($qr, 'BEGIN:VCARD')) {

            preg_match('/FN:(.*)/', $qr, $name);
            preg_match('/ORG:(.*)/', $qr, $org);
            preg_match('/TEL.*:(.*)/', $qr, $phone);
            preg_match('/EMAIL:(.*)/', $qr, $email);

            $data = [
                'name' => $name[1] ?? null,
                'company' => $org[1] ?? null,
                'mobile' => $phone[1] ?? null,
                'email' => $email[1] ?? null,
            ];
        }

        // OPTIONAL: match DB contact
        // $contact = DB::table('contact')
        //     ->where('mobile', $data['mobile'] ?? null)
        //     ->first();

        // return response()->json([
        //     'scanned' => $data,
        //     'db_match' => $contact
        // ]);

        $name = $name[1] ?? null;
        $org = $org[1] ?? null;
        $phone = $phone[1] ?? null;
        $email = $email[1] ?? null;

        // fallback dummy data if QR is empty
        $data = [
            'name' => $name ?? 'Nishant Vishwakarma',
            'company' => $org ?? 'Company & Business Interests',
            'mobile' => $phone ?? '7909075195',
            'email' => $email ?? 'nishant@example.com',
        ];

        // dummy DB match if nothing found
        $contact = $contact ?? [
            'id' => 1,
            'name' => 'Nishant Vishwakarma',
            'company' => 'Company & Business Interests',
            'mobile' => '7909075195',
            'email' => 'nishant@example.com'
        ];

        return response()->json([
            'scanned' => $data,
            'db_match' => $contact
        ]);


    }


    public function badgeprinter($id)
    {
        return view('tools.badgeprinter.' . $id);
    }

    public function gettheontect($id = null, $query = null)
    {
        $data = [
            'name' => 'Nishant Vishwakarma',
            'company' => 'Company & Business Interests',
            'mobile' => '7909075195',
            'email' => 'nishant@example.com',
        ];

        $contact = (object) $data;

        return response()->json([
            'scanned' => $data,
            'id' => $id,
            'db_match' => $contact
        ]);
        // treat query as mobile or search key
        $mobile = $query;

        // try DB lookup
        $contact = DB::table('contact')
            ->where('mobile', $mobile)
            ->first();

        // if found in DB
        if ($contact) {
            $data = [
                'name' => $contact->name,
                'company' => $contact->company,
                'mobile' => $contact->mobile,
                'email' => $contact->email,
            ];
        } else {
            // fallback dummy data
            $data = [
                'name' => 'Nishant Vishwakarma',
                'company' => 'Company & Business Interests',
                'mobile' => '7909075195',
                'email' => 'nishant@example.com',
            ];

            $contact = (object) $data;

        }

        return response()->json([
            'scanned' => $data,
            'db_match' => $contact
        ]);
    }


}