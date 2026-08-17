<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class HomeController extends Controller
{
    public function index()
    {


        return view('home.index');
    }
}