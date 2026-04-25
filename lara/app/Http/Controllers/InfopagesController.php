<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfopagesController extends Controller
{
    public function infopages()
    {
        return view("web.infopages.index");
    }
    public function contactus()
    {
        return view("web.infopages.index");
    }
    public function aboutus()
    {
        return view("web.infopages.index");
    }
    public function resourcepage()
    {
        return view("web.infopages.index");
    }
    public function gallery()
    {
        return view("web.infopages.index");
    }
}