<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Authentication extends BaseController
{
    public function index()
    {
        // echo "hello";
        // exit;
        return view("login");
    }

   public function login()
{
    $db = \Config\Database::connect();
    $session = session();

// 1. Get POST data
$mobile   = $this->request->getPost('mobile_number');
$password = $this->request->getPost('password');

// 2. Simple hardcoded check for now
// if ($mobile == "7909075195" && $password == "super1234") {

//     // 3. Define the User Name (used in the redirect message)
//     $userName = "Nishant";

//     // 4. Build Session Data
//     $sessionData = [
//         'isLoggedIn'    => true,
//         'user_name'     => $userName, // Added quotes
//         'contact_id'    => 100,
//         'company_id'    => 100,
//         'company_name'  => "Sphere Travelmedia",
//         'database_name' => "Sphere_DB",
//         'entry_type'    => "Exhibitor",
//         'city'          => "Bangalore",
//         'state'         => "Karnataka",
//     ];

//     // 5. Set the session
//     $session->set($sessionData);

//     // 6. Redirect to your new dashboard
//     return redirect()->to(base_url('mainmenu'))->with('message', "Welcome back, $userName!");

// } else {
//     // 7. Handle failure
//     return redirect()->back()->with('error', 'Invalid Mobile Number or Password');
// }

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

return redirect()->to(base_url('home'));

} else {
        return redirect()->back()->with('error', 'Invalid Credentials or Account Inactive.');
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

