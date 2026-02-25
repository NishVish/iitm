<?php
namespace App\Controllers;
use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\UpdationModel;
use App\Models\LeadModel;
use App\Models\SourceModel;
use App\Models\CrossValidationController;
use Ramsey\Uuid\Uuid;

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


public function stats()
{
    // Load model
    $dashboardModel = new \App\Models\Dashboard_Model();

    // Get stats from model
    $stats = $dashboardModel->getstats(); // Assuming this returns an array like ['total_revenue' => 1000, ...]

    // Pass stats to the view
    return view('company/all_stats', $stats);
}
/**
 * Get companies, optionally filtered by search term
 */
public function getCompanies($search = null)
{
    $builder = $this->db->table('company_data c');
    $builder->select('
        c.session,
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

public function dummyData()
{
    $dataString = "
    New Delhi	OTR Old	IAAI - President				Bulk Trip/ BTC Tours & Travels Pvt Ltd	C-9/94, Sector-8, Rohini,		Delhi	110085	Delhi	11-42071206 / 45653666 / 45638666/ 45059327		Mr. Tushar Jain/ Ms Soneeka Jain	Directors	9810230050 (Tushar)			tushar.jain@bulktrip.com, tushar@btctravels.com, info@btctravels.com			Mrs. Vandana Neghi/ Ms. Savvy. S	Sr. Executive - Outbound/ Head - Operations	ops4@bulktrip.com, savvy.s@bulktrip.com		7042292236/ 7042296360		Mr. Nikhil Karanwal/ Mr. Yatindra Nath	Sales Manager/ Sales Executive	sales@bulktrip.com, sales1@bulktrip.com		91-7042296356/ 7042296358
    
    ";

    $columns = explode("\t", $dataString);

    $db = \Config\Database::connect();
    $db->transStart();

    try {


$companyId = Uuid::uuid4()->toString();
        $session_id = $this->companyModel->get_lastSession();

        // -----------------------
        // COMPANY INSERT
        // -----------------------
        $this->companyModel->insert([
            'session'       => $session_id,
            'company_id'    => $company_id,
            'database_name' => $columns[0] ?? null,
            'category'      => $columns[1] ?? null,
            'company_name'  => $columns[6] ?? null,
            'address'       => trim(($columns[7] ?? '') . ' ' . ($columns[8] ?? '')),
            'city'          => $columns[9] ?? null,
            'pincode'       => $columns[10] ?? null,
            'state'         => $columns[11] ?? null,
            'country'       => 'India',
            'phone'         => $columns[12] ?? null,
        ]);

        // -----------------------
        // SOURCE INSERT
        // -----------------------
        $this->addSource([
            'company_id' => $company_id,
            'source_id'  => 1,
            'event_date' => date('Y-m-d'),
            'notes'      => $columns[2] ?? null,
        ]);

        // -----------------------
        // CONTACT PROCESSOR FUNCTION
        // -----------------------
        $processContact = function ($name, $designation, $emails, $mobiles, $priority) use ($company_id) {

            if (empty(trim($name))) return;

            $names = array_map('trim', explode('/', $name));
            $designations = array_map('trim', explode('/', $designation));

            $emailList = [];
            if (!empty($emails)) {
                $parts = preg_split('/[,\/]/', $emails);
                foreach ($parts as $e) {
                    $e = trim($e);
                    if ($e) $emailList[] = $e;
                }
            }

            $mobileList = [];
            if (!empty($mobiles)) {
                $parts = preg_split('/[,\/]/', $mobiles);
                foreach ($parts as $m) {
                    $m = trim(preg_replace('/[^0-9\-\+]/', '', $m));
                    if ($m) $mobileList[] = $m;
                }
            }

            foreach ($names as $i => $singleName) {

                $contactData = [
                    'company_id'  => $company_id,
                    'priority'    => $priority,
                    'name'        => $singleName,
                    'designation' => $designations[$i] ?? null,
                    'mobiles'     => [],
                    'emails'      => []
                ];

                if (isset($mobileList[$i])) {
                    $contactData['mobiles'][] = $mobileList[$i];
                }

                if (isset($emailList[$i])) {
                    $contactData['emails'][] = $emailList[$i];
                }

                $this->savePerson($contactData);
            }
        };

        // -----------------------
        // CONTACT 1
        // -----------------------
        $processContact(
            $columns[14] ?? null,
            $columns[15] ?? null,
            $columns[19] ?? null,
            $columns[16] ?? null,
            1
        );

        // CONTACT 2
        $processContact(
            $columns[21] ?? null,
            $columns[22] ?? null,
            $columns[23] ?? null,
            $columns[25] ?? null,
            2
        );

        // CONTACT 3
        $processContact(
            $columns[27] ?? null,
            $columns[28] ?? null,
            $columns[29] ?? null,
            $columns[31] ?? null,
            3
        );

        $db->transComplete();

        return "✅ Tab data inserted successfully.";

    } catch (\Throwable $e) {

        $db->transRollback();
        return "❌ Failed: " . $e->getMessage();
    }
}


public function add_details()
{
    $companies = $this->request->getPost('companies');
    print_r($companies); 
    exit;
    // If this doesn't stop the script, your form isn't hitting this function at all.
    if (empty($companies)) {
        return redirect()->back()->with('status', '⚠️ No company data found!');
    }

    $success = 0;
    $failed  = 0;

    foreach ($companies as $index => $company) {
        try {

            // Generate a unique company ID
            $company_id = strtoupper('C' . time() . rand(100, 999));
            $session_id = $this->companyModel->get_lastSession();

            // Insert company
            $this->companyModel->insert([
                'session'    => $session_id,

                'company_id'    => $company_id,
                'database_name' => $company['database_name'] ?? null,
                'outbound'      => isset($company['outbound']) ? 1 : 0,
                'company_name'  => $company['company_name'] ?? null,
                'category'      => $company['category'] ?? null,
                'address' => trim(($company['address_1'] ?? '') . ' ' . ($company['address_2'] ?? '')),
                'city'          => $company['city'] ?? null,
                'pincode'       => $company['pincode'] ?? null,
                'state'         => $company['state'] ?? null,
                'country'       => $company['country'] ?? 'India',
                'phone'         => $company['phone'] ?? null,
            ]);

            // if$company['phone']

             // Prepare source data
            $values = [
                'company_id'    => $company_id,
                'source_id'  => $company['source_id'] ?? 0,
                'event_date' => $company['event_date'] ?? date('Y-m-d'),
                'notes'      => $company['source'] ?? null,
            ];
            // Call the addSource method
            $this->addSource($values);
        
            // Debugging
                // echo "<pre>";           // makes output readable in browser
                // print_r($values);
                // print_r($company);
                // echo "</pre>";
                // exit;
                $note = $values['notes']; // or $company['source']

                
            // Insert contacts dynamically (up to 3 contacts)
            for ($i = 1; $i <= 3; $i++) {

                $name = trim($company["contact{$i}_name"] ?? '');

                // Skip if no name
                if ($name === '') {
                    continue;
                }

                $contactData = [
                    'company_id'  => $company_id,
                    'priority'    => $i,
                    'name'        => $name,
                    'designation' => $company["contact{$i}_designation"] ?? '',
                    'mobiles'     => [],
                    'emails'      => []
                ];

                // Collect mobiles (up to 3 per contact)
                for ($m = 1; $m <= 3; $m++) {

                    $mobileKey = "contact{$i}_mobile{$m}";
                    var_dump($mobileKey);


                    if (!empty($company[$mobileKey])) {
                        $contactData['mobiles'][] = trim($company[$mobileKey]);
                    }
                }

                // Collect emails (up to 3 per contact)
                for ($e = 1; $e <= 3; $e++) {

                    $emailKey = "contact{$i}_email{$e}";

                    if (!empty($company[$emailKey])) {
                        $contactData['emails'][] = trim($company[$emailKey]);
                    }
                }

                // Insert contact using your working function
                $inserted = $this->savePerson($contactData);

                if ($inserted === true) {
                    $success++;
                } else {
                    $failed++;
                }
            }
        




if ($note == "Spot" || $note == "websitetradevisitor") {
    $crossValidationModel = new \App\Models\CrossValidationModel();

    $result = $crossValidationModel->crossValidate([
        'company_name' => $company['company_name'] ?? '',
        'phone'        => $company['phone']        ?? '',
        'gst_number'   => $company['gst_number']   ?? '',
        'city'         => $company['city']         ?? '',
        'state'        => $company['state']        ?? '',
        'country'      => $company['country']      ?? 'India',
        'pincode'      => $company['pincode']      ?? '',
        'address'      => trim(($company['address_1'] ?? '') . ' ' . ($company['address_2'] ?? '')),
        'contacts'     => [
            [
                'name'        => trim($company['contact1_name']  ?? ''),
                'designation' => $company['contact1_designation'] ?? '',
                'emails'      => !empty($company['contact1_email1'])
                                    ? [['email' => $company['contact1_email1']]]
                                    : [],
                'mobiles'     => !empty($company['contact1_mobile1'])
                                    ? [['mobile' => $company['contact1_mobile1']]]
                                    : [],
            ]
        ],
    ]);

    if ($result['status'] === 'existing') {
        $this->companyModel->where('company_id', $company_id)
                           ->set(['cross_validation' => 1])
                           ->update();
    }

    // ✅ Define variables BEFORE using them
    $data   = "spot";
    $number = $company['contact1_mobile1'] ?? $company['contact1_mobile'] ?? '';

    return redirect()->to(base_url('registration/regitersuccess/' . $data . '/' . $number));
}
        

            // if ($note == "Websitetradevisitor"){

            //         return redirect()->to(base_url('registration/generatebadge/' . $company_id));
            //     }


            // var_dump($note);
            // exit;
            if ($note === "exhibitor") {

                        $leadModel = new \App\Models\LeadModel();
                        
                        $contactModel = new \App\Models\ContactModel();

                        // Fetch the latest contact for this company
                        $contact = $contactModel->getByCompanyIdOne($company_id);

                        // Prepare lead data using the contact ID
                        $leadData = [
                            'company_id'   => $company_id,
                            'contact_id'   => $contact['contact_id'] ?? null,  // use latest contact ID
                            'fascia'       => $company['fascia'] ?? "Standard Fascia",
                            'sales_person' => $company['sales_person'] ?? null,
                            'exhibitor'    => $company['company_name'] ?? null,
                            'booking_form' => $company['booking_form'] ?? null,
                        ];
                        // var_dump($contact);
                        // exit;

                                    $locations = $company['location'] ?? []; // this is now an array



                        // Remove square brackets and split by comma
                        $locationsArray = explode(',', trim($locations, '[]'));

                        // Optional: remove extra spaces
                        $locationsArray = array_map('trim', $locationsArray);
                            // var_dump($locationsArray); // will now print each location
                            // exit;
                        // Now $locationsArray = ['Mumbai', 'Pune', 'Chennai'];
                        foreach ($locationsArray as $location) {
                            $locationData = [
                                'location'       => $location,
                                'stall_location' => $company['stall_location'] ?? "A1",
                                'size'           => $company['size'] ?? "3x3",
                                'price'          => $company['price'] ?? 1000.00,
                                'gst_amount'     => $company['gst_amount'] ?? 180.00,
                                'discount_amount'=> $company['discount_amount'] ?? 50.00,
                                'grand_total'    => $company['grand_total'] ?? 1130.00,
                            ];



                            $leadId = $leadModel->createLead($leadData, $locationData);
                            $data = "exhibitor";
                            return redirect()->to(base_url('registration/regitersuccess') . '/' . $data);
            }







        }
        }
         catch (\Throwable $e) {
            log_message('error', "Company {$company['company_name']} failed: " . $e->getMessage());
            $failed++;
        }
    }

    
    // $this->companyModel;
    return redirect()->to(site_url('company'))->with(
        'status',
        $failed === 0
            ? "✅ Completed: {$success} contacts added successfully"
            : "⚠️ Partial: {$success} contacts added, {$failed} failed"
    );
}



public function savePerson(array $contactData = null)
{
    $contactModel = new \App\Models\ContactModel();
    $mobileModel  = new \App\Models\ContactMobileModel();
    $emailModel   = new \App\Models\ContactEmailModel();

    // ✅ If called from form (route)
    if ($contactData === null) {
        $contactData = [
            'company_id'  => $this->request->getPost('company_id'),
            'priority'    => $this->request->getPost('priority'),
            'name'        => $this->request->getPost('name'),
            'designation' => $this->request->getPost('designation'),
            'mobiles'     => $this->request->getPost('mobiles'),
            'emails'      => $this->request->getPost('emails'),
        ];
    }

    // Ensure required fields
    if (empty($contactData['company_id']) || empty($contactData['name'])) {
        return redirect()->back()->with('error', 'Company ID and Name required');
    }

    $contactData['priority']    = $contactData['priority'] ?? 1;
    $contactData['designation'] = $contactData['designation'] ?? '';
    $contactData['created_at']  = date('Y-m-d H:i:s');

    try {

        // Insert main contact
        $contactId = $contactModel->insert([
            'company_id'  => $contactData['company_id'],
            'priority'    => $contactData['priority'],
            'name'        => $contactData['name'],
            'designation' => $contactData['designation'],
            'created_at'  => $contactData['created_at'],
        ], true);

        if (!$contactId) {
            return redirect()->back()->with('error', 'Contact insert failed');
        }

        // Insert mobiles
        if (!empty($contactData['mobiles'])) {
            foreach ($contactData['mobiles'] as $index => $m) {
                if (empty($m)) continue;

                $mobileModel->insert([
                    'contact_id' => $contactId,
                    'mobile'     => $m,
                    'is_primary' => $index === 0 ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // Insert emails
        if (!empty($contactData['emails'])) {
            foreach ($contactData['emails'] as $index => $e) {
                if (empty($e)) continue;

                $emailModel->insert([
                    'contact_id' => $contactId,
                    'email'      => $e,
                    'is_primary' => $index === 0 ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // ✅ If called from form, redirect
        if ($this->request->getMethod() === 'post') {
            return redirect()->back()->with('success', 'Contact Saved Successfully');
        }

        return true;

    } catch (\Exception $ex) {
        log_message('error', 'savePerson Error: ' . $ex->getMessage());
        return redirect()->back()->with('error', 'Something went wrong');
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

    $result = $sourceModel->addSource($values); // Correct semicolon

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
public function update($companyId,$ledID = Null)
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
    
    $contacts = $this->request->getPost('contacts');
    if ($contacts) {
        $contactModel = new \App\Models\ContactModel();

        foreach ($contacts as $c) {
            $contactModel->update($c['contact_id'], [
                'name'        => $c['name'],
                'designation' => $c['designation'],
            ]);
        }
    }

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
    // Assume you have code here to update the company details

    if ($leadID) {
        // Redirect to the booking company page for this lead
        return redirect()->to(site_url('booking/company/' . $leadID));
    } else {
        // Redirect to company details page if no lead ID
        return redirect()
            ->to(site_url('company/details/' . $companyId))
            ->with('status', '✅ Updated successfully');
    }
}


public function get_lastSession()
    {
        $companyModel = new CompanyModel();

        $lastSession = $companyModel->get_lastSession();

        return $lastSession; // or json_encode($lastSession) if you want JSON response
    }
public function compare_popup()
{
    $data = $this->request->getJSON(true);

    if (!$data || !isset($data['main_id'], $data['compare_id'])) {
        return 'Invalid request';
    }

    $main = $this->companyModel->find($data['main_id']);
    $matched = $this->companyModel->find($data['compare_id']);

    if (!$main || !$matched) {
        return 'Company not found';
    }

    // Build EXACT structure your existing view expects
    $company_matches = [[
        'company_id' => $main['company_id'],
        'matched_company_id' => $matched['company_id'],

        'original_company_name' => $main['company_name'],
        'matched_company_name'  => $matched['company_name'],

        'original_database_name' => $main['database_name'] ?? '',
        'matched_database_name'  => $matched['database_name'] ?? '',

        'original_category' => $main['category'],
        'matched_category'  => $matched['category'],

        'original_address' => $main['address'],
        'matched_address'  => $matched['address'],

        'original_city' => $main['city'],
        'matched_city'  => $matched['city'],

        'original_pincode' => $main['pincode'],
        'matched_pincode'  => $matched['pincode'],

        'original_state' => $main['state'],
        'matched_state'  => $matched['state'],

        'original_country' => $main['country'],
        'matched_country'  => $matched['country'],

        'original_phone' => $main['phone'],
        'matched_phone'  => $matched['phone'],

        'original_gst_number' => $main['gst_number'],
        'matched_gst_number'  => $matched['gst_number'],

        'original_sales_person' => $main['sales_person'],
        'matched_sales_person'  => $matched['sales_person'],

        'original_active_inactive' => $main['active_inactive'],
        'matched_active_inactive'  => $matched['active_inactive'],

        'original_created_at' => $main['created_at'],
        'matched_created_at'  => $matched['created_at'],

        'original_updated_at' => $main['updated_at'],
        'matched_updated_at'  => $matched['updated_at'],

        'original_last_confirmed_at' => $main['last_confirmed_at'],
        'matched_last_confirmed_at'  => $matched['last_confirmed_at'],

        'original_session' => $main['session'],
        'matched_session'  => $matched['session'],

        'orignal_cross_validation' => $main['cross_validation'] ?? '',
        'matched_cross_validation' => $matched['cross_validation'] ?? '',
    ]];

    return view('crossvalidation/compare_view', [
        'company_matches' => $company_matches
    ]);
}


}