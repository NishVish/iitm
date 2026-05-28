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

    public function knowledge()
    {


        // // 📚 Recommended Database Design
// // ✅ 1. Main Table: knowledge_articles

        // // This stores every training / SOP / guide.

        // // CREATE TABLE knowledge_articles (
// //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

        // //     title VARCHAR(255) NOT NULL,
// //     slug VARCHAR(255) UNIQUE,

        // //     category VARCHAR(100), 
// //     -- sales, hotel, payment, volunteer, onboarding, etc.

        // //     content LONGTEXT,
// //     -- main text / HTML content

        // //     content_type VARCHAR(50) DEFAULT 'text',
// //     -- text | mixed | video | pdf | guide

        // //     cover_image VARCHAR(255) NULL,

        // //     created_by BIGINT UNSIGNED NULL,

        // //     is_published TINYINT(1) DEFAULT 1,

        // //     created_at TIMESTAMP NULL,
// //     updated_at TIMESTAMP NULL
// // );
// // 📎 2. Media Table (VERY IMPORTANT)

        // // Because one article can have multiple files/videos/images.

        // // CREATE TABLE knowledge_media (
// //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

        // //     article_id BIGINT UNSIGNED,

        // //     media_type VARCHAR(50),
// //     -- image | video | pdf | link

        // //     media_url TEXT,

        // //     title VARCHAR(255) NULL,

        // //     created_at TIMESTAMP NULL,

        // //     FOREIGN KEY (article_id)
// //         REFERENCES knowledge_articles(id)
// //         ON DELETE CASCADE
// // );
// // 🧠 3. Optional (Advanced but powerful)
// // Categories Table
// // CREATE TABLE knowledge_categories (
// //     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
// //     name VARCHAR(100),
// //     slug VARCHAR(100)
// // );

        //         pdf,text, link,video,images


    }
}