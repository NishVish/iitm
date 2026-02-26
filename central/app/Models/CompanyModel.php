<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table      = 'company_data';
    protected $primaryKey = 'id'; // Schema says 'id' is the PK
    protected $useAutoIncrement = true;
    
    protected $allowedFields = [
        'company_id', 'database_name', 'outbound', 'company_name', 'category',
        'address', 'city', 'pincode', 'state', 'country', 'phone',
        'gst_number', 'sales_person', 'active_inactive', 'updated_at',
        'last_confirmed_at', 'session', 'cross_validation', 'last_comments',
        'second_last_comments', 'updated_by', 'second_last_comments_updated_by'
    ];

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

    /**
     * Fetches companies with formatted contact strings
     */
    public function getCompaniesWithContacts($state = null, $city = null)
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
        if ($city)  $builder->where('c.city', $city);
        
        $builder->where('c.cross_validation', 0);
        $builder->groupBy('c.company_id');
        $builder->orderBy('c.company_name', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getDistinctStates()
    {
        return $this->select('state')->distinct()->orderBy('state')->findAll();
    }

    public function getCitiesByState($state)
    {
        return $this->select('city')->distinct()->where('state', $state)->orderBy('city')->findAll();
    }

    public function getCountsByStateCategory()
    {
        return $this->select('state, COUNT(*) as total_count')
                    ->select('SUM(CASE WHEN category="Travel Agent" THEN 1 ELSE 0 END) as travel_agents', false)
                    ->select('SUM(CASE WHEN category="Hotel" THEN 1 ELSE 0 END) as hotels', false)
                    ->groupBy('state')
                    ->get()->getResult();
    }

    public function getByCompanyId($companyId)
    {
        return $this->where('company_id', $companyId)->first();
    }

    /**
     * Statistics breakdown by state and category
     */
    public function getCompanyStatistics()
    {
        return $this->select('state, category, COUNT(*) as total_count')
                    ->select('SUM(CASE WHEN category="Travel Agent" THEN 1 ELSE 0 END) AS travel_agents', false)
                    ->select('SUM(CASE WHEN category="Hotel" THEN 1 ELSE 0 END) AS hotels', false)
                    ->groupBy(['state', 'category'])
                    ->get()->getResult();
    }

    /**
     * Duplicates based on Name and Category
     */
    public function getDuplicateCompanies()
    {
        return $this->select('company_name, category, COUNT(*) as total')
                    ->groupBy(['company_name', 'category'])
                    ->having('total >', 1)
                    ->findAll();
    }

    public function getPersonAndCompany($companyId)
    {
        $builder = $this->db->table($this->table . ' c');
        $builder->select('c.company_name, co.name AS contact_name');
        $builder->join('contact co', 'co.company_id = c.company_id', 'left');
        $builder->where('c.company_id', $companyId);
        $builder->orderBy('co.id', 'ASC'); // Assuming contact table has an 'id'
        $builder->limit(1);

        return $builder->get()->getRowArray();
    }
}