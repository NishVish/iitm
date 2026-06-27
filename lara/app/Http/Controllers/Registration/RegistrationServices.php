<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationServices extends Controller
{

    public function storeOne($key, $name, $company, $location = null, $mobile, $sourcename = null, $stallNumber = null)
    {
        $db = DB::connection('special_db');

        $lastId = $db->table('exhibitor')->max('id');
        $newId = $lastId + 1;


        $db->table('exhibitor')->insert([
            'person_key' => $key,
            'name' => $name,
            'designation' => 'NA',
            'company_name' => $company,
            'address' => $stallNumber,
            'city' => $location,
            'pin' => "NA",
            'state' => $sourcename,
            'mobile' => $mobile,
            'email' => 'NA',
        ]);

        return [
            'name' => $name,
            'person_key' => $key,
        ];
    }


    function getLast10Exhibitors()
    {
        return DB::connection('special_db')
            ->table('exhibitor')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
    }

    function getexhibitordata($location, $name)
    {
        return DB::connection('special_db')
            ->table('exhibitor')
            ->where('state', $location)
            ->where('city', $name)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
    }
}