<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    public function index($location, $eventid)
    {
        return view('web.promotion.index', compact('location', 'eventid'));
    }

    public function list()
    {
        return view('web.promotion.index');

    }
}