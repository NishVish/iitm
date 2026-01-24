<?php
namespace App\Controllers;
use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\UpdationModel;
use App\Models\LeadModel;
use App\Models\SourceModel;

class Company extends BaseController
{
    protected $companyModel;

    public function __construct()
    {
        $this->companyModel = new CompanyModel();
    }

    // Main page
public function index()
{
    $companies = $this->companyModel->getCompaniesWithContacts();
    $states    = $this->companyModel->getDistinctStates();

    $data = [
        'title' => 'All Companies',
        'companies' => $companies,
        'states' => $states
    ];

    return view('company/index', $data);
}


    // AJAX: get cities by state
// Company.php
public function getCities()
{
    $state = $this->request->getPost('state');
    if (!$state) {
        return $this->response->setJSON([]);
    }

    $cities = $this->companyModel->getCitiesByState($state); // use companyModel
    return $this->response->setJSON($cities);
}

    // AJAX: filter companies by state & city
public function filterCompanies()
{
    $state = $this->request->getPost('state');
    $state = ($state === '') ? null : $state;

    $city = $this->request->getPost('city');
    $city = ($city === '') ? null : $city;

    $companies = $this->companyModel->getCompaniesWithContacts($state, $city);

    return $this->response->setJSON($companies);
}


// Details of single company
public function details($companyId = null)
{
    if (!$companyId) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    $companyModel  = new CompanyModel();
    $contactModel  = new ContactModel();
    $updationModel = new UpdationModel();
    $leadModel     = new LeadModel();
    $sourceModel   = new \App\Models\SourceModel(); // Load SourceModel

    // Get main company data
    $company = $companyModel->getByCompanyId($companyId);
    if (!$company) throw new \CodeIgniter\Exceptions\PageNotFoundException('Company not found');

    // Prepare data array with sources
    $data = [
        'company'   => $company,
        'contacts'  => $contactModel->getByCompanyId($companyId),
        'updates'   => $updationModel->getByCompanyId($companyId),
        'leads'     => $leadModel->getByCompanyId($companyId),
        'sources'   => $sourceModel->where('company_id', $companyId)->findAll() // Fetch sources
    ];

    return view('company/details', $data);
}


/**
 * Get companies, optionally filtered by search term
 */
public function getCompanies($search = null)
{
    $builder = $this->db->table('company_data c');
    $builder->select('
        c.company_id,
        c.company_name,
        c.category,
        c.city,
        c.state,
        GROUP_CONCAT(
            DISTINCT CONCAT(
                co.name, " (", co.designation, ")",
                " | Mobiles: ", IFNULL(cm.mobiles, "N/A"),
                " | Emails: ", IFNULL(ce.emails, "N/A")
            )
            SEPARATOR "\n"
        ) AS contacts
    ', false);

    $builder->join('contact co', 'co.company_id = c.company_id', 'left');

    $builder->join(
        '(SELECT contact_id, GROUP_CONCAT(mobile) AS mobiles FROM contact_mobile GROUP BY contact_id) cm',
        'cm.contact_id = co.contact_id',
        'left'
    );

    $builder->join(
        '(SELECT contact_id, GROUP_CONCAT(email) AS emails FROM contact_email GROUP BY contact_id) ce',
        'ce.contact_id = co.contact_id',
        'left'
    );

    if ($search) {
        $builder->groupStart()
                ->like('c.company_name', $search)
                ->orLike('c.category', $search)
                ->groupEnd();
    }

    $builder->groupBy('c.company_id');

    return $builder->get()->getResultArray();
}

public function add_check()
{
    // if ($this->request->getMethod() === 'post') {
        // Get the first company from the POST array
        $company = $this->request->getPost('companies')[0] ?? [];

        // Create a fake company ID for preview
        $company_id = strtoupper('C' . time() . rand(100, 999));

        // Prepare data for the view
        $data = [
            'company_id'    => $company_id,
            'company_name'  => $company['company_name'] ?? '',
            'database_name' => $company['database_name'] ?? '',
            'outbound'      => isset($company['outbound']) ? 1 : 0,
        ];

        // Pass to view
        return view('company/add_check', $data);
    // }

    // // If accessed directly, just show empty form
    // return view('company/add_check', [
    //     'company_id' => 'none',
    //     'company_name' => 'none',
    //     'database_name' => 'none',
    //     'outbound' => 0
    // ]);
}


public function add()
{
     return view('company/add');}

public function add_details()
{
    $companies = $this->request->getPost('companies');

    if (empty($companies)) {
        return redirect()->back()->with('status', '⚠️ No company data found!');
    }

    $success = 0;
    $failed  = 0;

    foreach ($companies as $company) {
        try {
            $company_id = strtoupper('C' . time() . rand(100, 999));

            // Insert company
            $this->companyModel->insert([
                'company_id'    => $company_id,
                'database_name' => $company['database_name'] ?? null,
                'outbound'      => isset($company['outbound']) ? 1 : 0,
                'company_name'  => $company['company_name'] ?? null,
                'category'      => $company['category'] ?? null,
                'address'       => $company['address'] ?? null,
                'city'          => $company['city'] ?? null,
                'pincode'       => $company['pincode'] ?? null,
                'state'         => $company['state'] ?? null,
                'country'       => $company['country'] ?? 'India',
                'phone'         => $company['phone'] ?? null,
            ]);

            // Prepare source data
            $values = [
                'company_id'    => $company_id,
                'source_id'  => $company['source_id'] ?? 0,
                'event_date' => $company['event_date'] ?? date('Y-m-d'),
                'notes'      => $company['notes'] ?? $company['source'] ?? null,
            ];

            // Call the addSource method
            $this->addSource($values);

            $success++;

        } catch (\Throwable $e) {
            log_message('error', $e->getMessage());
            $failed++;
        }
    }

    return redirect()->back()->with(
        'status',
        $failed === 0
            ? "✅ Completed: {$success} companies added successfully"
            : "⚠️ Partial: {$success} added, {$failed} failed"
    );
}

public function addSource(array $values)
{
    $sourceModel = new \App\Models\SourceModel();

    if (empty($values['company_id'])) {
        dd('company_id missing', $values);
    }

    // Sanitize source_id: remove minus if any
$sourceId = isset($values['source_id']) && is_numeric($values['source_id'])
    ? abs((int)$values['source_id'])
    : 0; // default to 0 if not provided


    $result = $sourceModel->insert([
        'company_id' => trim($values['company_id']),
        'source_id'  => $sourceId,
        'event_date' => $values['event_date'],
        'notes'      => $values['notes'],
    ]);

    if ($result === false) {
        dd($sourceModel->errors());
    }

    return $result;
}
public function source_check()
{
    $companies = $this->request->getPost('companies');

    if (empty($companies)) {
        return redirect()->back()->with('status', '⚠️ No source data found!');
    }

    foreach ($companies as $company) {

        if (empty($company['company_id'])) {
            continue;
        }
            
        $this->addSource([
            'company_id' => $company['company_id'],
            'source_id'  => $company['source_id'] ?? null,
            'event_date' => $company['event_date'] ?? date('Y-m-d'),
            'notes'      => $company['notes'] ?? null,
        ]);
    }

    return redirect()->back()->with('status', '✅ Source inserted successfully');
}


// Optional: replace existing data
    public function replace($id)
    {
        $companyModel = new CompanyModel();
        $post = $this->request->getPost();
        $companyModel->update($id, $post);

        return redirect()->to('/company/list')->with('success','Company replaced successfully');
    }


// 

}