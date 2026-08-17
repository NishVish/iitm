<?php

namespace App\Http\Controllers\CentralDatabase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CentralDatabase extends Controller
{
    public function index()
    {
        $url = "https://docs.google.com/spreadsheets/d/e/2PACX-1vRyYquvjV7ozS2QIKtMUF7-UyYeQ3B-ZI5pBfI6Z8K5MTZDxvYXymYQs_IroDPtDeUCRN_lqOqdgUkJ/pub?output=csv&gid=1310322485";

        $csv = file_get_contents($url);

        $rows = array_map('str_getcsv', explode("\n", trim($csv)));

        $data = [];

        foreach ($rows as $i => $row) {
            if ($i === 0)
                continue; // skip header

            $data[] = [
                'company' => $row[0] ?? null,
                'city' => $row[1] ?? null,
                'phone' => $row[2] ?? null,
                'email' => $row[3] ?? null,
            ];
        }

        return view('web.central.admin', compact('data'));
    }
}