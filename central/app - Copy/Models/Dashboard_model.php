<?php
namespace App\Models;

use CodeIgniter\Model;

class Dashboard_Model extends Model
{
    protected $table = 'company_data';
    protected $primaryKey = 'id';
    protected $allowedFields = ['company_id','company_name','category','address','city','pincode','state','country','phone','gst_number','sales_person','active_inactive'];

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Total companies
    public function get_company_count($search = null)
    {
        $builder = $this->db->table('company_data');
        if($search){
            $builder->like('company_name', $search);
        }
        return $builder->countAllResults();
    }

    // Fetch companies list with optional search & pagination
    public function get_companies($search = null, $limit = 50, $offset = 0)
    {
        $builder = $this->db->table('company_data');
        if($search){
            $builder->like('company_name', $search);
        }
        $builder->orderBy('created_at', 'DESC');
        $builder->limit($limit, $offset);
        return $builder->get()->getResult(); // CI4
    }

    // Total leads/bookings
    public function get_total_leads()
    {
        return $this->db->table('leads')->countAllResults();
    }

    // Payments summary
    public function get_payment_summary()
    {
        $builder = $this->db->table('payments');
        $builder->select('payment_status, COUNT(*) as total, SUM(amount) as total_amount');
        $builder->groupBy('payment_status');
        return $builder->get()->getResult();
    }


// Companies count grouped by database_name
public function get_count_by_database()
{
    return $this->db->table('company_data')
                    ->select('database_name, COUNT(*) as total')
                    ->groupBy('database_name')
                    ->orderBy('database_name', 'ASC')
                    ->get()
                    ->getResult();
}


public function get_count_by_database_and_source()
{
    return $this->db->table('company_data cd')
                    ->select('cd.database_name, cs.notes as source, COUNT(DISTINCT cd.company_id) as total')
                    ->join('company_sources cs', 'cd.company_id = cs.company_id', 'left')
                    ->groupBy(['cd.database_name', 'cs.notes'])
                    ->orderBy('cd.database_name', 'ASC')
                    ->orderBy('cs.notes', 'ASC')
                    ->get()
                    ->getResult();
}
public function leadsstats()
{
    $db = \Config\Database::connect();
    
    // Initialize Models
    $companyModel = new \App\Models\CompanyModel();
    $contactModel = new \App\Models\ContactModel();
    $updationModel = new \App\Models\UpdationModel();
    $leadModel    = new \App\Models\LeadModel();
    $sourceModel  = new \App\Models\SourceModel();

    // 1. Basic Counts (Fixes the "Undefined Variable" errors)
    $data['total_companies']  = $companyModel->countAllResults();
    $data['active_companies'] = $companyModel->where('active_inactive', 'active')->countAllResults();
    $data['total_contacts']   = $contactModel->countAllResults(); // Re-added
    $data['total_leads']      = $leadModel->countAllResults();
    $data['total_updates']    = $updationModel->countAllResults(); // Re-added
    $data['total_sources']    = $sourceModel->countAllResults();   // Re-added

    // 2. Conversion Analysis
    $data['conversion_rate'] = ($data['total_companies'] > 0) 
        ? ($data['total_leads'] / $data['total_companies']) * 100 
        : 0;

    // 3. Staff Performance (Group By)
    $data['staff_performance'] = $companyModel->select('sales_person, COUNT(id) as count')
                                              ->groupBy('sales_person')
                                              ->orderBy('count', 'DESC')
                                              ->findAll();

    // 4. Data Integrity Metric
    $data['validated_count'] = $companyModel->where('cross_validation', 1)->countAllResults();
    
    // 5. Lead Status Breakdown
    $data['lead_status'] = $leadModel->select('status, COUNT(lead_id) as total')
                                     ->groupBy('status')
                                     ->findAll();

    // 6. Recent Activity (Last 30 Days)
    $data['recent_updates'] = $updationModel->where('created_at >=', date('Y-m-d', strtotime('-30 days')))
                                            ->countAllResults();

    // 7. Total Revenue
    $builder = $db->table('lead_locations');
    $builder->selectSum('grand_total');
    $res = $builder->get()->getRow();
    $data['total_revenue'] = $res->grand_total ?? 0;

    return $data;
}




}
