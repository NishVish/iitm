<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AlldetailsModel;

class Search extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $search = trim($this->request->getGet('q'));

        // If empty search, return empty result (prevents full DB scan)
        if (empty($search)) {
            return view('search_results', ['results' => []]);
        }

       $serachModel = new AlldetailsModel;


        // $query = $builder->get();
        $results = $serachModel->search($search);

        return view('search/results', [
            'results' => $results,
            'search'  => $search
        ]);
    }
}