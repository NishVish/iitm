<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Users extends Controller
{

public function addUser()
{
    $userModel = new \App\Models\UserModel();

    // It's good practice to validate and hash passwords in production

    $data = [
        'employee_id'           => $this->request->getPost('employee_id'),
        'name'                  => $this->request->getPost('name'),
        'designation'           => $this->request->getPost('designation'),
        'phone'                 => $this->request->getPost('phone'),
        'address'               => $this->request->getPost('address'),
        'email'                 => $this->request->getPost('email'),
        'password'              => $this->request->getPost('password'), // Consider hashing
        'category'              => $this->request->getPost('category'),
        'department'            => $this->request->getPost('department'),
        'doj'                   => $this->request->getPost('doj'),
        'uan_no'                => $this->request->getPost('uan_no'),
        'fathers_name'          => $this->request->getPost('fathers_name'),
        'aadhaar_card'          => $this->request->getPost('aadhaar_card'),
        'pan_card'              => $this->request->getPost('pan_card'),
        'bank_account_number'   => $this->request->getPost('bank_account_number'),
        'ifsc_code'             => $this->request->getPost('ifsc_code'),
    ];

    $userModel->insert($data);

    return redirect()->to('/home');
}




public function fetchUsers()
{
    $userModel = new \App\Models\UserModel();
    $data = $userModel->findAll();

    return $this->response->setJSON($data);
}



public function updateProfile()
{
    $session = session();
    $userModel = new \App\Models\UserModel();

    $userId = $this->request->getPost('user_id');
    $reqFrom = $this->request->getPost('reqFrom');
    $data = [
        'employee_id'           => $this->request->getPost('employee_id'),
        'name'                  => $this->request->getPost('name'),
        'designation'           => $this->request->getPost('designation'),
        'phone'                 => $this->request->getPost('phone'),
        'email'                 => $this->request->getPost('email'),
        'address'               => $this->request->getPost('address'),
        'category'              => $this->request->getPost('category'),
        'department'            => $this->request->getPost('department'),
        'doj'                   => $this->request->getPost('doj'),
        'uan_no'                => $this->request->getPost('uan_no'),
        'fathers_name'          => $this->request->getPost('fathers_name'),
        'aadhaar_card'          => $this->request->getPost('aadhaar_card'),
        'pan_card'              => $this->request->getPost('pan_card'),
        'bank_account_number'   => $this->request->getPost('bank_account_number'),
        'ifsc_code'             => $this->request->getPost('ifsc_code'),
    ];

    $userModel->update($userId, $data);

    // Update session values
    foreach ($data as $key => $value) {
        $session->set($key, $value);
    }
if ($reqFrom !== null) {
    // Safe to us

         return redirect()->to('hr/employee-details');
 
    }
    return redirect()->to('/home')->with('message', 'Profile updated successfully');
}

public function fetchUserByEmployeeId()
{
    $employeeId = $this->request->getGet('employee_id'); // Fetch from GET request
    
    if (!$employeeId) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Employee ID is required']);
    }
    
    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('employee_id', $employeeId)->first();

    if (!$user) {
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Employee not found']);
    }

    return $this->response->setJSON($user);
}

public function fetchEmployeeIdList()
{
    $userModel = new \App\Models\UserModel();
    $data = $userModel->select('employee_id, name')->findAll();

    return $this->response->setJSON($data); // Must return a plain array
}




}
