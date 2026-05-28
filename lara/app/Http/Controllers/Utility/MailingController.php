<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailingController extends Controller
{
    public function massmailing(Request $request)
    {
        dd($request->all());

        $request->validate([
            'name' => 'nullable|string',
            'emails' => 'required|string',
            'template_id' => 'required|string'
        ]);

        $data = [
            'name' => $request->input('name'),
            'emails' => $request->input('emails'),
            'template_id' => $request->input('template_id'),
        ];
        // dd("hello");
    }
}