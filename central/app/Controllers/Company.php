<?php
namespace App\Controllers;
use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\UpdationModel;
use App\Models\LeadModel;

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

        $company = $companyModel->getByCompanyId($companyId);
        if (!$company) throw new \CodeIgniter\Exceptions\PageNotFoundException('Company not found');

        $data = [
            'company'  => $company,
            'contacts' => $contactModel->getByCompanyId($companyId),
            'updates'  => $updationModel->getByCompanyId($companyId),
            'leads'    => $leadModel->getByCompanyId($companyId)
        ];

        return view('company/details', $data);
    }

    public function getCountsByStateCategory()
{
    $builder = $this->db->table('company_data');
    $builder->select('state');
    $builder->select('COUNT(*) as total_count');
    $builder->select('SUM(category="Travel Agent") as travel_agents', false);
    $builder->select('SUM(category="Hotel") as hotels', false);
    $builder->groupBy('state');

    $query = $builder->get();
    return $query->getResult(); // array of objects
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


// 

    public function add()
    {
        $companyModel = new CompanyModel();
        $contactModel = new ContactModel();

        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();

            // Cross-validate with existing companies
            $existing = $companyModel->where('company_name', $post['company_name'])
                                     ->orWhere('gst_number', $post['gst_number'])
                                     ->first();

            if ($existing) {
                // Calculate match fields
                $matches = [];
                foreach ($post as $key => $value) {
                    if (isset($existing[$key]) && $existing[$key] == $value) {
                        $matches[] = $key;
                    }
                }
                $data['conflict'] = $existing;
                $data['matches'] = $matches;
                $data['post'] = $post;
                return view('company/add', $data);
            } else {
                // Insert new company
                $company_id = $companyModel->insert($post);
                
                // Insert contacts if any
                if (!empty($post['contacts'])) {
                    foreach ($post['contacts'] as $contact) {
                        $contact['company_id'] = $company_id;
                        $contactModel->insert($contact);
                    }
                }
                return redirect()->to('/company/list')->with('success','Company added successfully');
            }
        }

        return view('company/add'); // first load, show empty form
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

}