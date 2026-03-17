<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


public function userdata()

{

    $contact = session('contact');
    $company = session('company');
return response()->json([
    'status' => 'success',
    'contact' => $contact,
    'company' => $company
]);


}





}
