<?php
namespace App\Models;
use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company_data';
    protected $primaryKey = 'company_id';
protected $allowedFields = [
    'company_id', 'company_name', 'database_name', 'outbound', 'category',
    'address', 'city', 'pincode', 'state', 'country', 'phone','session','cross_validation'
];


public function get_lastSession()
{
    $builder = $this->db->table($this->table);

    // Get the last entry's session and created_at
    $builder->select('session, created_at');
    $builder->orderBy('created_at', 'DESC');
    $builder->limit(1);
    $query = $builder->get();
    $lastEntry = $query->getRow();

    if ($lastEntry) {
        $lastSession = $lastEntry->session;
        $lastTime = strtotime($lastEntry->created_at);
        $currentTime = time();

        // If the last entry is within 1 minute, reuse the session
        if (($currentTime - $lastTime) <= 60) {
            return $lastSession;
        }

        // Otherwise, increment session
        return $lastSession + 1;
    }

    // If no session exists, start from 1
    return 1;
}


    // Get companies with concatenated contacts
   // app/Models/CompanyModel.php
public function getCompaniesWithContacts($state = null, $city = null)
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

    // mobiles per contact
    $builder->join(
        '(SELECT contact_id, GROUP_CONCAT(mobile) AS mobiles
          FROM contact_mobile
          GROUP BY contact_id) cm',
        'cm.contact_id = co.contact_id',
        'left'
    );

    // emails per contact
    $builder->join(
        '(SELECT contact_id, GROUP_CONCAT(email) AS emails
          FROM contact_email
          GROUP BY contact_id) ce',
        'ce.contact_id = co.contact_id',
        'left'
    );

    if ($state) {
        $builder->where('c.state', $state);
    }

    if ($city) {
        $builder->where('c.city', $city);
    }
        $builder->where('c.cross_validation', 0);

    $builder->groupBy('c.company_id');
    $builder->orderBy('c.company_name', 'ASC');

    return $builder->get()->getResultArray();
}


    // Get distinct states
public function getDistinctStates()
{
    $builder = $this->db->table('company_data');
    $builder->select('state')->distinct();
    $builder->orderBy('state');
    return $builder->get()->getResultArray();
}

// CompanyModel.php
public function getCitiesByState($state)
{
    $builder = $this->db->table('company_data');
    $builder->select('city')->distinct();
    $builder->where('state', $state);
    $builder->orderBy('city');
    return $builder->get()->getResultArray(); // returns array of ['city' => 'CityName']
}

// --- New method to get counts by state & category ---
    public function getCountsByStateCategory()
    {
        $builder = $this->db->table($this->table);
        $builder->select('state');
        $builder->select('COUNT(*) as total_count', false);
        $builder->select('SUM(category="Travel Agent") as travel_agents', false);
        $builder->select('SUM(category="Hotel") as hotels', false);
        $builder->groupBy('state');

        $query = $builder->get();
        return $query->getResult(); // array of objects
    }

    // --- Existing method to get companies with contacts ---
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

$builder->groupBy('co.contact_id');

    return $builder->get()->getResultArray();
}

public function getByCompanyId($companyId)
{
    return $this->where('company_id', $companyId)->first();
}

public function findPotentialMatches($company)
{
    // Compare $company->company_name + address + city + pincode
    // Use LIKE queries or pull all candidates and run PHP fuzzy matching
}

public function mergeCompanies($existingId, $newId)
{
    // Merge logic: 
    // 1. Move contacts from new to existing
    // 2. Update source table
    // 3. Set new company as inactive
}

public function getCompanies2($search = null)
{
    $builder = $this->db->table('company_data');
    $builder->select('company_id, company_name, category, city'); // include category
    if ($search) {
        $builder->like('company_name', $search);
    }
    return $builder->get()->getResult();
}


 public function getCompanyStatistics()
    {
        $db = $this->db;

        // Count by state and category
        $builder = $db->table($this->table);
        $builder->select('state, category, COUNT(*) as total_count,
                          SUM(CASE WHEN category="Travel Agent" THEN 1 ELSE 0 END) AS travel_agents,
                          SUM(CASE WHEN category="Hotel" THEN 1 ELSE 0 END) AS hotels');
        $builder->groupBy(['state','category']);
        return $builder->get()->getResult();
    }

    // -------------------------------
    // Get duplicate companies
    // -------------------------------
public function getDuplicateCompanies()
{
    $builder = $this->db->table('company_data');
    $builder->select('company_name, category, COUNT(*) as total');
    $builder->groupBy('company_name, category');
    $builder->having('total >', 1);
    return $builder->get()->getResultArray();
}

public function getDuplicateCompaniesCount()
{
    $builder = $this->db->table('company_data');
    $builder->select('COUNT(*) AS total_duplicates')
            ->groupBy('company_name')
            ->having('COUNT(*) > 1');

    $result = $builder->get()->getResultArray();

    // Sum all duplicate entries
    $sum = 0;
    foreach ($result as $row) {
        $sum += $row['total_duplicates'];
    }

    return $sum;
}











}
