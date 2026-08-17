<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

abstract class Controller
{
    public function __construct()
    {
        echo "HeloHeloo";
    }

    public function databasequery($query, $bindings = [])
    {
        return DB::select($query, $bindings);
    }
}