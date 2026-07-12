<?php

namespace App\Http\Controllers\Tools\BadgeStation;

use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class BadgeStationController extends Controller
{


    public function index()
    {

        return view('tools.badgestation.index');

    }

    public function scanner(Request $request, $relay)
    {
        $db = DB::connection('special_db');
        $lastscanner = 0;

        if ($request->isMethod('post')) {

            $scannedqrdata = $request->scannedqrdata;
            $lastscanner = $scannedqrdata;

            $exists = $db->table('relay')
                ->where('id', $relay)
                ->exists();

            if ($exists) {

                $db->table('relay')
                    ->where('id', $relay)
                    ->update([
                        'mobilenumber' => $scannedqrdata
                    ]);

            } else {

                $db->table('relay')
                    ->insert([
                        'id' => $relay,
                        'mobilenumber' => $scannedqrdata
                    ]);

            }
        }


        return view('tools.badgestation.scanner', compact('relay', 'scannedqrdata'));
    }
    public function interface($id)
    {
        $db = DB::connection('special_db');

        $relay = $id;

        $data = $db->table('relay')
            ->where('id', $relay)
            ->first();


        return view('tools.badgestation.interface', compact('id', 'data'));

    }

    public function update(Request $request, $id)
    {
    }


    public function fetch($id)
    {
        $db = DB::connection('special_db');

        $relay = $id;

        $data = $db->table('relay')
            ->where('id', $relay)
            ->first();

        return json_encode($data->mobilenumber);
        // return view('tools.badgestation.interface', compact('relay', 'data'));
    }

}

