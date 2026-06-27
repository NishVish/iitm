<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Registration\RegistrationServices;
use Illuminate\Support\Facades\DB;

class RegistrationApi extends Controller
{
    protected $service;

    public function __construct(RegistrationServices $service)
    {
        $this->service = $service;
    }



    public function last()
    {

        $result = $this->service->getLast10Exhibitors();


        return $result;
    }
}


