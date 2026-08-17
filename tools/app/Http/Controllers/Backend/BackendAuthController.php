<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackendAuthController extends Controller
{
    // 🔐 LOGIN PAGE
    public function login(Request $request)
    {
        $urlsegment = request()->segment(1);
        // dd($urlsegment);



        if ($request->session()->has('user')) {


            if ($urlsegment == "salesportal") {
                return view('backend/sales/index');
            }

            return redirect('/backend/home');
        }


        return view('backend.login');
    }

    // 🔐 VERIFY PIN
    public function verifyPin(Request $request)
    {
        $pin = $request->input('pin');
        // dd($pin);

        // ✔ check single user
        $user = DB::table('users')
            ->where('password', $pin)   // ⚠️ better use separate pin column
            ->first();
        // dd($user);
        $allusers = DB::table('users')->get();
        // dd($allusers);

        // ❌ if not found
        if (!$user) {
            return redirect('/backend')->with('error', 'Invalid PIN');
        }

        // ✅ store only needed data
        $request->session()->put('user', $user); // or id
        // dd(session()->all());
        echo "<pre>";
        print_r(session()->all());
        echo "</pre>";
        // die;

        return redirect('/backend/home');
    }

    // 🏠 HOME
    public function home(Request $request)
    {
        if (!$request->session()->has('user')) {
            return redirect('/backend');
        }

        $sessiondata = session()->all();
        // dd($sessiondata);

        return view('backend.index', [
            'sessiondata' => $sessiondata
        ]);
    }
}