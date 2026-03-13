<?php
namespace App\Controllers;

use App\Models\MasterModel;

class Master extends BaseController {

    protected $masterModel;

    public function __construct()
    {
        // Instantiate the model
        $this->masterModel = new MasterModel();
    }

    public function index()
    {
        $data['states'] = $this->masterModel->getAllStates(); // returns unique states
        $data['cities'] = []; // empty initially
        $data['companies'] = $this->masterModel->getCompanies(); // all companies
        return view('company/index', $data);
    }

    // AJAX: get cities by state
    public function getCities()
    {
        $state = $this->request->getPost('state');
        $cities = $this->masterModel->getCitiesByState($state);
        return $this->response->setJSON($cities);
    }

    // AJAX: get companies by state & city
    public function filterCompanies()
    {
        $state = $this->request->getPost('state');
        $city = $this->request->getPost('city');
        $companies = $this->masterModel->getCompanies($state, $city);
        return $this->response->setJSON($companies);
    }
}
