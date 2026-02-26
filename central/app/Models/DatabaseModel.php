<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Models\CompanyModel;

class DatabaseModel extends Model
{
    protected $companyModel;

    public function __construct()
    {
        parent::__construct();
        $this->companyModel = new CompanyModel();
    }



    public function getCompanies($state = null, $city = null)
    {
        return $this->companyModel->getCompaniesWithContacts($state, $city);
    }

    public function getStates()
    {
        return $this->companyModel->getDistinctStates();
    }

    public function getCities($state)
    {
        return $this->companyModel->getCitiesByState($state);
    }

    public function getStateCounts()
    {
        return $this->companyModel->getCountsByStateCategory();
    }

    public function searchCompanies($search = null)
    {
        return $this->companyModel->getCompanies($search);
    }
}