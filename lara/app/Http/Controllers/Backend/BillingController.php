<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\backend\sales\leadcontroller;


class BillingController extends Controller
{

    public function invoice($id = null)
    {
        $lead = new leadcontroller;
        return $lead->getdetails($id, 'invoice');
    }
    public function performa($id = null)
    {
        $lead = new leadcontroller;
        return $lead->getdetails($id, 'performa');
    }

}