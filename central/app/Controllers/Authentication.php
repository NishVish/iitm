<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Authentication extends BaseController
{


public function index()
{
    $session = session();

    if ($session->get('user_id')) {
        return redirect()->to(route_to('home'));
    }

    return view('login');
}

public function login()
{
    $db = \Config\Database::connect();
    $session = session();

    $mobile = $this->request->getPost('mobile_number');
    $otp    = $this->request->getPost('otp'); // Changed from 'password' to 'otp'

    if (empty($mobile) || empty($otp)) {
        return redirect()->back()->with('error', 'Please enter your mobile and the OTP sent to you.');
    }

    // Query to find user by mobile
    $userRecord = $db->table('contact_mobile cm')
        ->select('c.contact_id, c.name, c.otp, c.otp_expiry, cd.*')
        ->join('contact c', 'c.contact_id = cm.contact_id', 'inner')
        ->join('company_data cd', 'cd.company_id = c.company_id', 'inner')
        ->where('cm.mobile', $mobile)
        ->where('cd.active_inactive', 'active')
        ->get()
        ->getRowArray();

    if (!$userRecord) {
        return redirect()->back()->with('error', 'Mobile number not recognized.');
    }

    $currentTime = date('Y-m-d H:i:s');
    
    // Validate OTP only
    if ($userRecord['otp'] === $otp && $currentTime <= $userRecord['otp_expiry']) {
        
        $session->set([
            'isLoggedIn'    => true,
            'user_name'     => $userRecord['name'],
            'contact_id'    => $userRecord['contact_id'],
            'company_id'    => $userRecord['company_id'],
            'company_name'  => $userRecord['company_name'],
            // ... other session data
        ]);

        // Clear OTP so it cannot be reused
        $db->table('contact')->where('contact_id', $userRecord['contact_id'])->update(['otp' => null]);

        return redirect()->to(base_url('mobile/home'));
    } else {
        $error = ($currentTime > $userRecord['otp_expiry']) ? 'OTP has expired.' : 'Invalid OTP.';
        return redirect()->back()->with('error', $error);
    }
}



public function request_otp()
{
    $db = \Config\Database::connect();
    $mobile = $this->request->getPost('mobile_number');

    if (empty($mobile)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Mobile number is required']);
    }

    // 1. Check if the mobile number exists in your contact_mobile table
    $user = $db->table('contact_mobile')
               ->where('mobile', $mobile)
               ->get()
               ->getRow();

    if ($user) {
        // 2. Generate a 6-digit OTP and 10-minute expiry
        $otp = rand(100000, 999999);
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // 3. Update the 'contact' table using the contact_id found
        $updated = $db->table('contact')
                      ->where('contact_id', $user->contact_id)
                      ->update([
                          'otp' => $otp,
                          'otp_expiry' => $expiry
                      ]);

        // send otp to whatsapp using free api

        if ($updated) {
            // Log the OTP to your system log so you can test without SMS
            log_message('debug', "OTP for $mobile is: $otp");

            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'OTP sent successfully' // In production, this triggers SMS
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save OTP']);
        }
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Mobile number not registered']);
    }
}


public function getotp()
{
    $db = \Config\Database::connect();

    // Query to get contacts where OTP is not null
    // We join with mobile so you can see who the OTP belongs to
    $builder = $db->table('contact c');
    $builder->select('c.contact_id, c.name, c.otp, c.otp_expiry, cm.mobile');
    $builder->join('contact_mobile cm', 'cm.contact_id = c.contact_id', 'left');
    $builder->where('c.otp IS NOT NULL');
    $builder->orderBy('c.otp_expiry', 'DESC');
    
    $query = $builder->get();
    $data['otps'] = $query->getResultArray();

    // Send the data to your view
    return view('otp_list_view', $data);
}




    public function loginx()
    {


    $db = \Config\Database::connect();
    $session = session();

// 1. Get POST data
$mobile   = $this->request->getPost('mobile_number');
$password = $this->request->getPost('password');

// 2. Simple hardcoded check for now
if ($mobile == "1234123456" && $password == "1234") {

    // 3. Define the User Name (used in the redirect message)
    $userName = "Nishant";

    // 4. Build Session Data
    $sessionData = [
        'isLoggedIn'    => true,
        'user_name'     => $userName, // Added quotes
        'contact_id'    => 100,
        'company_id'    => 100,
        'company_name'  => "Sphere Travelmedia",
        'database_name' => "Sphere_DB",
        'entry_type'    => "Exhibitor",
        'city'          => "Bangalore",
        'state'         => "Karnataka",
    ];

    // 5. Set the session
    $session->set($sessionData);

    // 6. Redirect to your new dashboard
return redirect()->to(base_url('mobile/home'));

} else {
    // 7. Handle failure
    return redirect()->back()->with('error', 'Invalid Mobile Number or Password');
}

    var_dump($mobile);
    var_dump($password);
    // var_dump($moblie);
    // var_dump($moblie);
    // exit;
    if (empty($mobile) || empty($password)) {
        return redirect()->back()->with('error', 'Please provide both mobile and password.');
    }

    // 2. Find the Contact ID from the mobile number
// $mobileRecord = $db->table('contact_mobile')
//     ->where('mobile', $mobile)
//     ->orderBy('mobile_id', 'DESC')   // latest entry
//     ->limit(1)
//     ->get()
//     ->getRowArray();

    $mobileRecord = $db->table('contact_mobile cm')
    ->select('cm.mobile, c.contact_id, c.name, c.designation, cd.company_id, cd.company_name, cd.entry_type')
    ->join('contact c', 'c.contact_id = cm.contact_id', 'left')
    ->join('company_data cd', 'cd.company_id = c.company_id', 'left')
    ->where('cm.mobile', $mobile)
    ->where('cd.entry_type', 'internal')
    ->orderBy('cm.mobile_id', 'DESC')
    ->limit(1)
    ->get()
    ->getRowArray();


    if (!$mobileRecord) {
        return redirect()->back()->with('error', 'Mobile number not found.');
    }
        var_dump($mobileRecord);
        // exit;

    $contactId = $mobileRecord['contact_id'];

    // 3. Get Contact Name and Company ID
    $contact = $db->table('contact')
                  ->where('contact_id', $contactId)
                  ->get()
                  ->getRowArray();
                  
        // var_dump("contact Test");
        var_dump($contact);

    if (!$contact) {
        return redirect()->back()->with('error', 'No contact associated with this number.');
    }

    $companyId = $contact['company_id'];
    $userName  = $contact['name'];
        var_dump($contact);

    // 4. Validate against company_data
    // Assuming 'password' column exists in company_data or adjust to your actual auth column
    $company = $db->table('company_data')
                  ->where('company_id', $companyId)
                  ->where('active_inactive', 'active')

                  ->get()
                  ->getRowArray();
        var_dump($company);
        // exit;

    // Verification Logic
    // Replace with password_verify($password, $company['password']) if hashed
    if ($company && $password === $company['pin']) { 
        
        // 5. Build Session Data
        $sessionData = [
            'isLoggedIn'    => true,
            'user_name'     => $userName,
            'contact_id'    => $contactId,
            'company_id'    => $companyId,
            'company_name'  => $company['company_name'],
            'database_name' => $company['database_name'],
            'entry_type'    => $company['entry_type'],
            'city'          => $company['city'],
            'state'         => $company['state']
        ];

        $session->set($sessionData);

        var_dump($session);
        // exit;

return redirect()->to(base_url('mobile/home'));
    }


    }


    
    public function backendloginpage()
{
   
        return view('backendlogin');

    // Check if it's a GET request, then return the login view
}




    public function backendloginpost()
{
    $request = service('request');
    $session = session();

        // Retrieve the PIN from the POST request
        $pin = $request->getPost('pin');

        // Fetch user by PIN from the database
        $usersModel = new UserModel();
        $user = $usersModel->getByPin($pin);

        // Get the database name (for session purposes)
        $db = \Config\Database::connect();
        $query = $db->query("SELECT DATABASE() as db");
        $row = $query->getRow();
        $databasename = $row->db;

        // Check if the PIN is for the superuser (hardcoded admin check)
        if ($pin === 'superx' && !$user) {
            // Super user logic
            $sessionData = [
                'authenticated'      => true,
                'user_id'            => 0,
                'employee_id'        => 'SUPER',
                'name'               => 'Super User',
                'designation'        => 'Admin',
                'phone'              => 'N/A',
                'address'            => 'N/A',
                'email'              => 'super@dummy.com',
                'category'           => 'Admin',
                'department'         => 'Admin',
                'doj'                => date('Y-m-d'),
                'uan_no'             => 'N/A',
                'fathers_name'       => 'N/A',
                'aadhaar_card'       => 'N/A',
                'pan_card'           => 'N/A',
                'bank_account_number'=> 'N/A',
                'ifsc_code'          => 'N/A',
                'user_type'          => 'superuser',
                'server'             => $databasename
            ];
            $session->set($sessionData);
            return redirect()->route('home');
        }

        // If a user is found, set the session with their data
        if ($user) {
            // Assuming you have hashed passwords, verify PIN here if needed
            $sessionData = [
                'authenticated'      => true,
                'user_id'            => $user['id'],
                'employee_id'        => $user['employee_id'],
                'name'               => $user['name'],
                'designation'        => $user['designation'],
                'phone'              => $user['phone'],
                'address'            => $user['address'],
                'email'              => $user['email'],
                'category'           => $user['category'],
                'department'         => $user['department'],
                'doj'                => $user['doj'],
                'uan_no'             => $user['uan_no'],
                'fathers_name'       => $user['fathers_name'],
                'aadhaar_card'       => $user['aadhaar_card'],
                'pan_card'           => $user['pan_card'],
                'bank_account_number'=> $user['bank_account_number'],
                'ifsc_code'          => $user['ifsc_code'],
                'user_type'          => $user['user_type'],
                'journal'            => $user['journal'] ?? '',
                'server'             => $databasename
            ];
            $session->set($sessionData);
            return redirect()->route('home');
        } else {
            // Flash error message if no user found
            $session->setFlashdata('error', 'Invalid PIN!');
            return redirect()->to('/backendlogin');
        }
    
}


    // public function logout()
    // {
    //     session()->destroy();
    //     return redirect()->to('/login');
    // }

public function logout()
{
        session()->destroy();

    // Redirect to login page
    return redirect()->route('/');
}

}

