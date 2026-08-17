<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MCPController extends Controller
{
    // TOOL: get users
    public function getUsers()
    {
        $users = User::select('id', 'name', 'email')->get();

        return response()->json([
            "tool" => "get_users",
            "data" => $users
        ]);
    }
}