<?php
namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model
{
    protected $table = 'leads';
    protected $primaryKey = 'lead_id';
    protected $returnType = 'array';

protected $allowedFields = [
    'company_id',
    'contact_id',
    'exhibition_year',
    'fascia',
    'sales_person',
    'exhibitor',
    'booking_form',
    'status',
    'payment_status'
];


    // Get Lead with all its locations
public function getLeadFullDetails($leadId)
{
    return $this->db->table('leads')
        ->select('
            leads.*,
            contact.name,
            contact.designation,
            contact.priority,
            ce.email as primary_email,
            cm.mobile as primary_mobile
        ')
        ->join('contact', 'contact.contact_id = leads.contact_id', 'left')
        ->join('contact_email ce', 'ce.contact_id = contact.contact_id AND ce.is_primary = 1', 'left')
        ->join('contact_mobile cm', 'cm.contact_id = contact.contact_id AND cm.is_primary = 1', 'left')
        ->where('leads.lead_id', $leadId)
        ->get()
        ->getRowArray();
}


public function filterLeads($location = null, $year = null, $salesPerson = null)
{
    $builder = $this->builder();

    $builder->select('
        leads.*,
        COALESCE(GROUP_CONCAT(DISTINCT lead_locations.location SEPARATOR ", "), "") as all_locations,
        contact.name as contact_name,
        contact.designation,
        ce.email as primary_email,
        cm.mobile as primary_mobile
    ');

    $builder->join('lead_locations', 'lead_locations.lead_id = leads.lead_id', 'left');
    $builder->join('contact', 'contact.contact_id = leads.contact_id', 'left');
    $builder->join('contact_email ce', 'ce.contact_id = contact.contact_id AND ce.is_primary = 1', 'left');
    $builder->join('contact_mobile cm', 'cm.contact_id = contact.contact_id AND cm.is_primary = 1', 'left');

    if ($location) {
        $builder->where('lead_locations.location', $location);
    }

    if ($year) {
        $builder->where('leads.exhibition_year', $year);
    }

    if ($salesPerson) {
        $builder->where('leads.sales_person', $salesPerson);
    }

    $builder->groupBy('leads.lead_id');
    $builder->orderBy('leads.created_at', 'DESC');

    return $builder->get()->getResultArray();
}



    // Updated to fetch distinct locations from the NEW table
    public function getLocations()
    {
        return $this->db->table('lead_locations')
                    ->select('location')
                    ->distinct()
                    ->orderBy('location')
                    ->get()->getResultArray();
    }

    // ✅ Get all leads for a company with their locations
public function getByCompanyId($companyId)
{
    return $this->select('
            leads.*,
            COALESCE(GROUP_CONCAT(DISTINCT lead_locations.location SEPARATOR ", "), "") as all_locations,
            contact.name as contact_name,
            contact.designation,
            ce.email as primary_email,
            cm.mobile as primary_mobile
        ')
        ->join('lead_locations', 'lead_locations.lead_id = leads.lead_id', 'left')
        ->join('contact', 'contact.contact_id = leads.contact_id', 'left')
        ->join('contact_email ce', 'ce.contact_id = contact.contact_id AND ce.is_primary = 1', 'left')
        ->join('contact_mobile cm', 'cm.contact_id = contact.contact_id AND cm.is_primary = 1', 'left')
        ->where('leads.company_id', $companyId)
        ->groupBy('leads.lead_id')
        ->orderBy('leads.created_at', 'DESC')
        ->findAll();
}


    public function getCompanyIdByLeadId($leadID)
    {
        return $this->select('company_id')->where('lead_id', $leadID)->first();
    }

    public function getYears()
{
    return $this->select('exhibition_year')
                ->distinct()
                ->orderBy('exhibition_year', 'DESC')
                ->findAll();
}

public function getSalesPersons()
{
    return $this->select('sales_person')
                ->distinct()
                ->orderBy('sales_person', 'ASC')
                ->findAll();
}

public function getByLeadId($leadId)
{
    return $this->where('lead_id', $leadId)->first();
}

}