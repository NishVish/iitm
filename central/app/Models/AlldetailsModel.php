<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\LeadModel;
use App\Models\LeadLocationModel;
use App\Models\CompanyModel;
// use App\Models\LeadLocationsModel;
use App\Models\ContactModel;
use App\Models\SourceModel;
use App\Models\ContactMobileModel;
use App\Models\ContactEmailModel;

use App\Models\UpdationModel;

class AlldetailsModel extends Model
{
    // protected $leadsModel;
    // protected $locationsModel;
    // protected $contactModel;
    // protected $contactEmailModel;
    // protected $contactMobileModel;
    // protected $companySourcesModel;
    // protected $updationModel;

    public function __construct()
    {
        // $this->leadsModel = new LeadsModel();
        // $this->locationsModel = new LeadLocationsModel();
        // $this->contactModel = new ContactModel();
        // $this->contactEmailModel = new ContactEmailModel();
        // $this->contactMobileModel = new ContactMobileModel();
        // $this->companySourcesModel = new CompanySourcesModel();
        // $this->updationModel = new UpdationModel();
    }

    public function index(){
}



public function search($search)
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data c');

    // 1. Select the fields
    // Using double quotes for the separator to handle the newline correctly
    $builder->select("
        c.company_id,
        c.company_name,
        c.category,
        c.city,
        c.state,
        GROUP_CONCAT(
            DISTINCT CONCAT(
                IFNULL(co.name, 'Unknown'), ' (', IFNULL(co.designation, 'N/A'), ') - ',
                IFNULL(cm.mobile, 'N/A'), ' / ',
                IFNULL(ce.email, 'N/A')
            )
            SEPARATOR '\n'
        ) AS contacts
    ", false); // 'false' prevents CI from trying to escape the complex CONCAT string

    // 2. Joins
    // We use LEFT JOIN so companies without contacts still show up
    $builder->join('contact co', 'co.company_id = c.company_id', 'left');
    $builder->join('contact_mobile cm', 'cm.contact_id = co.contact_id AND cm.is_primary = 1', 'left');
    $builder->join('contact_email ce', 'ce.contact_id = co.contact_id AND ce.is_primary = 1', 'left');

    // 3. Search Conditions (Grouped with groupStart/groupEnd)
    if (!empty($search)) {
        $builder->groupStart()
                ->like('c.company_name', $search)
                ->orLike('c.category', $search)
                ->orLike('c.company_id', $search)
                ->orLike('c.city', $search)
                ->orLike('c.state', $search)
                ->orLike('co.name', $search)
                ->orLike('co.designation', $search)
                ->orLike('ce.email', $search)
                ->orLike('cm.mobile', $search)
                ->groupEnd();
    }

    // 4. Group By (CRITICAL FIX: Include all non-aggregated columns)
    $builder->groupBy([
        'c.company_id', 
        'c.company_name', 
        'c.category', 
        'c.city', 
        'c.state'
    ]);

    // 5. Order and Fetch
    $builder->orderBy('c.company_name', 'ASC');

    $query = $builder->get();
    return $query->getResult();
}

public function getAllCompanyDetails($source, $timerange = null)
{
    $limit = 10;

    $companyModel       = new CompanyModel();
    $leadsModel         = new LeadModel();
    $leadsLocationModel = new LeadLocationModel();
    $contactModel       = new ContactModel();
    $contactEmailModel  = new ContactEmailModel();
    $contactMobileModel = new ContactMobileModel();
    $sourceModel        = new SourceModel();
if ($source == "leads") {
    // 1️⃣ Get companies that have leads
    $company_ids = $leadsModel
                        ->select('company_id')
                        ->groupBy('company_id')
                        ->findAll($limit);

    // Extract only the company IDs
    $company_ids = array_column($company_ids, 'company_id');

    // Get company details for these IDs
    $companies = $companyModel->whereIn('company_id', $company_ids)->findAll();

} else {
    // 1️⃣ Get companies filtered by company_sources notes
    $companyModelQuery = $companyModel
                            ->join('company_sources', 'company_sources.company_id = company_data.company_id')
                            ->like('company_sources.notes', $source)
                            ->limit($limit);

    if ($timerange) {
        $companyModelQuery->where('company_sources.event_date >=', $timerange['from'])
                          ->where('company_sources.event_date <=', $timerange['to']);
    }

    $companies = $companyModelQuery->findAll();
}

// 2️⃣ Fetch leads, contacts, locations, and sources for each company
$result = [];

foreach ($companies as $company) {
    $company_id = $company['company_id'];

    // Leads
    $leads = $leadsModel->where('company_id', $company_id)->findAll();

    foreach ($leads as &$lead) {
        // Locations
        $lead['locations'] = $leadsLocationModel->where('lead_id', $lead['lead_id'])->findAll();

        // Contact details
        $contact = $contactModel->where('contact_id', $lead['contact_id'])->first();
        if ($contact) {
            $contact['emails']  = $contactEmailModel->where('contact_id', $contact['contact_id'])->findAll();
            $contact['mobiles'] = $contactMobileModel->where('contact_id', $contact['contact_id'])->findAll();
        }
        $lead['contact'] = $contact;
    }

    // Company sources with notes
    $sources = $sourceModel
                ->select('id, company_id, source_id, event_date, notes, created_at')
                ->where('company_id', $company_id)
                ->findAll();

    $result[] = [
        'company' => $company,
        'leads'   => $leads,
        'sources' => $sources
    ];
}

return $result;
}

}


// Table: company_data
// Column Name	Type	Max Length	Primary Key	Default
// id	int	11	Yes	
// company_id	varchar	50	No	
// database_name	varchar	100	No	
// outbound	tinyint	4	No	0
// company_name	varchar	255	No	
// category	varchar	100	No	
// address	text		No	
// city	varchar	100	No	
// pincode	varchar	20	No	
// state	varchar	100	No	
// country	varchar	100	No	
// phone	varchar	50	No	
// gst_number	varchar	50	No	
// sales_person	varchar	100	No	
// active_inactive	enum		No	active
// created_at	timestamp		No	current_timestamp()
// updated_at	datetime		No	
// last_confirmed_at	datetime		No	
// session	int	11	No	0
// cross_validation	tinyint	1	No	
// Table: company_data_backup

// Table: contact
// Column Name	Type	Max Length	Primary Key	Default
// contact_id	int	11	Yes	
// company_id	varchar	50	No	
// priority	tinyint	4	No	1
// name	varchar	255	No	
// designation	varchar	100	No	
// created_at	timestamp		No	current_timestamp()
// updated_at	datetime		No	
// Table: contact_email
// Column Name	Type	Max Length	Primary Key	Default
// email_id	int	11	Yes	
// contact_id	int	11	No	
// email	varchar	100	No	
// is_primary	tinyint	4	No	0
// created_at	timestamp		No	current_timestamp()
// Table: contact_mobile
// Column Name	Type	Max Length	Primary Key	Default
// mobile_id	int	11	Yes	
// contact_id	int	11	No	
// mobile	varchar	50	No	
// is_primary	tinyint	4	No	0
// created_at	timestamp		No	current_timestamp()


// Table: lead_locations
// Column Name	Type	Max Length	Primary Key	Default
// location_id	int	11	Yes	
// lead_id	int	11	No	
// location	varchar	100	No	
// stall_location	varchar	100	No	
// size	varchar	50	No	
// price	decimal	10	No	0.00
// gst_amount	decimal	10	No	0.00
// discount_amount	decimal	10	No	0.00
// grand_total	decimal	10	No	0.00
// created_at	timestamp		No	current_timestamp()
// updated_at	datetime		No	current_timestamp()



// Table: leads
// Column Name	Type	Max Length	Primary Key	Default
// lead_id	int	11	Yes	
// company_id	varchar	50	No	
// contact_id	int	11	No	
// exhibition_year	int	11	No	
// fascia	varchar	100	No	
// sales_person	varchar	100	No	
// exhibitor	varchar	255	No	
// booking_form	varchar	255	No	
// status	enum		No	draft
// payment_status	enum		No	pending
// created_at	timestamp		No	current_timestamp()
// updated_at	datetime		No	


// Table: company_sources
// Column Name	Type	Max Length	Primary Key	Default
// id	int	11	Yes	
// company_id	varchar	50	No	
// source_id	int	11	No	
// event_date	date		No	
// notes	varchar	255	No	
// created_at	timestamp		No	current_timestamp()
