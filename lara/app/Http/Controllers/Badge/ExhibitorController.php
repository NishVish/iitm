<?php

namespace App\Http\Controllers\Badge;

use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class ExhibitorController extends Controller
{


    public function index($id)
    {
        $data = $this->returndata($id);
        return view('showdata.index', compact('data'));
    }
    public function secret($id)
    {
        $data = $this->returndata($id);
        return view('showdata.secret', compact('data'));
    }
    // Controller
    public function returndata($id)
    {
        $db = DB::connection('special_db');
        $data = null;

        // 1. Try first table: tradevisitor (on special_db)
        $data = $db->table('tradevisitor')
            ->where('person_key', $id)
            ->first();
        if ($data) {

            $data->dbname = "iitm_form_data";
            $data->tablename = "tradevisitor";

        }
        // 3. Try third table: exhibitor (on special_db)
        if (!$data) {
            $data = $db->table('exhibitor')
                ->where('person_key', $id)
                ->first();
            if ($data) {

                $data->dbname = "iitm_form_data";
                $data->tablename = "exhibitor";

            }
        }
        // dd($data);

        // 2. Try second table: tradev (on special_db)
        if (!$data) {
            $db2 = DB::connection('special_db2');

            $data = $db2->table('tradev')
                ->where('id', $id)
                ->first();

            if ($data) {

                $data->dbname = "iitminda_iitmindia_2024";
                $data->tablename = "tradev";

            }

        }



        // 4. Try fourth table: exhibitor2025 (on special_db2 via 'id')
        if (!$data) {
            $db2 = DB::connection('special_db2');
            $data = $db2->table('exhibitor2025')
                ->where('id', $id)
                ->first();

            if ($data) {

                $data->dbname = "iitminda_iitmindia_2024";
                $data->tablename = "exhibitor2025";

            }
        }

        // 5. If data is still missing after all checks, fail immediately before normalizing
        if (!$data) {
            abort(404, 'Visitor or Exhibitor data not found.');
        }

        // =========================================================================
        // GLOBAL DATA MAPPING HELPER (Runs on the found record from any table)
        // =========================================================================

        // A. Fix spelling and schema variants for Organization/Company Name
        if (empty($data->company_name) || $data->company_name === 'N/A') {
            $data->company_name = $data->organisation ?? $data->organization ?? $data->company ?? 'N/A';
        }

        // B. Combine title/salutation with name field if separate
        if (!empty($data->select2)) {
            $data->name = trim($data->select2 . ' ' . $data->name);
        }

        // C. Check if mobile field is empty, null, or missing, and fallback to phone
        if (empty($data->mobile) || $data->mobile === 'N/A') {
            $data->mobile = $data->phone ?? 'N/A';
        }

        // D. Safe conversion fallback for missing person_key identifiers (e.g. from ID)
        if (empty($data->person_key)) {
            $data->person_key = $data->id ?? null;
        }

        if ($data->verification == 0) {

            $data->allowedit = 1;

            if ($data->dbname == "iitminda_iitmindia_2024") {

                $db2 = DB::connection('special_db2');

                $db2->table($data->tablename)
                    ->where('id', $id)
                    ->update([
                        'verification' => 1
                    ]);

            } else {

                $db2 = DB::connection('special_db');

                $db2->table($data->tablename)
                    ->where('person_key', $id)
                    ->update([
                        'verification' => 1
                    ]);
            }

        } else {

            $data->allowedit = 0;

        }

        // dd($data);
        return $data;
    }






    // Controller
    public function vcard($key)
    {

        $db = DB::connection('special_db');

        $data = $db->table('tradevisitor')
            ->where('person_key', $key)
            ->first();
        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:{$data->name}\r\n";
        $vcard .= "N:{$data->name};;;;\r\n";
        $vcard .= "ORG:{$data->company_name}\r\n";
        $vcard .= "TITLE:{$data->designation}\r\n";
        $vcard .= "TEL;TYPE=CELL:{$data->mobile}\r\n";
        $vcard .= "EMAIL:{$data->email}\r\n";
        $vcard .= "END:VCARD\r\n";

        return response($vcard, 200)
            ->header('Content-Type', 'text/vcard; charset=utf-8')
            ->header('Content-Disposition', 'inline; filename="' . $data->name . '.vcf"');
    }
    public function save(Request $request)
    {
        $db = DB::connection('special_db');

        $db->table('tradevisitor')
            ->where('person_key', $request->person_key)
            ->update([
                'bag_collected' => 1
            ]);

        return back();
    }

    public function editdata(Request $request)
    {
        if ($request->db_name == "iitminda_iitmindia_2024") {

            $db = DB::connection('special_db2');

            if ($request->table_name == "tradev") {

                $db->table('tradev')
                    ->where('id', $request->person_key)
                    ->update([
                        'select2' => $request->name,
                        'name' => null,
                        'designation' => $request->designation,
                        'organisation' => $request->company_name,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'phone' => $request->mobile,
                    ]);

            } elseif ($request->table_name == "exhibitor") {

                $db->table('exhibitor')
                    ->where('person_key', $request->person_key)
                    ->update([
                        'name' => $request->name,
                        'designation' => $request->designation,
                        'company_name' => $request->company_name,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                    ]);

            }

        } else {

            $db = DB::connection('special_db');

            $db->table($request->table_name)
                ->where('person_key', $request->person_key)
                ->update([
                    'name' => $request->name,
                    'designation' => $request->designation,
                    'company_name' => $request->company_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                ]);

        }

        return back()->with('success', 'Visitor details updated successfully');
    }

}