<?php

namespace App\Http\Controllers\Ai;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiController extends Controller
{


    public function questionanswer()
    {
        return view('ai.questionanswer');
    }
}