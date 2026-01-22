<?php
namespace App\Models;
use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company_data';
    protected $primaryKey = 'company_id';
        protected $allowedFields = ['company_name', 'category', 'city', 'state'];


    // Get companies with concatenated contacts
   // app/Models/CompanyModel.php
public function getCompaniesWithContacts($state = null, $city = null)
{
    $builder = $this->db->table('company_data c');
    $builder->select('c.company_id, c.company_name, c.category, c.city, c.state, 
                      GROUP_CONCAT(CONCAT(co.name, " (", co.designation, ") - ", co.mobile, " / ", co.email) SEPARATOR "\n") AS contacts', false);
    $builder->join('contact co', 'co.company_id = c.company_id', 'left');

    // Apply filters only if provided
    if ($state !== null && $state !== '') {
        $builder->where('c.state', $state);
    }
    if ($city !== null && $city !== '') {
        $builder->where('c.city', $city);
    }

    $builder->groupBy('c.company_id');
    $query = $builder->get();
    return $query->getResultArray(); // return array so view works
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
        $builder->select('c.company_id, c.company_name, c.category, c.city, c.state, 
                          GROUP_CONCAT(CONCAT(co.name, " (", co.designation, ") - ", co.mobile, " / ", co.email) SEPARATOR "\n") AS contacts', false);
        $builder->join('contact co', 'co.company_id = c.company_id', 'left');
        if($search){
            $builder->like('c.company_name', $search);
            $builder->orLike('c.category', $search);
        }
        $builder->groupBy('c.company_id');
        $query = $builder->get();
        return $query->getResultArray(); // array for view/JSON
    }
public function getByCompanyId($companyId)
{
    return $this->where('company_id', $companyId)->first();
}

}
