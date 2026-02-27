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



/**
     * Dashboard View
     */
    public function index()
    {
        $data = [];

        // Basic Dashboard Stats
        $data['dashboardStats'] = $this->companyModel->getDashboardStats();

        // State + Category (TA / HOTEL / Resst / Other)
        $stateCategory = $this->companyModel->getStateAndCategoryStats();

        $data['category_counts'] = $stateCategory;
        return view('company/index', $data);

        // Optional Extra Stats
        $data['categoryStats']        = $this->companyModel->getCategoryStats();
        $data['stateStats']           = $this->companyModel->getStateStats();
        $data['countryStats']         = $this->companyModel->getCountryStats();
        $data['salesPersonStats']     = $this->companyModel->getSalesPersonStats();
        $data['crossValidationStats'] = $this->companyModel->getCrossValidationStats();

        return view('company/index', $data);
    }


    public function getDatabases()
{
    $db = \Config\Database::connect();

    $databases = $db->table('company_data')
        ->select('DISTINCT(database_name) as db_name')
        ->get()
        ->getResultArray();

    return $this->response->setJSON($databases);
}



    // Main page
// public function index()
// {
//     $companies = $this->companyModel->getCompaniesWithContacts();
//     $states    = $this->companyModel->getDistinctStates();

//     // --- Pagination setup ---
//     $perPage = 1000; // Number of rows per page
//     $page = $this->request->getGet('page') ?? 1; // Current page from ?page=
//     $totalCompanies = count($companies);       // Total rows
//     $totalPages = ceil($totalCompanies / $perPage);
//     $startIndex = ($page - 1) * $perPage;

//     // Slice the data for current page
//     $paginatedData = array_slice($companies, $startIndex, $perPage);

//     $data = [
//         'title' => 'All Companies',
//         'companies' => $companies,       // Optional, if you still need full data elsewhere
//         'states' => $states,
//         'paginatedData' => $paginatedData,
//         'totalPages' => $totalPages,
//         'currentPage' => $page
//     ];

//     return view('company/index', $data);
// }

public function update_cell()
{
    $json = $this->request->getJSON(true);
    if (!$json) return $this->response->setJSON(['status' => 'error', 'message' => 'No data']);

    $db = \Config\Database::connect();
    $companyId  = $json['company_id'];
    $contactIds = $json['contact_ids']; // Array of IDs we sent from the view
    $column     = $json['column'];
    $newValue   = $json['newValue'];

    // 1. Handle Company Table Updates
    $companyFields = ['category', 'company_name', 'address_1', 'city', 'pincode', 'state', 'phone', 'fax'];
    if (in_array($column, $companyFields)) {
        // Map address_1 back to your database column 'address' if necessary
        $dbCol = ($column == 'address_1') ? 'address' : $column;
        $db->table('company_data')->where('company_id', $companyId)->update([$dbCol => $newValue]);
        return $this->response->setJSON(['status' => 'success']);
    }

    // 2. Handle Contact/Email/Mobile Updates
    // We parse the column name to find the index (e.g., contact_name_2 -> index 1)
    preg_match('/_(\d+)$/', $column, $matches);
    $index = !empty($matches[1]) ? (int)$matches[1] - 1 : 0; 
    
    // Safety check: does this contact exist in the array?
    if (!isset($contactIds[$index])) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Contact not found']);
    }
    $targetContactId = $contactIds[$index];

    // Update Contact Name or Designation
    if (strpos($column, 'contact_name') !== false) {
        $db->table('contact')->where('contact_id', $targetContactId)->update(['name' => $newValue]);
    } 
    elseif (strpos($column, 'designation') !== false) {
        $db->table('contact')->where('contact_id', $targetContactId)->update(['designation' => $newValue]);
    }
    
    // Update Mobiles (Primary = index 0, Secondary = index 1)
    elseif (strpos($column, 'mobile_') !== false) {
        $isSecondary = ((int)filter_var($column, FILTER_SANITIZE_NUMBER_INT) % 2 == 0);
        $this->updateContactDetail($targetContactId, 'contact_mobile', 'mobile', $newValue, $isSecondary);
    }
    
    // Update Emails (Primary = index 0, Secondary = index 1)
    elseif (strpos($column, 'email_') !== false) {
        $isSecondary = ((int)filter_var($column, FILTER_SANITIZE_NUMBER_INT) % 2 == 0);
        $this->updateContactDetail($targetContactId, 'contact_email', 'email', $newValue, $isSecondary);
    }

    return $this->response->setJSON(['status' => 'success']);
}

/**
 * Helper to update or insert mobile/email records
 */
private function updateContactDetail($contactId, $table, $field, $value, $isSecondary)
{
    $db = \Config\Database::connect();
    $builder = $db->table($table);
    
    // Find existing record (Primary is 1, Secondary is 0)
    $exists = $builder->where([
        'contact_id' => $contactId, 
        'is_primary' => $isSecondary ? 0 : 1
    ])->get()->getRow();

    if ($exists) {
        $builder->where('id', $exists->id)->update([$field => $value]);
    } else {
        $builder->insert([
            'contact_id' => $contactId,
            $field       => $value,
            'is_primary' => $isSecondary ? 0 : 1
        ]);
    }
}

public function getCompanySourcesContactsByState($state = null)
{
    $db = \Config\Database::connect();
// Decode slug
    $state = urldecode($state);
    $state = str_replace('-and-', ' & ', $state);
    $state = str_replace('-', ' ', $state);
    $state = trim(preg_replace('/\s+/', ' ', $state));
    $builder = $db->table('company_data cd')
        ->select('
            cd.*, 
            cs.source_id, cs.event_date, cs.notes as source_notes,
            c.contact_id, c.name as contact_name, c.designation,
            ce.email as email_address,
            cm.mobile as mobile_number
        ')
        ->join('company_sources cs', 'cs.company_id = cd.company_id', 'left')
        ->join('contact c', 'c.company_id = cd.company_id', 'left')
        ->join('contact_email ce', 'ce.contact_id = c.contact_id', 'left')
        ->join('contact_mobile cm', 'cm.contact_id = c.contact_id', 'left');

    if ($state) {
        $builder->where('cd.state', $state);
    }

    $rows = $builder->get()->getResultArray();

    $grouped = [];
    foreach ($rows as $row) {
        $id = $row['company_id'];
        
        // Initialize company if not exists
        if (!isset($grouped[$id])) {
            $grouped[$id] = [
                'details'  => $row,
                'contacts' => []
            ];
        }

        // Group contacts and their unique emails/mobiles
        if ($row['contact_id']) {
            $cId = $row['contact_id'];
            if (!isset($grouped[$id]['contacts'][$cId])) {
                $grouped[$id]['contacts'][$cId] = [
                    'name'        => $row['contact_name'],
                    'designation' => $row['designation'],
                    'emails'      => [],
                    'mobiles'     => []
                ];
            }
            if ($row['email_address'] && !in_array($row['email_address'], $grouped[$id]['contacts'][$cId]['emails'])) {
                $grouped[$id]['contacts'][$cId]['emails'][] = $row['email_address'];
            }
            if ($row['mobile_number'] && !in_array($row['mobile_number'], $grouped[$id]['contacts'][$cId]['mobiles'])) {
                $grouped[$id]['contacts'][$cId]['mobiles'][] = $row['mobile_number'];
            }
        }
    }

    
    $data['companies'] = $grouped;
    $data['state'] = $state;

    return view('company/by_state', $data);
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
    $sourceModel   = new \App\Models\SourceModel();

    // 1. Fetch the composite data (current company + neighbor IDs)
    $result = $companyModel->getByCompanyId($companyId);

    // 2. Validate if the company exists
    if (!$result || !$result['current']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Company not found');
    }

    // 3. Prepare data array
    $data = [
        'company'   => $result['current'],  // The actual company object
        'prev_id'   => $result['prev_id'],  // The previous ID for your "Back" button
        'next_id'   => $result['next_id'],  // The next ID for your "Next" button
        'contacts'  => $contactModel->getByCompanyId($companyId),
        'updates'   => $updationModel->getByCompanyId($companyId),
        'leads'     => $leadModel->getByCompanyId($companyId),
        'sources'   => $sourceModel->where('company_id', $companyId)->findAll()
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

public function addexhibitor()
{
     return view('company/insert_exhibitor');}

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
    // print_r($companies); 
    // exit;
    // If this doesn't stop the script, your form isn't hitting this function at all.
    if (empty($companies)) {
        return redirect()->back()->with('status', '⚠️ No company data found!');
    }

    $success = 0;
    $failed  = 0;

    foreach ($companies as $index => $company) {
        try {

            // Generate a unique company ID

$company_id = 'C' . strtoupper(bin2hex(random_bytes(4))); 

$session_id = $this->companyModel->get_lastSession();

            // print_r($company); 
            // exit;
        $updatedAt = null;
        if (!empty($company['updated_at'])) {
            $updatedAt = str_replace('T', ' ', $company['updated_at']) . ':00';
        } else {
            $updatedAt = date('Y-m-d H:i:s');
        }


        $this->companyModel->insert([
            'session'       => $session_id,
            'company_id'    => $company_id,
            'database_name' => $company['database_name'] ?? null,
            'category'      => $company['category'] ?? null,
            'updated_by'    => $company['updated_by'] ?? 'system',
            'updated_at'    => $updatedAt,
            'last_comments' => $company['comments'] ?? null,
            'outbound'      => isset($company['outbound']) ? 1 : 0,
            'company_name'  => $company['company_name'] ?? "x",
            'address'       => trim(($company['address_1'] ?? '') . ' ' . ($company['address_2'] ?? '')),
            'city'          => $company['city'] ?? null,
            'pincode'       => $company['pincode'] ?? null,
            'state'         => $company['state'] ?? null,
            'country'       => $company['country'] ?? 'India',
            'phone'         => $company['phone'] ?? null,
            'corssvaliation'         => 0,
        ]);

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
                // // print_r($company);
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
        


$allowedCities = [
    'ahmedabad', 'mumbai', 'delhi', 
    'bangalore', 'kochi', 'pune', 'hyderabad'
];

if ($note === "Spot" || in_array(strtolower($note), $allowedCities)) {

// var_dump($note);
// exit;
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
    // if ($note === "Spot"){}
    $data   = $note;
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
                                'contact_id'   => $contact['contact_id'] ?? null,
                                'fascia'       => $company['fascia'] ?? "Standard Fascia",
                                'sales_person' => $company['sales_person'] ?? null,
                                'exhibitor'    => $company['company_name'] ?? null,
                                'booking_form' => $company['booking_form'] ?? null,
                                // If database_name is exhibitor, set is_exhibitor to true, else false
                                'is_exhibitor' => ($company['database_name'] == "exhibitor") ? true : false,
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