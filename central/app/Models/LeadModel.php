<?php
namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model
{
    protected $table = 'leads';
    protected $primaryKey = 'lead_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'lead_id',
        'company_id',
        'exhibition_year',
        'location',
        'size',
        'fascia',
        'stall_location',
        'price',
        'sales_person',
        'exhibitor',
        'status',
        'payment_status'
    ];

    protected $db;

    public function getByCompanyId($companyId)
    {
        return $this->where('company_id', $companyId)->findAll();
    }

    

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Total leads/bookings
    public function getTotalLeads()
    {
        return $this->db->table($this->table)->countAllResults();
    }

    // Payment summary
    public function getPaymentSummary()
    {
        $builder = $this->db->table($this->table);
        $builder->select('payment_status, COUNT(*) as total, SUM(price) as total_amount');
        $builder->groupBy('payment_status');
        return $builder->get()->getResult();
    }

    public function filterLeads($location = null, $year = null, $salesPerson = null)
    {
        if ($location) {
            $this->where('location', $location);
        }

        if ($year) {
            $this->where('exhibition_year', $year);
        }

        if ($salesPerson) {
            $this->where('sales_person', $salesPerson);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getLocations()
{
    return $this->select('location')
                ->distinct()
                ->where('location IS NOT NULL')
                ->orderBy('location')
                ->findAll();
}

public function getYears()
{
    return $this->select('exhibition_year')
                ->distinct()
                ->where('exhibition_year IS NOT NULL')
                ->orderBy('exhibition_year', 'DESC')
                ->findAll();
}

public function getSalesPersons()
{
    return $this->select('sales_person')
                ->distinct()
                ->where('sales_person IS NOT NULL')
                ->orderBy('sales_person')
                ->findAll();
}

}
