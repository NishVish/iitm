<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    public function index(Request $request)
    {
        dd($request->all());
    }
}