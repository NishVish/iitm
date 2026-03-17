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
protected $allowedTypes = ['main', 'lead', 'participant', 'all', 'online_registration', 'spot'];
// protected $allowedTypes = ['main', 'lead', 'participant', 'all', 'online_registration', 'spot'];
    public function __construct()
    {
        $this->companyModel = new CompanyModel();
    }

// company/entrytype/database/source/category/state/city/comment

/**
     * Dashboard View
     */
public function index($entry_type) 
{
    // 1. Check if type is empty or invalid, fallback to 'main'
    
$this->getCompanySourcesContactsByFilters(['all' => $entry_type]);

    // 3. Return the View (Make sure the path matches your file)
    
}

    public function opreation()
{
$db = \Config\Database::connect();

    $databases = $db->table('company_data')
        ->select('DISTINCT(database_name) as db_name')
        ->get()
        ->getResultArray();


 return view('company/operation',$databases);
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

public function overview($entry_type, $parameter)
{
    $data = $this->overviewDynamic($entry_type, $parameter);
    // var_dump($data);
    return view('company/index', $data);
}



public function overviewDynamic($entry_type, $column)
{
    $allowed = ['state','database_name','category','country'];

    if (!in_array($column, $allowed)) {
        throw new \Exception("Invalid column");
    }

    $db = \Config\Database::connect();

    $companies = $db->query("
        SELECT $column, category
        FROM company_data
        WHERE entry_type = ?
    ", [$entry_type])->getResultArray();

    $pivot = [];
    $rows = [];
    $columns = [];

    foreach ($companies as $row) {

        $rowKey = $row[$column] ?? 'Unknown';
        $colKey = $row['category'] ?? 'Unknown';

        $rows[$rowKey] = true;
        $columns[$colKey] = true;

        if (!isset($pivot[$rowKey][$colKey])) {
            $pivot[$rowKey][$colKey] = 0;
        }

        $pivot[$rowKey][$colKey]++;
    }

    $rows = array_keys($rows);
    $columns = array_keys($columns);

    sort($rows);
    sort($columns);

    return [
        'pivot'   => $pivot,
        'rows'    => $rows,
        'columns' => $columns,
        'type'    => $entry_type,
        'groupby' => $column
    ];
}

public function fulloverview()
{
    $db = \Config\Database::connect();

    // --- Collect Filters from GET params ---
    $status      = $this->request->getGet('status');       // active/inactive
    $salesPerson = $this->request->getGet('sales_person');
    $city        = $this->request->getGet('city');
    $state       = $this->request->getGet('state');
    $country     = $this->request->getGet('country');
    $outbound    = $this->request->getGet('outbound');     // 0 or 1
    $entryType   = $this->request->getGet('entry_type');
    $dateFrom    = $this->request->getGet('date_from');    // Y-m-d
    $dateTo      = $this->request->getGet('date_to');      // Y-m-d

    // --- Base Builder ---
    $builder = $db->table('company_data');

    // Apply filters dynamically
    if (!empty($status)) {
        $builder->where('active_inactive', $status);
    }
    if (!empty($salesPerson)) {
        $builder->where('sales_person', $salesPerson);
    }
    if (!empty($city)) {
        $builder->where('city', $city);
    }
    if (!empty($state)) {
        $builder->where('state', $state);
    }
    if (!empty($country)) {
        $builder->where('country', $country);
    }
    if ($outbound !== null && $outbound !== '') {
        $builder->where('outbound', (int)$outbound);
    }
    if (!empty($entryType)) {
        $builder->where('entry_type', $entryType);
    }
    if (!empty($dateFrom)) {
        $builder->where('created_at >=', $dateFrom . ' 00:00:00');
    }
    if (!empty($dateTo)) {
        $builder->where('created_at <=', $dateTo . ' 23:59:59');
    }

    // Clone builder state for reuse across stat queries
    $filteredBuilder = clone $builder;

    // --- Summary Stats ---

    // Total companies (with filters applied)
    $total = (clone $filteredBuilder)->countAllResults(false);

    // Active vs Inactive
    $activeCount   = (clone $filteredBuilder)->where('active_inactive', 'active')->countAllResults(false);
    $inactiveCount = (clone $filteredBuilder)->where('active_inactive', 'inactive')->countAllResults(false);

    // Outbound vs Inbound
    $outboundCount = (clone $filteredBuilder)->where('outbound', 1)->countAllResults(false);
    $inboundCount  = (clone $filteredBuilder)->where('outbound', 0)->countAllResults(false);

    // Cross-validated count
    $crossValidated = (clone $filteredBuilder)->where('cross_validation', 1)->countAllResults(false);

    // Companies with no session activity
    $noSession = (clone $filteredBuilder)->where('session', 0)->countAllResults(false);

    // --- Breakdowns ---

    // By Sales Person
    $bySalesPerson = (clone $filteredBuilder)
        ->select('sales_person, COUNT(*) as total, 
                  SUM(active_inactive = "active") as active_count,
                  SUM(outbound = 1) as outbound_count')
        ->groupBy('sales_person')
        ->orderBy('total', 'DESC')
        ->get()->getResultArray();

    // By State
    $byState = (clone $filteredBuilder)
        ->select('state, COUNT(*) as total')
        ->groupBy('state')
        ->orderBy('total', 'DESC')
        ->get()->getResultArray();

    // By Country
    $byCountry = (clone $filteredBuilder)
        ->select('country, COUNT(*) as total')
        ->groupBy('country')
        ->orderBy('total', 'DESC')
        ->get()->getResultArray();

    // By Entry Type
    $byEntryType = (clone $filteredBuilder)
        ->select('entry_type, COUNT(*) as total')
        ->groupBy('entry_type')
        ->orderBy('total', 'DESC')
        ->get()->getResultArray();

    // Monthly registrations (last 12 months)
    $monthlyTrend = $db->query("
        SELECT 
            DATE_FORMAT(created_at, '%Y-%m') as month,
            COUNT(*) as total,
            SUM(active_inactive = 'active') as active_count
        FROM company_data
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY month
        ORDER BY month ASC
    ")->getResultArray();

    // --- Stale / At-Risk Companies ---
    $staleCompanies = $db->query("
        SELECT company_name, sales_person, last_confirmed_at, active_inactive
        FROM company_data
        WHERE last_confirmed_at < DATE_SUB(NOW(), INTERVAL 90 DAY)
           OR last_confirmed_at IS NULL
        ORDER BY last_confirmed_at ASC
        LIMIT 10
    ")->getResultArray();

    // --- Dropdown options for filter UI ---
    $salesPersonList = $db->query("SELECT DISTINCT sales_person FROM company_data WHERE sales_person IS NOT NULL ORDER BY sales_person")->getResultArray();
    $countryList     = $db->query("SELECT DISTINCT country FROM company_data WHERE country IS NOT NULL ORDER BY country")->getResultArray();
    $stateList       = $db->query("SELECT DISTINCT state FROM company_data WHERE state IS NOT NULL ORDER BY state")->getResultArray();
    $entryTypeList   = $db->query("SELECT DISTINCT entry_type FROM company_data WHERE entry_type IS NOT NULL ORDER BY entry_type")->getResultArray();

    // --- Pass to View ---
    $data = [
        // Summary
        'total'           => $total,
        'activeCount'     => $activeCount,
        'inactiveCount'   => $inactiveCount,
        'outboundCount'   => $outboundCount,
        'inboundCount'    => $inboundCount,
        'crossValidated'  => $crossValidated,
        'noSession'       => $noSession,

        // Breakdowns
        'bySalesPerson'   => $bySalesPerson,
        'byState'         => $byState,
        'byCountry'       => $byCountry,
        'byEntryType'     => $byEntryType,
        'monthlyTrend'    => $monthlyTrend,
        'staleCompanies'  => $staleCompanies,

        // Filter dropdowns
        'salesPersonList' => $salesPersonList,
        'countryList'     => $countryList,
        'stateList'       => $stateList,
        'entryTypeList'   => $entryTypeList,

        // Active filters (to repopulate form)
        'filters' => [
            'status'       => $status,
            'sales_person' => $salesPerson,
            'city'         => $city,
            'state'        => $state,
            'country'      => $country,
            'outbound'     => $outbound,
            'entry_type'   => $entryType,
            'date_from'    => $dateFrom,
            'date_to'      => $dateTo,
        ],
    ];

    return view('company/overview', $data);
}



public function viewbyfilter()
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data');

    // 1. Fetch Unique Values for Static/Global Filters
    // These populate your Entry Type and Database selects
    $data['entry_types'] = array_column(
        $builder->select('entry_type')->distinct()->get()->getResultArray(), 
        'entry_type'
    );
    
    $data['databases'] = array_column(
        $builder->select('database_name')->distinct()->get()->getResultArray(), 
        'database_name'
    );

    // 2. Fetch Unique Values & Counts for Dynamic Summary Cards
    // We use distinct counts to show how many unique items exist in the whole table
    $summaryQuery = $builder->select("
        COUNT(DISTINCT state) as total_states,
        COUNT(DISTINCT city) as total_cities,
        COUNT(DISTINCT category) as total_categories,
        COUNT(DISTINCT sales_person) as total_sources,
        COUNT(DISTINCT last_comments) as total_comments
    ")->get()->getRowArray();

    // 3. Populate Card Data
    $data['states']     = array_column($db->table('company_data')->select('state')->distinct()->get()->getResultArray(), 'state');
    $data['cities']     = array_column($db->table('company_data')->select('city')->distinct()->get()->getResultArray(), 'city');
    $data['categories'] = array_column($db->table('company_data')->select('category')->distinct()->get()->getResultArray(), 'category');
    $data['sources']    = array_column($db->table('company_data')->select('sales_person')->distinct()->get()->getResultArray(), 'sales_person');
    $data['comments']   = array_column($db->table('company_data')->select('last_comments')->distinct()->get()->getResultArray(), 'last_comments');

    // 4. Map the totals for the View
    $data['totalUniqueStates']     = $summaryQuery['total_states']     ?? 0;
    $data['totalUniqueCities']     = $summaryQuery['total_cities']     ?? 0;
    $data['totalUniqueCategories'] = $summaryQuery['total_categories'] ?? 0;
    $data['totalUniqueSources']    = $summaryQuery['total_sources']    ?? 0;
    $data['totalUniqueComments']   = $summaryQuery['total_comments']   ?? 0;

    return view('company/overview', $data);
}
public function fulloverview2()
{
    $db = \Config\Database::connect();

    // Unique Countries
    $countries = $db->query("
        SELECT DISTINCT country
        FROM company_data
        WHERE country IS NOT NULL AND country != ''
        ORDER BY country
    ")->getResultArray();

    // Unique States
    $states = $db->query("
        SELECT DISTINCT state 
        FROM company_data 
        WHERE state IS NOT NULL AND state != ''
        ORDER BY state
    ")->getResultArray();

    // Unique Categories
    $categories = $db->query("
        SELECT DISTINCT category 
        FROM company_data 
        WHERE category IS NOT NULL AND category != ''
        ORDER BY category
    ")->getResultArray();

    // Unique Databases
    $databases = $db->query("
        SELECT DISTINCT database_name 
        FROM company_data 
        WHERE database_name IS NOT NULL AND database_name != ''
        ORDER BY database_name
    ")->getResultArray();

    $Data['countries'] = $countries;
    $Data['states'] = $states;
    $Data['categories'] = $categories;
    $Data['databases'] = $databases;
$db = \Config\Database::connect();

    // Count by entry_type and country
    $entryCountry = $db->query("
        SELECT 
            entry_type,
            country,
            COUNT(*) AS total
        FROM company_data
        WHERE country IS NOT NULL AND country != ''
        GROUP BY entry_type, country
        ORDER BY entry_type, country
    ")->getResultArray();

    $Data['entry_country'] = $entryCountry;
    return view('company/overview2', $Data);
}




public function byvar(
    $entrytype = 'all',
    $database  = 'all',
    $category  = 'all',
    $source    = 'all',
    $country    = 'all',
    $state     = 'all',
    $city      = 'all',
    $comment   = 'all'
) {


if ($entrytype === "overview") {
        return $this->fulloverview();
    }
if ($entrytype === "overview2") {
        return $this->fulloverview2();
    }


    if ($entrytype === "details") {
        return $this->details("main",$database);
    }
    if ($database === "overview") {
        return $this->overview($entrytype,$category);
    }

    if ($entrytype === "download") {
        return $this->downloadDatabase();
    }

        if ($entrytype === "operation") {
        return $this->opreation();
    }


    $filters = compact(
        'entrytype',
        'database',
        'category',
        'source',
        'country',
        'state',
        'city',
        'comment'
    );


    $data = $this->getCompanySourcesContactsByFilters($filters);

    // var_dump($data);
    // exit;
    
//     echo '<pre>';
// print_r($data);   // or var_dump($data) if you need types
// echo '</pre>';
// // exit;


    return view('company/by_var', $data);
}



public function filter()
{
    // 1. Capture all variables from the Query String
    $rawFilters = [
        'entry_type'    => $this->request->getGet('entry_type'),
        'database_name' => $this->request->getGet('database'),
        'category'      => $this->request->getGet('category'),
        'source_notes'  => $this->request->getGet('source'), // Mapping 'source' to DB column
        'state'         => $this->request->getGet('state'),
        'city'          => $this->request->getGet('city'),
        'last_comments' => $this->request->getGet('comment') // Mapping 'comment' to DB column
    ];

    var_dump($rawFilters);
    exit;
    // 2. Clean and Convert '&' to 'and' for all filter values
    $filters = [];
    foreach ($rawFilters as $key => $value) {
        if (!empty($value)) {
            // Replaces '&' with 'and' and trims extra whitespace
            $cleanValue = trim(str_replace('&', 'and', $value));
            $filters[$key] = $cleanValue;
        }
    }

    // 3. Reuse your logic with the cleaned, non-empty filters
    return $this->getCompanySourcesContactsByFilters($filters);
}



public function getCompanySourcesContactsByFilters($filters = [])
{
    $db = \Config\Database::connect();

    $columnMap = [
        'entrytype' => 'entry_type',
        'database'  => 'database_name',
        'category'  => 'category',
        'country'     => 'country',
        'state'     => 'state',
        'city'      => 'city',
        'comment'   => 'last_comments'
    ];

    /* ---------------------------
       1. Build reusable WHERE
    ----------------------------*/

    $where = [];

   foreach ($filters as $key => $value) {

    if ($value === 'all' || $value === '') continue;

    if ($key === 'source') continue;

    $column = $columnMap[$key] ?? $key;

    // Replace dashes with spaces before using in query
    $dbValue = str_replace('-', ' ', $value);

    $where["cd.$column"] = $dbValue;
}

    /* ---------------------------
       2. MAIN QUERY (companies)
    ----------------------------*/

   $builder = $db->table('company_data cd')
    ->select('
        cd.company_id,
        cd.database_name,
        cd.category,
        cd.company_name,
        cd.address,
        cd.city,
        cd.pincode,
        cd.state,
        cd.phone,
        cd.updated_by,
        cd.updated_at,
        cd.last_comments,
        cd.outbound,

        GROUP_CONCAT(DISTINCT cs.notes ORDER BY cs.event_date SEPARATOR ", ") AS source_notes,

        c.contact_id,
        c.name AS contact_name,
        c.designation,

        GROUP_CONCAT(DISTINCT ce.email SEPARATOR ", ") AS email_address,
        GROUP_CONCAT(DISTINCT cm.mobile SEPARATOR ", ") AS mobile_number
    ', false)
    ->join('company_sources cs', 'cs.company_id = cd.company_id', 'left')
    ->join('contact c', 'c.company_id = cd.company_id', 'left')
    ->join('contact_email ce', 'ce.contact_id = c.contact_id', 'left')
    ->join('contact_mobile cm', 'cm.contact_id = c.contact_id', 'left')
    ->groupBy([
        'cd.company_id',
        'cd.database_name',
        'cd.category',
        'cd.company_name',
        'cd.address',
        'cd.city',
        'cd.pincode',
        'cd.state',
        'cd.phone',
        'cd.updated_by',
        'cd.updated_at',
        'cd.last_comments',
        'cd.outbound',
        'c.contact_id',
        'c.name',
        'c.designation'
    ]);

    if (!empty($where)) {
        $builder->where($where);
    }

    if (!empty($filters['source']) && $filters['source'] !== 'all') {
        $builder->like('cs.notes', $filters['source']);
    }

    $rows = $builder->get()->getResultArray();

    /* ---------------------------
       3. GROUP COMPANIES
    ----------------------------*/

    $grouped = [];
    $maxContacts = 0;

    foreach ($rows as $row) {
        // var_dump($row);


        $cid = $row['company_id'];

        if (!isset($grouped[$cid])) {
            $grouped[$cid] = [
                'details' => $row,
                'contacts'=> []
            ];
        }

        if (!$row['contact_id']) continue;

        $contactId = $row['contact_id'];

        if (!isset($grouped[$cid]['contacts'][$contactId])) {

            $grouped[$cid]['contacts'][$contactId] = [
                'name' => $row['contact_name'],
                'designation' => $row['designation'],
                'emails' => [],
                'mobiles'=> []
            ];
        }

        if ($row['email_address']) {
            $grouped[$cid]['contacts'][$contactId]['emails'] =
                array_unique(explode(', ', $row['email_address']));
        }

        if ($row['mobile_number']) {
            $grouped[$cid]['contacts'][$contactId]['mobiles'] =
                array_unique(explode(', ', $row['mobile_number']));
        }
    }

    foreach ($grouped as $company) {
        $maxContacts = max($maxContacts, count($company['contacts']));
    }

    /* ---------------------------
       4. FILTER QUERIES (FAST)
    ----------------------------*/

    $categories = $db->table('company_data cd')
        ->select('category')
        ->where($where)
        ->groupBy('category')
        ->orderBy('category')
        ->get()->getResultArray();

    $states = $db->table('company_data cd')
        ->select('state')
        ->where($where)
        ->groupBy('state')
        ->orderBy('state')
        ->get()->getResultArray();

    $cities = $db->table('company_data cd')
        ->select('city')
        ->where($where)
        ->groupBy('city')
        ->orderBy('city')
        ->get()->getResultArray();

    $comments = $db->table('company_data cd')
        ->select('last_comments')
        ->where($where)
        ->groupBy('last_comments')
        ->orderBy('last_comments')
        ->get()->getResultArray();

    $sources = $db->table('company_sources cs')
        ->select('notes')
        ->join('company_data cd','cd.company_id = cs.company_id')
        ->where($where)
        ->groupBy('notes')
        ->orderBy('notes')
        ->get()->getResultArray();

    /* convert to simple arrays */

    $categories = array_column($categories,'category');
    $states     = array_column($states,'state');
    $cities     = array_column($cities,'city');
    $comments   = array_column($comments,'last_comments');
    $sources    = array_column($sources,'notes');

    /* ---------------------------
       5. RETURN DATA
    ----------------------------*/
$entry_types = $db->table('company_data')
    ->select('entry_type')
    ->groupBy('entry_type')
    ->orderBy('entry_type')
    ->get()->getResultArray();

$databases = $db->table('company_data')
    ->select('database_name')
    ->groupBy('database_name')
    ->orderBy('database_name')
    ->get()->getResultArray();
    $entry_types = array_column($entry_types, 'entry_type');
$databases   = array_column($databases, 'database_name');
    

$data = 

[
    'companies'     => $grouped,
    'totalCompanies' => count($grouped),

    'maxContacts'   => $maxContacts ?: 1,

    'entry_types'   => $entry_types ?: ['all'],
    'databases'     => $databases ?: ['all'],
    'categories'    => $categories ?: ['all'],
    'states'        => $states ?: ['all'],
    'cities'        => $cities ?: ['all'],
    'comments'      => $comments ?: ['all'],
    'sources'       => $sources ?: ['all'],
    'all'         => $filters['all'] ?? "super",

    'filters'       => $filters
];
// var_dump($data);
// exit;
return $data;


}


public function getDynamicFilters()
{
    // 1. Capture the current selections from AJAX
    $currentFilters = [
        'entrytype' => $this->request->getPost('selEntrytype'),
        'database_name'  => $this->request->getPost('selDatabase'),
        'category'  => $this->request->getPost('selCategory'),
        'source'    => $this->request->getPost('selSource'),
        'state'     => $this->request->getPost('selState'),
        'city'      => $this->request->getPost('selCity'),
        'comment'   => $this->request->getPost('selComment'),
    ];

    // 2. Remove empty / 'all' filters
    $activeFilters = array_filter($currentFilters, fn($v) => !empty($v) && $v !== 'all');

    // 3. Get filtered data
    $result = $this->getCompanySourcesContactsByFilters($activeFilters);
    $companies = $result['companies'] ?? [];

    // 4. Initialize dynamic filter arrays
    $data = [
        // 'selDatabase' => [],
        'selCategory' => [],
        'selSource'   => [],
        'selState'    => [],
        'selCity'     => [],
        'selComment'  => []
    ];

    // 5. Collect unique values from filtered companies
    foreach ($companies as $company) {
        $details = $company['details'];

        // if (!empty($details['database_name'])) $data['selDatabase'][$details['database_name']] = true;
        if (!empty($details['category']))      $data['selCategory'][$details['category']] = true;
        if (!empty($details['source_notes']))  $data['selSource'][$details['source_notes']] = true;
        if (!empty($details['state']))         $data['selState'][$details['state']] = true;
        if (!empty($details['city']))          $data['selCity'][$details['city']] = true;
        if (!empty($details['last_comments'])) $data['selComment'][$details['last_comments']] = true;
    }

    // 6. Prepare final response
    $finalResponse = [
        'options' => [],
        'counts'  => []
    ];

    foreach ($data as $key => $values) {
        $uniqueValues = array_keys($values);
        sort($uniqueValues); // alphabetical
        $finalResponse['options'][$key] = $uniqueValues;
        $finalResponse['counts'][$key]  = count($uniqueValues);
    }

    // 7. Return JSON for AJAX
    return $this->response->setJSON($finalResponse);
}




private function getDistinct($db, $table, $column)
    {
        return array_column(
            $db->table($table)
               ->select($column)
               ->where("$column IS NOT NULL")
               ->distinct()
               ->orderBy($column, 'ASC')
               ->get()
               ->getResultArray(),
            $column
        );
    }




public function downloadDatabase($entry_type,$byvar,$value)
{

var_dump($entry_type,$byvar,$value);
// exit;

    $db = \Config\Database::connect();
    $value = urldecode($value);
    $value = str_replace('-', ' ', $value);

    // Step 1: Fetch long-format data
    $builder = $db->table('company_data cd');
    $builder->select([
        'cd.company_id',
        'cd.company_name',
        'cd.database_name',
        'cd.category',
        'cd.address',
        'cd.city',
        'cd.pincode',
        'cd.state',
        'cd.phone',
        'cd.updated_by',
        'cd.updated_at',
        'cd.last_comments AS comments',
        'cd.outbound',
        'cs.notes AS source',
        'c.contact_id',
        'c.name AS contact_name',
        'c.designation AS contact_designation',
        'cm.mobile_numbers',
        'ce.email_addresses',
        // number contacts per company
        '(SELECT COUNT(*) FROM contact c2 WHERE c2.company_id = c.company_id AND c2.contact_id <= c.contact_id) AS contact_number',
    ]);

    $builder->join('company_sources cs', 'cs.company_id = cd.company_id', 'left');
    $builder->join('contact c', 'c.company_id = cd.company_id', 'left');

    $builder->join('(SELECT contact_id, GROUP_CONCAT(mobile SEPARATOR ", ") AS mobile_numbers FROM contact_mobile GROUP BY contact_id) cm', 'cm.contact_id = c.contact_id', 'left');
    $builder->join('(SELECT contact_id, GROUP_CONCAT(email SEPARATOR ", ") AS email_addresses FROM contact_email GROUP BY contact_id) ce', 'ce.contact_id = c.contact_id', 'left');
if($byvar === 'database_name'){

    $builder->where('cd.database_name', $value);

}else{

    $builder->where('cd.state', $value);

}
    $builder->where('cd.entry_type', $entry_type);

    $query = $builder->get();
    $results = $query->getResultArray();

    // Step 2: Pivot in PHP to expand contacts horizontally
    $companies = [];
    foreach ($results as $row) {
        $companyId = $row['company_id'];
        $contactNum = $row['contact_number'];


        if (!isset($companies[$companyId])) {
            $companies[$companyId] = [
                'entry_type'=> $entry_type,
                'database_name' => $row['database_name'],
                'category' => $row['category'],
                'source' => $row['source'],
                'updated_by' => $row['updated_by'],
                'updated_at' => $row['updated_at'],
                'comments' => $row['comments'],
                'outbound' => $row['outbound'],
                
                'company_name' => $row['company_name'],

                'address' => $row['address'],
                'address2' => '',
                'city' => $row['city'],
                'pincode' => $row['pincode'],
                'state' => $row['state'],
                'phone' => $row['phone'],
                'fax' => '',

            ];
        }

        // dynamically add contact columns
        $companies[$companyId]["contact_{$contactNum}_name"] = $row['contact_name'];
        $companies[$companyId]["contact_{$contactNum}_designation"] = $row['contact_designation'];
        $companies[$companyId]["contact_{$contactNum}_mobile"] = $row['mobile_numbers'];
        $companies[$companyId]["contact_{$contactNum}_email"] = $row['email_addresses'];
    }

    // Step 3: Pass data to view
    return view('company/download', [
        'state' => $byvar,
        'data'  => json_encode(array_values($companies)) // array_values to reset keys
    ]);
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
public function details($type,$companyId = null)
{
    if (!$companyId) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    $companyModel  = new CompanyModel();
    $contactModel  = new ContactModel();
    $updationModel = new UpdationModel();
    $leadModel     = new LeadModel();
    $sourceModel   = new \App\Models\SourceModel();

    // 1. Fetch the composite data (current company + neighbor IDs)
    $result = $companyModel->getByCompanyId($companyId,$type);

    // var_dump($companyId);
    // exit;
    // 2. Validate if the company exists
    if (!$result || !$result['current']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Company not found');
    }

    // 3. Prepare data array
    $data = [
        'type'=> $type,
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

}

public function addexhibitor()
{
     return view('company/insert_exhibitor');}

public function add()
{
     return view('company/add');}




public function add_details()
{
        set_time_limit(300);

    $companies = $this->request->getPost('companies');

// echo "<pre>";
// var_dump($companies);
// echo "</pre>";
    // exit;
    if (empty($companies)) {
        return redirect()->back()->with('status', '⚠️ No company data found!');
    }

    $success = 0;
    $failed  = 0;


foreach ($companies as $index => $company) {
        try {
   
                $entryTypesToInsert = [];

                // var_dump($company['entry_type']); 
                // exit;// Debug: Check the original entry type
                if (!empty($company['entry_type']) && strtolower($company['entry_type']) !== 'main') {
                    // First run with original entry_type
                    
                    // Second run as 'main'
                    $entryTypesToInsert[] = 'main';
$entryTypesToInsert[] = $company['entry_type'];
                    // var_dump($entryTypesToInsert); // Debug: Check the entry types to be inserted
                    // exit; // Uncomment to stop execution and see the result  

                } else {
                    // Only run once with whatever entry_type it has
                    $entryTypesToInsert[] = $company['entry_type'] ?? 'main';
                }
// var_dump($entryTypesToInsert); // Debug: Check the final entry types array before insertion
    // 2. Loop through each entry_type and insert


    foreach ($entryTypesToInsert as $currentType) {
                // var_dump($currentType); // Debug: Check the current entry type being processed
                // exit; // Uncomment to stop execution and see the result
                    $company_id = 'C' . strtoupper(bin2hex(random_bytes(4))); // Generate new company ID
// echo "<pre>";
// var_dump($companies);
// echo "</pre>";
                    $updatedAt = !empty($company['updated_at']) 
                        ? str_replace('T', ' ', $company['updated_at']) . ':00' 
                        : date('Y-m-d H:i:s');

                    $this->companyModel->insert([
                        'session'       => $this->companyModel->get_lastSession(),
                        'entry_type'    => str_replace(' ', '_', $currentType),
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
                        'state'         => $company['state'] ?? "x",
                        'country'       => $company['country'] ?? 'India',
                        'corssvaliation'=> 0,
                    ]);

            $database_name = $company['database_name'] ?? '';
            $entry_type    = $company['entry_type'] ?? '';
            $contact    = $company['contact1_name'] ?? '';
            // var_dump($contact);
            // exit;



            // 1. Break the source by "-"
            $parts = explode('_', $database_name);

            // Normalize part 1
            $part1 = isset($parts[0]) ? strtolower(trim($parts[0])) : 'EMPTY';

            // Normalize part 2 (Safe check to avoid "Offset 1" error)
            $part2 = (count($parts) > 2) ? strtolower(trim($parts[2])) : 'NO HYPHEN FOUND';

            

                    if ($part1 === "Online") {
                        
                    // exit;

                    // 2. Logic for Online Trade Visitor (Single entry)
                        $values = [
                            'company_id' => $company_id,
                            'source_id'  => $company['source_id'] ?? 0,
                            'event_date' => $company['event_date'] ?? date('Y-m-d'),
                            'notes'      => $company['source'], 
                        ];

                        $this->addSource($values);

                    } else {
                // Standard case: split by comma (,) or slash (/)
                $sources = $company['source'];
                // exit;
                                $splitSources = preg_split('/[,\/]+/', $sources); 

                                if($entry_type != "spot"){

                                
                                    foreach ($splitSources as $source) {
                                        $source = trim($source);
                                                    // var_dump($source); // Debug: Check part 2
// exit;
                                        if ($source === '') continue; // Skip empty strings

                                        $values = [
                                            'company_id' => $company_id,
                                            'source_id'  => $company['source_id'] ?? 0,
                                            'event_date' => $company['event_date'] ?? date('Y-m-d'),
                                            'notes'      => $source, // Use the individual split source in notes
                                        ];

                                        // Process each split source
                                        $this->addSource($values);

                                        // var_dump($values);
// exit;
                                    }
                                }

                            }

                                                    // var_dump("super");

                        // Insert contacts dynamically (up to 3 contacts)
                        for ($i = 1; $i <= 3; $i++) {

                            $name = trim($company["contact{$i}_name"] ?? '');
                                var_dump("super");
                                var_dump($company["contact1_name"] );
                                // exit;
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

                            // var_dump($contactData);
                            // exit;
                            // Collect mobiles (up to 3 per contact)
                            for ($m = 1; $m <= 3; $m++) {

                                $mobileKey = "contact{$i}_mobile{$m}";
                                var_dump($contactData);


                                if (!empty($company[$mobileKey])) {
                                    $contactData['mobiles'][] = trim($company[$mobileKey]);
                                
                                
                                    }
                            }

                            // Collect emails (up to 3 per contact)
                            for ($e = 1; $e <= 3; $e++) {

                                $emailKey = "contact{$i}_email{$e}";
                            // exit;

                                if (!empty($company[$emailKey])) {
                                    $contactData['emails'][] = trim($company[$emailKey]);
                                }
                            }

                            // var_dump($contactData);
                            // exit;
                            // Insert contact using your working function
                            $inserted = $this->savePerson($contactData);
                            // var_dump("super1000");
                            // var_dump($inserted);

                            // exit;
                            if ($inserted === true) {
                                $success++;
                            } else {
                                $failed++;
                            }
                        }
                    

                        $allowedCities = [
                            'ahmedabad', 'mumbai', 'delhi', 
                            'bangalore', 'kochi', 'pune', 'hyderabad','kolkata'
                        ];

                    }
// var_dump($note);

if ($database_name === "Registered Exhibitor 2026") {
// var_dump($database_name);
// exit;
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
                                                //  var_dump($location); // will now print each location
                            // exit;
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
                            }

                            // print_r( $data);
                            // print_r( $company['contact1_mobile1']);
                            // var_dump($data);
                            // // exit;

                        return redirect()->to(base_url('registration/regitersuccess') . '/' . $data ."/". $company['contact1_mobile1']);
            
        }

// exit;
// var_dump($entry_type);
// var_dump("Super");
// var_dump($part1);
// var_dump($part2);
// exit;
        if ($entry_type === "spot" || $part1  === "online")
            {

            // var_dump($part1);
            // exit;
            // $crossValidationModel = new \App\Models\CrossValidationModel();
        // var_dump("Super");


            // ✅ Define variables BEFORE using them
            // if ($note === "Spot"){}
            $data   = $part1."-"."registration"."-". $part2;
            $number = $company['contact1_mobile1'] ?? $company['contact1_mobile'] ?? '';
        // var_dump($data);
        // var_dump($number);


            return redirect()->to(base_url('registration/regitersuccess/' . $data . '/' . $number));
        }
        

        }
         catch (\Throwable $e) {
            log_message('error', "Company {$company['company_name']} failed: " . $e->getMessage());
            $failed++;
        }
    }
                // exit;

    return redirect()->to(site_url('company/'.$company['entry_type']."/overview/state"))->with(
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
    // var_dump("super Danger");

    // return $contactData;

    // ✅ If called from form (route)
    if ($contactData === null) {
    // return $contactData;
    // var_dump("super Danger");
    // var_dump($contactData);
    // exit;
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