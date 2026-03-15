<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends Controller
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UserModel();
    }

    // Display all users
    public function index()
    {
        $data['users'] = $this->usersModel->findAll();
        return view('user/index', $data);
    }

    // Show form to add a new user
    public function create()
    {
        return view('user/create');
    }

    // Save a new user
    public function store()
    {
        $this->usersModel->save([
            'employee_id'       => $this->request->getPost('employee_id'),
            'name'              => $this->request->getPost('name'),
            'designation'       => $this->request->getPost('designation'),
            'phone'             => $this->request->getPost('phone'),
            'address'           => $this->request->getPost('address'),
            'email'             => $this->request->getPost('email'),
            'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'category'          => $this->request->getPost('category'),
            'department'        => $this->request->getPost('department'),
            'doj'               => $this->request->getPost('doj'),
            'uan_no'            => $this->request->getPost('uan_no'),
            'fathers_name'      => $this->request->getPost('fathers_name'),
            'aadhaar_card'      => $this->request->getPost('aadhaar_card'),
            'pan_card'          => $this->request->getPost('pan_card'),
            'bank_account_number' => $this->request->getPost('bank_account_number'),
            'ifsc_code'         => $this->request->getPost('ifsc_code')
        ]);

        return redirect()->to('/user');
    }
public function operation()
{
    $data['users'] = $this->usersModel->findAll();
    return view('user/operation', $data);
}

public function saveOperation()
{
    $post = $this->request->getPost();

    foreach ($post['id'] as $index => $id) {

        $data = [
            'employee_id'        => $post['employee_id'][$index],
            'name'               => $post['name'][$index],
            'designation'        => $post['designation'][$index],
            'phone'              => $post['phone'][$index],
            'address'            => $post['address'][$index],
            'email'              => $post['email'][$index],
            'category'           => $post['category'][$index],
            'department'         => $post['department'][$index],
            'doj'                => $post['doj'][$index],
            'uan_no'             => $post['uan_no'][$index],
            'fathers_name'       => $post['fathers_name'][$index],
            'aadhaar_card'       => $post['aadhaar_card'][$index],
            'pan_card'           => $post['pan_card'][$index],
            'bank_account_number'=> $post['bank_account_number'][$index],
            'ifsc_code'          => $post['ifsc_code'][$index],
            'user_type'          => $post['user_type'][$index],
        ];

        // Only update password if not empty
        if (!empty($post['password'][$index])) {
            $data['password'] = $post['password'][$index];
        }

        $this->usersModel->update($id, $data);
    }

    return redirect()->to('/user/operation');
}
public function saveOperationById($userId)
{
    $post = $this->request->getPost();
    $usersModel = new \App\Models\UserModel();

    $data = [
        'employee_id'        => $post['employee_id'],
        'name'               => $post['name'],
        'designation'        => $post['designation'],
        'phone'              => $post['phone'],
        'address'            => $post['address'],
        'email'              => $post['email'],
        'category'           => $post['category'],
        'department'         => $post['department'],
        'doj'                => $post['doj'],
        'uan_no'             => $post['uan_no'],
        'fathers_name'       => $post['fathers_name'],
        'aadhaar_card'       => $post['aadhaar_card'],
        'pan_card'           => $post['pan_card'],
        'bank_account_number'=> $post['bank_account_number'],
        'ifsc_code'          => $post['ifsc_code'],
        'user_type'          => $post['user_type'],
    ];

    // Only update password if not empty
    if (!empty($post['password'])) {
        $data['password'] = $post['password'];
    }

    $usersModel->update($userId, $data);

    return redirect()->to('/user/operation')->with('success', 'User updated successfully');
}

    // View a single user
    public function show($id)
    {
        $data['user'] = $this->usersModel->find($id);
        return view('user/show', $data);
    }

    // Delete a user
    public function delete($id)
    {
        $this->usersModel->delete($id);
        return redirect()->to('/user');
    }


    public function companyDetails()
    {
        $session = session();

        // var_dump($session);
        // exit;
        $companyId = $session->get('company_id');
        $contactId = $session->get('contact_id');

        $db = \Config\Database::connect();

        $builder = $db->table('company_data cd');

        $builder->select('
    cd.company_id,
    cd.company_name,
    cd.database_name,
    cd.city,
    cd.state,
    cd.entry_type,
    c.contact_id,
    c.name,
    c.designation,
    c.business_card_path,
    c.image,
    ce.email,
    cm.mobile
');

        $builder->join('contact c', 'c.company_id = cd.company_id', 'left');
        $builder->join('contact_email ce', 'ce.contact_id = c.contact_id AND ce.is_primary = 1', 'left');
        $builder->join('contact_mobile cm', 'cm.contact_id = c.contact_id AND cm.is_primary = 1', 'left');

        $builder->where('cd.company_id', $companyId);
        $builder->where('c.contact_id', $contactId);

$query = $builder->get();
$data = $query->getRowArray();

// Return JSON explicitly
return $this->response->setJSON($data ?? []);

    }

 public function uploadProfileImage()
{
    $file = $this->request->getFile('image');

    
if ($file && $file->isValid() && !$file->hasMoved()) {
    // Generate a unique name for the file
    $newName = $file->getRandomName();

    // Define the path to store the file in the public/uploads/contacts/ directory
    $uploadPath = FCPATH . 'public/uploads/contacts/';

    // Ensure the directory exists
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true); // Create the directory if it doesn't exist
    }

    // Move the uploaded file to the public folder
    $file->move($uploadPath, $newName);

    // Optionally, save $newName to the database for this contact
    $session = session();
    $contactId = $session->get('contact_id');
    $db = \Config\Database::connect();
    $builder = $db->table('contact');
    $builder->where('contact_id', $contactId);
    $builder->update(['image' => $newName]);

    // Return a JSON response with the success status and the file URL
    return $this->response->setJSON([
        'success' => true,
        'path' => base_url('public/uploads/contacts/' . $newName) // URL to access the file
    ]);
    }

    return $this->response->setJSON([
        'success' => false,
        'message' => 'Invalid file upload'
    ]);
}


public function uploadBusinessCard()
{
    // Get the uploaded file for the business card
    $file = $this->request->getFile('business_card_image');

    // Check if the file is valid
    if ($file && $file->isValid() && !$file->hasMoved()) {
        // Generate a unique name for the file
        $newName = $file->getRandomName();

        // Define the path to store the file in the public/uploads/contacts/ directory
        $uploadPath = FCPATH . 'public/uploads/contacts/';

        // Ensure the directory exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true); // Create the directory if it doesn't exist
        }

        // Move the uploaded file to the public folder
        $file->move($uploadPath, $newName);

        // Optionally, save $newName (file path) to the database for this contact
        $session = session();
        $contactId = $session->get('contact_id');
        $db = \Config\Database::connect();
        $builder = $db->table('contact');
        $builder->where('contact_id', $contactId);
        $builder->update(['business_card_path' => $newName]);

        // Return the response with the file URL
        $fileUrl = base_url('public/uploads/contacts/' . $newName); // URL to access the file

        return $this->response->setJSON([
            'success' => true,
            'path' => $fileUrl // URL of the uploaded file
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'File upload failed!'
        ]);
    }
}



// In User.php
public function contactImage($filename)
{
    $path = WRITEPATH . 'uploads/contacts/' . $filename;
    if (file_exists($path)) {
        return $this->response->setHeader('Content-Type', mime_content_type($path))
                              ->setBody(file_get_contents($path));
    } else {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}



}


