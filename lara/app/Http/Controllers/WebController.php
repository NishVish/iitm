<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WebController extends Controller
{
    public function index()
    {
        // Correct way to return a Blade view
        return view('web.main');
    }
}