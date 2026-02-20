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
        MAX(contact.name) as contact_name,
        MAX(contact.designation) as designation,
        MAX(ce.email) as primary_email,
        MAX(cm.mobile) as primary_mobile
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
    $builder = $this->db->table('leads');

    $builder->select("
        leads.*,
        ll.all_locations,
        contact.name as contact_name,
        contact.designation,
        ce.email as primary_email,
        cm.mobile as primary_mobile
    ");

    // Subquery for locations (this removes need for GROUP BY in main query)
    $builder->join(
        "(SELECT lead_id, GROUP_CONCAT(DISTINCT location SEPARATOR ', ') as all_locations 
          FROM lead_locations 
          GROUP BY lead_id) ll",
        "ll.lead_id = leads.lead_id",
        "left",
        false
    );

    $builder->join('contact', 'contact.contact_id = leads.contact_id', 'left');
    $builder->join('contact_email ce', 'ce.contact_id = contact.contact_id AND ce.is_primary = 1', 'left');
    $builder->join('contact_mobile cm', 'cm.contact_id = contact.contact_id AND cm.is_primary = 1', 'left');

    $builder->where('leads.company_id', $companyId);
    $builder->orderBy('leads.created_at', 'DESC');

$leads = $builder->get()->getResultArray();

foreach ($leads as &$lead) {
    $lead['locations'] = $this->db->table('lead_locations')
        ->where('lead_id', $lead['lead_id'])
        ->get()
        ->getResultArray();
}

return $leads;
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

public function getLeadsWithContacts()
{
    $builder = $this->db->table('leads');
    $builder->select("
        leads.*,
        COALESCE(GROUP_CONCAT(DISTINCT lead_locations.location SEPARATOR ', '), '') AS all_locations,
        MAX(contact.name) AS contact_name,
        MAX(contact.designation) AS contact_designation,
        MAX(ce.email) AS primary_email,
        MAX(cm.mobile) AS primary_mobile
    ");
    $builder->join('lead_locations', 'lead_locations.lead_id = leads.lead_id', 'left');
    $builder->join('contact', 'contact.contact_id = leads.contact_id', 'left');
    $builder->join('contact_email ce', 'ce.contact_id = contact.contact_id AND ce.is_primary = 1', 'left');
    $builder->join('contact_mobile cm', 'cm.contact_id = contact.contact_id AND cm.is_primary = 1', 'left');
    $builder->groupBy('leads.lead_id');

    return $builder->get()->getResultArray();
}


}