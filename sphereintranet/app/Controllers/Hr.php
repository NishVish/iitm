<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\HrModel;

class Hr extends Controller
{
    public function payslip()
    {
        return view('content/hr/payslip');
    }

    public function HrfetchUsers()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll(); // Fetch all users
        return view('content/hr/employee_details', $data);
    }

public function SystemDetails()
{
    $hrModel = new HrModel();
    $data['system_details'] = $hrModel->findAll();

    return view('content/hr/system', $data);
}
public function updateSystemDetails()
{
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // TODO: Process and update your system details here (e.g. DB update)

    // Send JSON response
    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Update successful',
        'data' => $data
    ]);
}


}
