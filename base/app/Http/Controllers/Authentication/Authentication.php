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

    public function login()
    {
        return view('auth.login');
    }

    public function verifyUser(Request $request)
    {
        session()->put('usertype', 'admin');

        return redirect(url('/dashboard'));
    }

}
