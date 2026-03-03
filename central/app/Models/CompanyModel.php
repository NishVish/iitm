<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table      = 'company_data';
    protected $primaryKey = 'id'; // Schema says 'id' is the PK
    protected $useAutoIncrement = true;
    
    protected $allowedFields = [
        'entry_type',
        'company_id', 'database_name', 'outbound', 'company_name', 'category',
        'address', 'city', 'pincode', 'state', 'country', 'phone',
        'gst_number', 'sales_person', 'active_inactive', 'updated_at',
        'last_confirmed_at', 'session', 'cross_validation', 'last_comments',
        'second_last_comments', 'updated_by', 'second_last_comments_updated_by'
    ];


    // Default entry_type
    protected $defaultType = 'none';

    /**
     * Applies entry_type filter to any query builder
     */
    protected function applyEntryTypeFilter($builder, $type = null)
    {
        $type = $type ?? $this->defaultType;
        return $builder->where('entry_type', $type);
    }
    
    
// Statss Stass Stassts
public function getByVar($params = [])
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data');

    // ----------------------------
    // Pagination Defaults
    // ----------------------------
    $limit  = isset($params['limit']) ? (int)$params['limit'] : 50;
    $page   = isset($params['page']) ? (int)$params['page'] : 1;
    $offset = ($page - 1) * $limit;

    unset($params['limit'], $params['page']);

    // ----------------------------
    // Select
    // ----------------------------
    if (!empty($params['select'])) {
        $builder->select($params['select']);
        unset($params['select']);
    } else {
        $builder->select('*');
    }

    // ----------------------------
    // Search (optional)
    // ----------------------------
    if (!empty($params['search'])) {
        $search = $params['search'];
        unset($params['search']);

        $builder->groupStart()
            ->like('company_name', $search)
            ->orLike('city', $search)
            ->orLike('category', $search)
        ->groupEnd();
    }

    // ----------------------------
    // Filters
    // ----------------------------
    foreach ($params as $key => $value) {
        if (in_array($key, ['group_by', 'order_by'])) continue;

        if (is_array($value)) {
            $builder->whereIn($key, $value);
        } else {
            $builder->where($key, $value);
        }
    }

    // ----------------------------
    // Clone builder for total count
    // ----------------------------
    $countBuilder = clone $builder;
    $total = $countBuilder->countAllResults(false);

    // ----------------------------
    // Group By
    // ----------------------------
    if (!empty($params['group_by'])) {
        $builder->groupBy($params['group_by']);
    }

    // ----------------------------
    // Order By
    // ----------------------------
    if (!empty($params['order_by'])) {
        $builder->orderBy($params['order_by']);
    } else {
        $builder->orderBy('company_id', 'DESC');
    }

    // ----------------------------
    // Apply Limit
    // ----------------------------
    $builder->limit($limit, $offset);

    $data = $builder->get()->getResultArray();

    return [
        'data'  => $data,
        'total' => $total,
        'page'  => $page,
        'limit' => $limit
    ];
}


public function getStatebyDatabase()
{
    // Connect to the database
    $db = \Config\Database::connect();

    // Write your SQL query
    $sql = "
        SELECT 
    database_name,
    state,
    COUNT(*) AS company_count
FROM 
    company_data
GROUP BY 
    database_name, state
ORDER BY 
    database_name, state;    
    ";

    // Execute the query
    $query = $db->query($sql);

    // Return results as an array
    return $query->getResultArray();
}
public function statsByColumn($type = 'all', $groupByColumn = 'state')
{
    // 0. Check if table has any entries at all
$entrytest = $this->builder()
                  ->distinct()
                  ->select('entry_type')
                  ->get()
                  ->getResultArray();

    if (empty($entrytest)) {
        return false; // No entries at all
    }

    // 1. Whitelist allowed group by columns for security
    $allowedColumns = ['state', 'database_name'];
    if (!in_array($groupByColumn, $allowedColumns)) {
        return []; // prevent SQL injection
    }

    // 2. Get distinct categories for the selected type
    if ($type == 'all') {
        $category_query = $this->db->query("SELECT DISTINCT category FROM company_data");
    } else {
        $category_query = $this->db->query(
            "SELECT DISTINCT category FROM company_data WHERE entry_type = ?", 
            [$type]
        );
    }

    $categories = $category_query->getResultArray();

    // 3. If no categories exist for this type, return nothing
    if (empty($categories)) {
        return false; // nothing to display
    }

    // 4. Build dynamic SUM columns
    $dynamic_columns = "";
    foreach ($categories as $row) {
        $cat = addslashes($row['category']);
        $dynamic_columns .= "SUM(IF(category = '$cat', 1, 0)) AS `$cat`, ";
    }

    $dynamic_columns = rtrim($dynamic_columns, ', '); // remove trailing comma

    // 5. Build main query safely
    $sql = "SELECT $groupByColumn";

    if (!empty($dynamic_columns)) {
        $sql .= ", $dynamic_columns";
    }

    $sql .= ", COUNT(*) AS Grand_Total
             FROM company_data";

    if ($type != 'all') {
        $sql .= " WHERE entry_type = " . $this->db->escape($type);
    }

    $sql .= " GROUP BY $groupByColumn
              ORDER BY $groupByColumn ASC";

    // 6. Execute and return
    return $this->db->query($sql)->getResultArray();
}



























































public function getStateAndCategoryStats()
{
    // Connect to the database
    $db = \Config\Database::connect();

    // Write your SQL query
    $sql = "
        SELECT 
            state,
            SUM(CASE WHEN category = 'TA' THEN 1 ELSE 0 END) AS TA_count,
            SUM(CASE WHEN category = 'Hotel' THEN 1 ELSE 0 END) AS Hotel_count,
            SUM(CASE WHEN category NOT IN ('TA', 'Hotel') THEN 1 ELSE 0 END) AS Other_count
        FROM 
            company_data
        GROUP BY 
            state
    ";

    // Execute the query
    $query = $db->query($sql);

    // Return results as an array
    return $query->getResultArray();
}


/**
 * Dashboard & Stats methods with entry_type support
 */
public function getDashboardStats($type = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data');

    // Apply entry_type filter
    if (!$type) $type = $this->defaultType;
    $builder->where('entry_type', $type);

    

    $stats = [];

    // Total Companies
    $stats['total_companies'] = $builder->countAllResults(false);

    // Active Companies
    $stats['active_companies'] = $builder->where('active_inactive', 'active')->countAllResults(false);

    // Inactive Companies
    $stats['inactive_companies'] = $builder->where('active_inactive', 'inactive')->countAllResults(false);

    // Outbound Enabled
    $stats['outbound_enabled'] = $builder->where('outbound', 1)->countAllResults(false);

    // Outbound Disabled
    $stats['outbound_disabled'] = $builder->where('outbound', 0)->countAllResults(false);

    // Created Today
    $stats['created_today'] = $builder->where('DATE(created_at) = CURDATE()', null, false)->countAllResults(false);

    // Created This Month
    $stats['created_this_month'] = $builder
        ->where('MONTH(created_at) = MONTH(CURDATE())', null, false)
        ->where('YEAR(created_at) = YEAR(CURDATE())', null, false)
        ->countAllResults(false);

    // Updated Last 7 Days
    $stats['updated_last_7_days'] = $builder
        ->where('updated_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)', null, false)
        ->countAllResults(false);

    // Companies With Sessions
    $stats['companies_with_sessions'] = $builder->where('session >', 0)->countAllResults(false);

    return $stats;
}

public function getCategoryStats($type = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data');

    $builder->where('entry_type', $type ?? $this->defaultType);

    return $builder->select('category, COUNT(*) as total')
                   ->groupBy('category')
                   ->orderBy('total', 'DESC')
                   ->get()
                   ->getResultArray();
}

public function getStateStats($type = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data');

    $builder->where('entry_type', $type ?? $this->defaultType);

    return $builder->select('state, COUNT(*) as total')
                   ->groupBy('state')
                   ->orderBy('total', 'DESC')
                   ->get()
                   ->getResultArray();
}

public function getCountryStats($type = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data');

    $builder->where('entry_type', $type ?? $this->defaultType);

    return $builder->select('country, COUNT(*) as total')
                   ->groupBy('country')
                   ->orderBy('total', 'DESC')
                   ->get()
                   ->getResultArray();
}

public function getSalesPersonStats($type = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data');

    $builder->where('entry_type', $type ?? $this->defaultType);

    return $builder->select('sales_person, COUNT(*) as total')
                   ->groupBy('sales_person')
                   ->orderBy('total', 'DESC')
                   ->get()
                   ->getResultArray();
}

public function getCrossValidationStats($type = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('company_data');

    $builder->where('entry_type', $type ?? $this->defaultType);

    return $builder->select('cross_validation, COUNT(*) as total')
                   ->groupBy('cross_validation')
                   ->get()
                   ->getResultArray();
}
    /**
     * Reuses session if last entry was < 60 seconds ago, otherwise increments.
     */
    public function get_lastSession()
    {
        $lastEntry = $this->select('session, created_at')
                          ->orderBy('created_at', 'DESC')
                          ->first();

        if ($lastEntry) {
            $lastSession = (int)$lastEntry['session'];
            $lastTime    = strtotime($lastEntry['created_at']);
            
            // If within 1 minute, reuse session
            if ((time() - $lastTime) <= 60) {
                return $lastSession;
            }
            return $lastSession + 1;
        }

        return 1;
    }

    public function getCompaniesWithContacts($state = null, $city = null, $type = null)
    {
        $builder = $this->db->table($this->table . ' c');

        $builder->select('
            c.session,
            c.company_id,
            c.company_name,
            c.category,
            c.city,
            c.state,
            GROUP_CONCAT(
                DISTINCT CONCAT(
                    co.name, " (", IFNULL(co.designation, "N/A"), ")",
                    " | Mobiles: ", IFNULL(cm.mobiles, "N/A"),
                    " | Emails: ", IFNULL(ce.emails, "N/A")
                )
                SEPARATOR "\n"
            ) AS contacts
        ', false);

        $builder->join('contact co', 'co.company_id = c.company_id', 'left');

        // Subquery for mobiles
        $builder->join(
            '(SELECT contact_id, GROUP_CONCAT(mobile) AS mobiles FROM contact_mobile GROUP BY contact_id) cm',
            'cm.contact_id = co.contact_id',
            'left'
        );

        // Subquery for emails
        $builder->join(
            '(SELECT contact_id, GROUP_CONCAT(email) AS emails FROM contact_email GROUP BY contact_id) ce',
            'ce.contact_id = co.contact_id',
            'left'
        );

        if ($state) $builder->where('c.state', $state);
        if ($city) $builder->where('c.city', $city);

        // Only general entries unless type is specified
        $builder = $this->applyEntryTypeFilter($builder, $type);

        $builder->where('c.cross_validation', 0);
        $builder->groupBy('c.company_id');
        $builder->orderBy('c.company_name', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getDistinctStates($type = null)
    {
        $builder = $this->builder();
        $builder = $this->applyEntryTypeFilter($builder, $type);

        return $builder->select('state')->distinct()->orderBy('state')->get()->getResultArray();
    }

    public function getCitiesByState($state, $type = null)
    {
        $builder = $this->builder();
        $builder = $this->applyEntryTypeFilter($builder, $type);

        return $builder->select('city')->distinct()
                       ->where('state', $state)
                       ->orderBy('city')
                       ->get()
                       ->getResultArray();
    }

    public function getCountsByStateCategory($type = null)
    {
        $builder = $this->builder();
        $builder = $this->applyEntryTypeFilter($builder, $type);

        return $builder->select('state, COUNT(*) as total_count')
                       ->select('SUM(CASE WHEN category="Travel Agent" THEN 1 ELSE 0 END) as travel_agents', false)
                       ->select('SUM(CASE WHEN category="Hotel" THEN 1 ELSE 0 END) as hotels', false)
                       ->groupBy('state')
                       ->get()
                       ->getResultArray();
    }

 public function getByCompanyId($companyId, $type = null)
{
    // 1. Get Current Record
    $current = $this->where('company_id', $companyId)->first();
    if (!$current) return null;

    $state = $current['state'];
    $name  = $current['company_name'];
    $type  = $current['entry_type'] ?? $type;

    // 2. Fetch Previous Record (Resetting conditions)
    $prev = $this->builder()
                ->where(['state' => $state, 'entry_type' => $type])
                ->where('company_name <', $name)
                ->orderBy('company_name', 'DESC')
                ->select('company_id')
                ->get(1) // Limit 1
                ->getRowArray();

    // 3. Fetch Next Record (Fresh builder instance)
    $next = $this->builder()
                ->where(['state' => $state, 'entry_type' => $type])
                ->where('company_name >', $name)
                ->orderBy('company_name', 'ASC')
                ->select('company_id')
                ->get(1)
                ->getRowArray();

    return [
        'current' => $current,
        'prev_id' => $prev['company_id'] ?? null,
        'next_id' => $next['company_id'] ?? null
    ];
}
    public function getCompanyStatistics($type = null)
    {
        $builder = $this->builder();
        $builder = $this->applyEntryTypeFilter($builder, $type);

        return $builder->select('state, category, COUNT(*) as total_count')
                       ->select('SUM(CASE WHEN category="Travel Agent" THEN 1 ELSE 0 END) AS travel_agents', false)
                       ->select('SUM(CASE WHEN category="Hotel" THEN 1 ELSE 0 END) AS hotels', false)
                       ->groupBy(['state','category'])
                       ->get()
                       ->getResultArray();
    }

    public function getDuplicateCompanies($type = null)
    {
        $builder = $this->builder();
        $builder = $this->applyEntryTypeFilter($builder, $type);

        return $builder->select('company_name, category, COUNT(*) as total')
                       ->groupBy(['company_name','category'])
                       ->having('total >', 1)
                       ->get()
                       ->getResultArray();
    }

    public function getPersonAndCompany($companyId, $type = null)
    {
        $builder = $this->db->table($this->table . ' c');
        $builder = $this->applyEntryTypeFilter($builder, $type);

        $builder->select('c.company_name, co.name AS contact_name')
                ->join('contact co', 'co.company_id = c.company_id', 'left')
                ->where('c.company_id', $companyId)
                ->orderBy('co.id', 'ASC')
                ->limit(1);

        return $builder->get()->getRowArray();
    }
}