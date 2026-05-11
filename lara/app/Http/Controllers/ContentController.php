<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Http\Controllers\DatabaseController;
use Laravel\Prompts\Concerns\Events;

class ContentController extends Controller
{
    public function keyhighlights()
    {
        // read images from public/assets/key_highlights folder
        $images = glob(public_path('assets/key_highlights/*.jpg'));
        // dd($images);
        return json_encode($images);
    }
}