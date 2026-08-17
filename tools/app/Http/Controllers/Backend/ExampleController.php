<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DatabaseController as DatabaseControllerApp;

class ExampleController extends Controller
{
    public function index()
    {


        return view("booking.review");
    }

    public function bookingprocess()
    {

        $leads = DB::table('leads')
            ->leftjoin('company_data', 'company_data.company_id', '=', 'leads.company_id')
            ->leftjoin('contact', 'contact.contact_id', '=', 'leads.contact_id')
            ->leftjoin('contact_mobile', 'contact_mobile.contact_id', '=', 'leads.contact_id')
            ->leftjoin('contact_email', 'contact_email.contact_id', '=', 'leads.contact_id')
            ->get();


        // dd($leads);

        return view('example.bookingprocess', compact('leads'));

    }


}


