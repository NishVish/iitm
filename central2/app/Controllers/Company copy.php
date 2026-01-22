<!-- <?php
// namespace App\Controllers;
// use App\Models\CompanyModel;
// use App\Models\ContactModel;
// use App\Models\UpdationModel;
// use App\Models\LeadModel;

// class Company extends BaseController
// {
//     protected $companyModel;

//     public function __construct()
//     {
//         $this->companyModel = new CompanyModel();
//     }

//     // Main page
// public function index()
// {
//     $companies = $this->companyModel->getCompaniesWithContacts();
//     $states    = $this->companyModel->getDistinctStates();

//     $data = [
//         'title' => 'All Companies',
//         'companies' => $companies,
//         'states' => $states
//     ];

//     return view('company/index', $data);
// }


//     // AJAX: get cities by state
// // Company.php
// public function getCities()
// {
//     $state = $this->request->getPost('state');
//     if (!$state) {
//         return $this->response->setJSON([]);
//     }

//     $cities = $this->companyModel->getCitiesByState($state); // use companyModel
//     return $this->response->setJSON($cities);
// }

//     // AJAX: filter companies by state & city
// public function filterCompanies()
// {
//     $state = $this->request->getPost('state');
//     $state = ($state === '') ? null : $state;

//     $city = $this->request->getPost('city');
//     $city = ($city === '') ? null : $city;

//     $companies = $this->companyModel->getCompaniesWithContacts($state, $city);

//     return $this->response->setJSON($companies);
// }



//     // Details of single company
//     public function details($companyId = null)
//     {
//         if (!$companyId) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

//         $companyModel  = new CompanyModel();
//         $contactModel  = new ContactModel();
//         $updationModel = new UpdationModel();
//         $leadModel     = new LeadModel();

//         $company = $companyModel->getByCompanyId($companyId);
//         if (!$company) throw new \CodeIgniter\Exceptions\PageNotFoundException('Company not found');

//         $data = [
//             'company'  => $company,
//             'contacts' => $contactModel->getByCompanyId($companyId),
//             'updates'  => $updationModel->getByCompanyId($companyId),
//             'leads'    => $leadModel->getByCompanyId($companyId)
//         ];

//         return view('company/details', $data);
//     }

//     public function getCountsByStateCategory()
// {
//     $builder = $this->db->table('company_data');
//     $builder->select('state');
//     $builder->select('COUNT(*) as total_count');
//     $builder->select('SUM(category="Travel Agent") as travel_agents', false);
//     $builder->select('SUM(category="Hotel") as hotels', false);
//     $builder->groupBy('state');

//     $query = $builder->get();
//     return $query->getResult(); // array of objects
// }

// /**
//  * Get companies, optionally filtered by search term
//  */
// public function getCompanies($search = null)
// {
//     $builder = $this->db->table('company_data c');
//     $builder->select('c.company_id, c.company_name, c.category, c.city, c.state, 
//                       GROUP_CONCAT(CONCAT(co.name, " (", co.designation, ") - ", co.mobile, " / ", co.email) SEPARATOR "\n") AS contacts', false);
//     $builder->join('contact co', 'co.company_id = c.company_id', 'left');
//     if($search){
//         $builder->like('c.company_name', $search);
//         $builder->orLike('c.category', $search);
//     }
//     $builder->groupBy('c.company_id');
//     $query = $builder->get();
//     return $query->getResultArray(); // array for view/JSON
// }

//     public function details($companyId = null)
//     {
//         if (!$companyId) {
//             throw new \CodeIgniter\Exceptions\PageNotFoundException();
//         }

//         $companyModel  = new CompanyModel();
//         $contactModel  = new ContactModel();
//         $updationModel = new UpdationModel();
//         $leadModel     = new LeadModel();

//         $company = $companyModel->getByCompanyId($companyId);

//         if (!$company) {
//             throw new \CodeIgniter\Exceptions\PageNotFoundException('Company not found');
//         }

//         $data = [
//             'company'   => $company,
//             'contacts'  => $contactModel->getByCompanyId($companyId),
//             'updates'   => $updationModel->getByCompanyId($companyId),
//             'leads'     => $leadModel->getByCompanyId($companyId)
//         ];

//         return view('company/details', $data);
//} -->
