<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function index(Request $request)
    {
        // var_dump('super');
        // exit;
        // You can use the route name or path here
        $routeName = $request->route()->getName();   // home, profile, layout, calendar, etc.
        $path      = $request->path();               // mobile/home, mobile/profile, ...

        // Always return the same SPA view
        return view('mobile', [
            'routeName' => $routeName,
            'path'      => $path,
        ]);
    }
}
