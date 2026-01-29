<?php
namespace App\Models;
use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company_data';
    protected $primaryKey = 'company_id';
protected $allowedFields = [
    'company_id', 'company_name', 'database_name', 'outbound', 'category',
    'address', 'city', 'pincode', 'state', 'country', 'phone','session'
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

    $builder->groupBy('c.company_id');

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

}
