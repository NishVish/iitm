<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
class RagController extends Controller
{
    

    public function iitmchat(){

return view('ai.iitmchat');
    }

        public function rawchat(){

return view('ai.chat');
    }

}