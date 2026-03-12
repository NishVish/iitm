<?php
namespace App\Controllers;

use App\Models\MasterModel;

class Mainmenu extends BaseController {



    public function index()
    {

    // print_r("super");
    // exit;
        return view('mainmenu/index');
    }

}