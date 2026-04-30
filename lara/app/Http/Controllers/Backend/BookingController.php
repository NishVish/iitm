<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DatabaseController as DatabaseControllerApp;

class BookingController extends Controller
{
    public function index()
    {
        return view("backend.bookingportal.index");
    }

    public function companydata()
    {


    }

    public function update()
    {


    }

    public function leaddata()
    {



    }



    public function payment()
    {
        return view("backend.bookingportal.index");
    }
}