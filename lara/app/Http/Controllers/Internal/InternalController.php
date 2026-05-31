<?php

namespace App\Http\Controllers\Internal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InternalController extends Controller
{
    // 🔐 Show login or dashboard
    public function index()
    {
        if (session('internal_admin') == 1) {
            return view('internal.index');
        }

        return view('internal.login');
    }

    // 🔐 PIN LOGIN HANDLER
    public function login(Request $request)
    {
        $pin = $request->input('pin');

        $validPin = '1234';

        if ($pin === $validPin) {

            $user = \DB::table('users')
                ->where('id', 1)
                ->first();

            if (!$user) {
                return back()->with('error', 'No user found');
            }

            session([
                'internal_admin' => 1,
                'internal_user_id' => $user->id,
                'internal_name' => $user->name,
                'internal_role' => $user->designation ?? 'staff'
            ]);

            return redirect()->route('internal.index');
        }

        return back()->with('error', 'Invalid PIN');
    }

    // 👤 GET LOGGED IN USER (JSON)
    public function usersession()
    {
        $userId = session('internal_user_id');

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Not logged in'
            ], 401);
        }

        $user = \DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    // 🚪 LOGOUT
    public function logout()
    {
        session()->forget('internal_admin');
        session()->flush();

        return redirect()->route('internal.login');
    }

    public function pages($pages)
    {
        return view('internal.index', compact('pages'));

    }
}