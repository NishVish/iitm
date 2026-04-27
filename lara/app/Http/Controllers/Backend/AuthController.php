<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // 🔐 LOGIN PAGE
    public function login(Request $request)
    {
        if ($request->session()->has('user')) {
            return redirect('/backend/home');
        }

        return view('backend.login');
    }

    // 🔐 VERIFY PIN
    public function verifyPin(Request $request)
    {
        $pin = $request->input('pin');

        // ✔ check single user
        $user = DB::table('users')
            ->where('password', $pin)   // ⚠️ better use separate pin column
            ->first();

        // ❌ if not found
        if (!$user) {
            return redirect('/backend')->with('error', 'Invalid PIN');
        }

        // ✅ store only needed data
        $request->session()->put('user', $user->name); // or id

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