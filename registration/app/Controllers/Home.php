<?php

namespace App\Controllers;
use App\Models\TradevModel;

class Home extends BaseController
{
    protected $tradevModel;

    public function __construct()
    {
        $this->tradevModel = new TradevModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Total number of entries
        $totalEntries = $this->tradevModel->countAllResults();

        // Entries grouped by country
        $entriesByCountry = $this->tradevModel
            ->select('country, COUNT(*) as total')
            ->groupBy('country')
            ->findAll();

        // Entries grouped by city
        $entriesByCity = $this->tradevModel
            ->select('city_name, COUNT(*) as total')
            ->groupBy('city_name')
            ->findAll();

        $data = [
            'totalEntries' => $totalEntries,
            'entriesByCountry' => $entriesByCountry,
            'entriesByCity' => $entriesByCity
        ];

        return view('index', $data);
    }
}