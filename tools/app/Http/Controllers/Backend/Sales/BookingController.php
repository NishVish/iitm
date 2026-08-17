<?php

namespace App\Http\Controllers\Backend\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\DatabaseController;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // $bookingid = $request->id;
        // $mobile =$request->mobile
        // $lead = DB::table('leads')->where('lead_id', 21)->first();
        // // dd($lead);
        return view('booking.enterbookingid');
        return view('booking.index');
    }

}