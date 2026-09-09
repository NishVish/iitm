<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;


class Authentication extends Controller
{

    public function exhibitorlogin()
    {
        return view('auth.login');
    }
    public function saleslogin()
    {
        return view('auth.login');
    }
    public function verifyExhibitor(Request $request)
    {
        // session()->put('usertype', 'exhibitor');
        // session()->put('booking_id', $request->booking_id);

        // CF45604BC
        return redirect(url('/exhibitor/dashboard/BKEFLHFVVLVQ'));
    }
    public function verifyUser(Request $request)
    {
        session()->put('usertype', 'admin');

        return redirect(url('/dashboard'));
    }

}
