<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Database extends Controller
{
    public function index($state = null)
    {
        $db = \Config\Database::connect();
        
        // 1. Decode the Slug (west-bengal -> West Bengal)
        $decodedState = ($state) ? str_replace('-', ' ', urldecode($state)) : null;

        // 2. Build the main Grouped Query
        $builder = $db->table('company_data cd')
            ->select('cd.*, cs.source_id, cs.event_date, cs.notes as source_notes, c.contact_id, c.name as contact_name, c.designation, ce.email as email_address, cm.mobile as mobile_number')
            ->join('company_sources cs', 'cs.company_id = cd.company_id', 'left')
            ->join('contact c', 'c.company_id = cd.company_id', 'left')
            ->join('contact_email ce', 'ce.contact_id = c.contact_id', 'left')
            ->join('contact_mobile cm', 'cm.contact_id = c.contact_id', 'left');

        if ($decodedState) {
            $builder->where('LOWER(cd.state)', strtolower($decodedState));
        }

        $rows = $builder->get()->getResultArray();

        // 3. Grouping logic
        $grouped = [];
        foreach ($rows as $row) {
            $id = $row['company_id'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = ['details' => $row, 'contacts' => []];
            }
            if ($row['contact_id']) {
                $cId = $row['contact_id'];
                if (!isset($grouped[$id]['contacts'][$cId])) {
                    $grouped[$id]['contacts'][$cId] = [
                        'name' => $row['contact_name'],
                        'designation' => $row['designation'],
                        'emails' => [], 'mobiles' => []
                    ];
                }
                if ($row['email_address']) $grouped[$id]['contacts'][$cId]['emails'][] = $row['email_address'];
                if ($row['mobile_number']) $grouped[$id]['contacts'][$cId]['mobiles'][] = $row['mobile_number'];
            }
        }

        // 4. Manual Model-less fetches for States and Cities
        $states = $db->table('company_data')->select('state')->distinct()->orderBy('state', 'ASC')->get()->getResultArray();
        
        $cities = [];
        if ($decodedState) {
            $cities = $db->table('company_data')->select('city')->where('state', $decodedState)->distinct()->orderBy('city', 'ASC')->get()->getResultArray();
        }

        $data = [
            'companies' => $grouped,
            'states'    => $states, 
            'state'     => $decodedState ?? "", 
            'cities'    => $cities
        ];

        return view('database/index', $data);
    }
}