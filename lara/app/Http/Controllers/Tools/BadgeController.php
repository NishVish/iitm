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


}