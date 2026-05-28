<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('backend.index');
    }
    public function table()
    {
        return view('backend.table');
    }
    public function sql()
    {
        return view('backend.sql');
    }
    public function operation()
    {
        return view('backend.operation');
    }


}