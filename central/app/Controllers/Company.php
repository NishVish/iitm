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

public function add_detailsold()
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

            if ($this->request->getMethod() === 'post') {
    $contactData = [
        'company_id'  => $this->request->getPost('company_id'),
        'priority'    => $this->request->getPost('priority'),
        'name'        => $this->request->getPost('name'),
        'designation' => $this->request->getPost('designation'),
        'mobiles'     => array_filter($this->request->getPost('mobiles') ?? []),
        'emails'      => array_filter($this->request->getPost('emails') ?? [])
    ];

    $result = $this->savePerson($contactData);
    return redirect()->back()->with('status', $result ? "✅ Contact added successfully" : "⚠️ Failed to add contact");
}



// Call the function to insert contacts
    foreach ($contacts as $contact) {
        $result = $this->savePerson($contact);
        if ($result) {
            $success++;
        } else {
            $failed++;
        }
    }


        
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

public function add_details()
{
    $companies = $this->request->getPost('companies');

    if (empty($companies)) {
        return redirect()->back()->with('status', '⚠️ No company data found!');
    }

    $success = 0;
    $failed  = 0;

    foreach ($companies as $index => $company) {
        try {
            // Generate a unique company ID
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

            // Insert contacts dynamically (up to 3 contacts)
            for ($i = 1; $i <= 3; $i++) {
                $name = trim($company["contact{$i}_name"] ?? '');
                if (!$name) continue; // Skip if no name

                $contactData = [
                    'company_id'   => $company_id,
                    'priority'     => $i,
                    'name'         => $name,
                    'designation'  => $company["contact{$i}_designation"] ?? '',
                    'mobiles'      => [],
                    'emails'       => []
                ];

                // Collect mobiles
                for ($m = 1; $m <= 3; $m++) {
                    $mobileKey = "contact{$i}_mobile{$m}";
                    if (!empty($company[$mobileKey])) {
                        $contactData['mobiles'][] = $company[$mobileKey];
                    }
                }

                // Collect emails
                for ($e = 1; $e <= 3; $e++) {
                    $emailKey = "contact{$i}_email{$e}";
                    if (!empty($company[$emailKey])) {
                        $contactData['emails'][] = $company[$emailKey];
                    }
                }

                // Insert the contact
                $inserted = $this->savePerson($contactData);
                if ($inserted) {
                    $success++;
                } else {
                    $failed++;
                }
            }

        } catch (\Throwable $e) {
            log_message('error', "Company {$company['company_name']} failed: " . $e->getMessage());
            $failed++;
        }
    }

    return redirect()->back()->with(
        'status',
        $failed === 0
            ? "✅ Completed: {$success} contacts added successfully"
            : "⚠️ Partial: {$success} contacts added, {$failed} failed"
    );
}



public function savePerson(array $contactData)
{
    $contactModel = new \App\Models\ContactModel();
    $mobileModel  = new \App\Models\ContactMobileModel();
    $emailModel   = new \App\Models\ContactEmailModel();

    // Ensure required fields
    if (empty($contactData['company_id']) || empty($contactData['name'])) {
        log_message('error', 'Missing company_id or name in savePerson');
        return false;
    }

    // Default values
    $contactData['priority']    = $contactData['priority'] ?? 1;
    $contactData['designation'] = $contactData['designation'] ?? '';
    $contactData['created_at']  = date('Y-m-d H:i:s');

    try {
        // Insert main contact
        $contactId = $contactModel->insert($contactData, true); // true = return insert ID
        if (!$contactId) return false;

        // Insert mobiles
        if (!empty($contactData['mobiles'])) {
            foreach ($contactData['mobiles'] as $m) {
                if (empty($m)) continue;
                $mobileModel->insert([
                    'contact_id' => $contactId,
                    'mobile'     => $m,
                    'is_primary' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // Insert emails
        if (!empty($contactData['emails'])) {
            foreach ($contactData['emails'] as $e) {
                if (empty($e)) continue;
                $emailModel->insert([
                    'contact_id' => $contactId,
                    'email'      => $e,
                    'is_primary' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return true;

    } catch (\Exception $ex) {
        log_message('error', 'savePerson Error: ' . $ex->getMessage());
        return false;
    }
}

public function savePersonold()
{
    $contactModel = new \App\Models\ContactModel();
    $mobileModel  = new \App\Models\ContactMobileModel();
    $emailModel   = new \App\Models\ContactEmailModel();

    // // Collect contact info from POST
    // $contactData = [
    //     'company_id'    => $this->request->getPost('company_id') ?? 1,
    //     'priority'    => $this->request->getPost('priority') ?? 1,
    //     'name'        => $this->request->getPost('name') ?? '',
    //     'designation' => $this->request->getPost('designation') ?? '',
    //     'created_at'  => date('Y-m-d H:i:s')
    // ];

    if (!$contactData['name']) {
        return redirect()->back()->with('status', '⚠️ Name is required');
    }

    try {
        // Insert main contact
        $contactId = $contactModel->insert($contactData, true); // true = return insert ID

        if (!$contactId) {
            return redirect()->back()->with('status', '⚠️ Failed to insert contact');
        }

        // Insert mobiles
        $mobiles = array_filter($this->request->getPost('mobiles') ?? []);
        foreach ($mobiles as $m) {
            $mobileModel->insert([
                'contact_id' => $contactId,
                'mobile'     => $m,
                'is_primary' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Insert emails
        $emails = array_filter($this->request->getPost('emails') ?? []);
        foreach ($emails as $e) {
            $emailModel->insert([
                'contact_id' => $contactId,
                'email'      => $e,
                'is_primary' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->back()->with('status', "✅ Contact added successfully");
    } catch (\Exception $ex) {
        log_message('error', $ex->getMessage());
        return redirect()->back()->with('status', "⚠️ Failed to add contact: " . $ex->getMessage());
    }
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
public function update($companyId)
{
    $companyModel = new CompanyModel();
    $sourceModel  = new \App\Models\SourceModel();

    // Update company
    $companyModel->update($companyId, [
        'company_name' => $this->request->getPost('company_name'),
        'city'         => $this->request->getPost('city'),
        'state'        => $this->request->getPost('state'),
        'phone'        => $this->request->getPost('phone'),
        'gst_number'   => $this->request->getPost('gst_number'),
    ]);

    // Update sources
    $sources = $this->request->getPost('sources');
    if ($sources) {
        foreach ($sources as $src) {
            $sourceModel->update($src['id'], [
                'source_id'  => $src['source_id'],
                'event_date' => $src['event_date'],
                'notes'      => $src['notes'],
            ]);
        }
    }
return redirect()
        ->to(site_url('company/details/' . $companyId))
        ->with('status', '✅ Updated successfully');
}


}