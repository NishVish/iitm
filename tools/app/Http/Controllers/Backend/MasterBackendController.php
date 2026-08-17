<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterBackendController extends Controller
{
    // 🔹 MAIN PAGE
    public function index(Request $request)
    {
        // 🔐 If no PIN → show login
        if (!$request->session()->has('backend_pin')) {
            return view('backend.masterbackend', [
                'screen' => 'pin'
            ]);
        }

        // 👥 If logged in → show users
        $users = DB::table('users')->latest()->get();

        return view('backend.masterbackend', [
            'screen' => 'dashboard',
            'users' => $users
        ]);
    }

    // 🔐 CHECK PIN
    public function checkPin(Request $request)
    {
        if ($request->pin == "1234") {

            $request->session()->put('backend_pin', true);

            return redirect('/masterbackend');
        }

        return back()->with('error', 'Invalid PIN');
    }

    // ➕ STORE USER
    public function store(Request $request)
    {
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/masterbackend');
    }

    // ✏️ UPDATE USER
    public function update(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'updated_at' => now(),
        ]);

        return redirect('/masterbackend');
    }

    // 🗑 DELETE USER
    public function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();

        return redirect('/masterbackend');
    }

    // 🔓 LOGOUT
    public function logout(Request $request)
    {
        $request->session()->forget('backend_pin');

        return redirect('/masterbackend');
    }
}