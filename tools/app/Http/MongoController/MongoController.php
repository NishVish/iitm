<?php

namespace App\Http\MongoController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MongoController extends Controller
{
    public function index()
    {
        $cursor = DB::connection('mongodb')
            ->getCollection('companies')
            ->find();

        $data = [];

        foreach ($cursor as $item) {

            $companyName = $item->company_details->company_name ?? '';
            $address = $item->company_details->address ?? '';

            $contacts = [];

            if (isset($item->contacts)) {
                foreach ($item->contacts as $c) {
                    $contacts[] = [
                        'name' => $c->name ?? '',
                        'designation' => $c->designation ?? '',
                        'priority' => $c->priority ?? 0,
                        'is_decision_maker' => $c->is_decision_maker ?? false,
                        'mobiles' => isset($c->mobiles) ? (array) $c->mobiles : [],
                        'emails' => isset($c->emails) ? (array) $c->emails : [],
                    ];
                }
            }

            $data[] = [
                '_id' => (string) $item->_id,
                'company_name' => $companyName,
                'address' => $address,
                'contacts' => $contacts,

                'created_at' => isset($item->created_at)
                    ? (is_string($item->created_at)
                        ? $item->created_at
                        : json_encode($item->created_at))
                    : '',
            ];
        }

        return view('central_database.index', compact('data'));
    }

    public function store(Request $request)
    {
        DB::connection('mongodb')
            ->getCollection('companies')
            ->insertOne([
                'entry_type' => 'company',

                'company_details' => [
                    'company_name' => $request->company_name,
                    'address' => $request->address,
                ],

                'contacts' => [
                    [
                        'name' => $request->contact_name,
                        'designation' => $request->designation,
                        'priority' => (int) $request->priority,
                        'is_decision_maker' => $request->priority == 1,
                        'mobiles' => explode(',', $request->mobiles),
                        'emails' => explode(',', $request->emails),
                    ]
                ],

                'created_at' => now()
            ]);

        return redirect('/mongo')->with('success', 'Company added!');
    }
}