<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public function add_booking()
    {



        return view('booking.index');
    }

    public function add_booking_for($companyid)
    {
        // add this company_id in stall Booking.



        return view('booking.add_booking_for', compact('companyid'));
    }

}
