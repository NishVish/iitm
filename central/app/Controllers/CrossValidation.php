<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\UpdationModel;
use App\Models\SourceModel;
use App\Models\ContactEmailModel;
use App\Models\ContactMobileModel;
use App\Models\MatchingSessionModel;

class CrossValidation extends Controller
{
    protected $companyModel;
    protected $contactModel;
    protected $sourceModel;
    protected $updationModel;
protected $db;

    public function __construct()
    {
        // Initialize models
            $this->db = \Config\Database::connect();

        $this->companyModel   = new CompanyModel();
        $this->contactModel   = new ContactModel();
        $this->sourceModel    = new SourceModel();
        $this->updationModel  = new UpdationModel();
        $this->matchingSessionModel  = new MatchingSessionModel();
}
public function index()
{
    $db = \Config\Database::connect();

$companyMatches = $db->table('matching_session as ms')
    ->select('ms.*, 
              c1.company_id as original_company_id,
              c1.database_name as original_database_name,
              c1.outbound as original_outbound,
              c1.company_name as original_company_name,
              c1.category as original_category,
              c1.address as original_address,
              c1.city as original_city,
              c1.pincode as original_pincode,
              c1.state as original_state,
              c1.country as original_country,
              c1.phone as original_phone,
              c1.gst_number as original_gst_number,
              c1.sales_person as original_sales_person,
              c1.active_inactive as original_active_inactive,
              c1.created_at as original_created_at,
              c1.updated_at as original_updated_at,
              c1.last_confirmed_at as original_last_confirmed_at,
              c1.session as original_session,
              c1.cross_validation as orignal_cross_validation,
              
              c2.company_id as matched_company_id,
              c2.database_name as matched_database_name,
              c2.outbound as matched_outbound,
              c2.company_name as matched_company_name,
              c2.category as matched_category,
              c2.address as matched_address,
              c2.city as matched_city,
              c2.pincode as matched_pincode,
              c2.state as matched_state,
              c2.country as matched_country,
              c2.phone as matched_phone,
              c2.gst_number as matched_gst_number,
              c2.sales_person as matched_sales_person,
              c2.active_inactive as matched_active_inactive,
              c2.created_at as matched_created_at,
              c2.updated_at as matched_updated_at,
              c2.last_confirmed_at as matched_last_confirmed_at,
              c2.cross_validation as matched_cross_validation,
              c2.session as matched_session')
    ->join('company_data c1', 'ms.company_id = c1.company_id')
    ->join('company_data c2', 'ms.matching_company_id = c2.company_id')
    ->get()
    ->getResultArray();



    // ---------------- Contact Matches ----------------
    $contactMatches = $db->table('matching_contact_session as mcs')
        ->select('mcs.*, 
                  c1.name as original_name, c1.designation as original_designation,
                  c2.name as matched_name, c2.designation as matched_designation')
        ->join('contact c1', 'mcs.contact_id = c1.contact_id')
        ->join('contact c2', 'mcs.matching_contact_id = c2.contact_id')
        ->get()->getResultArray();

// Fetch emails (take first email per contact)
$emailRows = $db->table('contact_email')->select('contact_id, email')->orderBy('email_id', 'ASC')->get()->getResultArray();
$emailMap = [];
foreach ($emailRows as $row) {
    if (!isset($emailMap[$row['contact_id']])) {
        $emailMap[$row['contact_id']] = $row['email']; // first email for this contact
    }
}

// Fetch mobiles (take first mobile per contact)
$mobileRows = $db->table('contact_mobile')->select('contact_id, mobile')->orderBy('mobile_id', 'ASC')->get()->getResultArray();
$mobileMap = [];
foreach ($mobileRows as $row) {
    if (!isset($mobileMap[$row['contact_id']])) {
        $mobileMap[$row['contact_id']] = $row['mobile']; // first mobile for this contact
    }
}


    // ---------------- Attach emails/mobiles to contact matches ----------------
    foreach ($contactMatches as &$match) {
        $match['original_email'] = $emailMap[$match['contact_id']] ?? 'N/A';
        $match['original_mobile'] = $mobileMap[$match['contact_id']] ?? 'N/A';
        $match['matched_email'] = $emailMap[$match['matching_contact_id']] ?? 'N/A';
        $match['matched_mobile'] = $mobileMap[$match['matching_contact_id']] ?? 'N/A';
    }

    return view('crossvalidation/index', [
        'company_matches' => $companyMatches,
        'contact_matches' => $contactMatches
    ]);
}


// public function index()
// {
//     $db = \Config\Database::connect();

//     // ---------------- Company Matches ----------------
//     $companyMatches = $db->table('matching_session as ms')
//         ->select('ms.*, c1.company_name as original_name, c1.address as original_address, c1.city as original_city, c1.phone as original_phone,
//                   c2.company_name as matched_name, c2.address as matched_address, c2.city as matched_city, c2.phone as matched_phone')
//         ->join('company_data c1', 'ms.company_id = c1.id')
//         ->join('company_data c2', 'ms.matching_company_id = c2.id')
//         ->get()->getResultArray();

//     // ---------------- Contact Matches ----------------
//     $contactMatches = $db->table('matching_contact_session as mcs')
//         ->select('mcs.*, c1.name as original_name, c1.designation as original_designation, ce1.email as original_email, cm1.mobile as original_mobile,
//                   c2.name as matched_name, c2.designation as matched_designation, ce2.email as matched_email, cm2.mobile as matched_mobile')
//         ->join('contact c1', 'mcs.contact_id = c1.contact_id')
//         ->join('contact c2', 'mcs.matching_contact_id = c2.contact_id')
//         ->join('contact_email ce1', 'c1.contact_id = ce1.contact_id AND ce1.is_primary = 1', 'left')
//         ->join('contact_email ce2', 'c2.contact_id = ce2.contact_id AND ce2.is_primary = 1', 'left')
//         ->join('contact_mobile cm1', 'c1.contact_id = cm1.contact_id AND cm1.is_primary = 1', 'left')
//         ->join('contact_mobile cm2', 'c2.contact_id = cm2.contact_id AND cm2.is_primary = 1', 'left')
//         ->get()->getResultArray();

//     return view('crossvalidation/index', [
//         'company_matches' => $companyMatches,
//         'contact_matches' => $contactMatches
//     ]);
// }

public function clearMatches(){
    $db = \Config\Database::connect();

        // -------------------- 1. Company Matching --------------------
        $db->table('matching_session')->truncate();
    return $this->index(); // show the index page with all results
}
public function clearMatchesContact(){
    $db = \Config\Database::connect();

        // -------------------- 1. Company Matching --------------------
        $db->table('matching_contact_session')->truncate();
    return $this->index(); // show the index page with all results
}
    /**
     * Run full cross-validation for companies + contacts
     */
    public function companyCrossValidation()
    {
        $db = \Config\Database::connect();

        // -------------------- 1. Company Matching --------------------
        $db->table('matching_session')->truncate();
        $companies = $this->companyModel->findAll();
        $count = count($companies);

        for ($i = 0; $i < $count; $i++) {
            $newRow = $companies[$i];
            $newId = $newRow['company_id'];
            $newName = $newRow['company_name'];
            $newAddress = $newRow['address'];
            $newCity = $newRow['city'];
            $newPin = $newRow['pincode'];

            for ($j = 0; $j < $count; $j++) {
                $dbRow = $companies[$j];
                $dbId = $dbRow['company_id'];

                if ($newId >= $dbId) continue; // skip self & mirror

                $dbName = $dbRow['company_name'];
                $dbAddress = $dbRow['address'];
                $dbCity = $dbRow['city'];
                $dbPin = $dbRow['pincode'];

                // Scores
                $nameScore = $this->fuzzyMatch($newName, $dbName);
                $addressScore = $this->fuzzyMatch($newAddress, $dbAddress);
                $cityScore = $this->fuzzyMatch($newCity, $dbCity);
                if ($newPin === $dbPin) {
                    // If both are the same (including both empty), score 100
                    $pinScore = 100;
                } elseif ($newPin === '' && $dbPin === '') {
                    // Both empty → also 100
                    $pinScore = 100;
                } else {
                    $pinScore = 0;
                }

                $pinScore = ($newPin === $dbPin && $newPin !== '') ? 100 : 0;
                $totalScore = round(($nameScore + $addressScore + $pinScore) / 3);

                // Match type
                if ($nameScore === 100 && $addressScore === 100 && $pinScore === 100) {
                    $matchingType = 'exact match';
                } elseif ($totalScore >= 50) {
                    $matchingType = 'partial match';
                } else {
                    $matchingType = 'no match';
                }
                // echo $newId. "sss" . $dbId;
                
            $companyOverwrite = true;

            // -------------------- Step 1: Minimum eligibility --------------------
            $passesMinimum =
                $companyOverwrite &&
                $nameScore >= 70 &&
                $addressScore >= 50 &&
                $pinScore >= 50;

            if ($passesMinimum) {

                // -------------------- Step 2: Strong match → overwrite --------------------
                $isStrongMatch =
                    $nameScore >= 80 &&
                    $addressScore >= 60 &&
                    $pinScore === 100;

                if ($isStrongMatch) {
                    $this->overwriteCompany($newId, $dbId);
                } 
                // -------------------- Step 3: Weak/medium match → store for manual validation --------------------
                elseif ($matchingType !== 'no match' && !$dbRow['cross_validation']) {
                    $db->table('matching_session')->insert([
                        'company_id'           => $newId,
                        'matching_company_id'  => $dbId,
                        'matching_type'        => $matchingType,
                        'name'                 => $nameScore,
                        'address'              => $addressScore,
                        'city'                 => $addressScore,
                        'pin'                  => $pinScore,
                    ]);
                }

            } // end passesMinimum check
        }
    }

    // -------------------- 3. Return results --------------------
return redirect()->back();
}



   public function contactCrossValidation()
{
    $db = \Config\Database::connect();

    // Clear previous matches
    $db->table('matching_contact_session')->truncate();

    // Fetch all contacts
    $contacts = $this->contactModel->findAll();
    $countContacts = count($contacts);

    // Fetch all emails
    $emailRows = $db->table('contact_email')->get()->getResultArray();
    $emails = [];
    foreach ($emailRows as $row) {
        $emails[$row['contact_id']][] = $row['email'];
    }

    // Fetch all mobiles
    $mobileRows = $db->table('contact_mobile')->get()->getResultArray();
    $mobiles = [];
    foreach ($mobileRows as $row) {
        $mobiles[$row['contact_id']][] = $row['mobile'];
    }

    for ($i = 0; $i < $countContacts; $i++) {
        $newContact = $contacts[$i];
        $newId = $newContact['contact_id'];
        $newName = $newContact['name'];
        $newDesignation = $newContact['designation'];
        $newEmails = $emails[$newId] ?? [];
        $newMobiles = $mobiles[$newId] ?? [];
        $newCompanyId = $newContact['company_id'];

        for ($j = 0; $j < $countContacts; $j++) {
            $dbContact = $contacts[$j];
            $dbId = $dbContact['contact_id'];

            if ($newId >= $dbId) continue; // skip self & mirror

            $dbName = $dbContact['name'];
            $dbDesignation = $dbContact['designation'];
            $dbEmails = $emails[$dbId] ?? [];
            $dbMobiles = $mobiles[$dbId] ?? [];
            $dbCompanyId = $dbContact['company_id'];

            // Scores
            $nameScore = $this->fuzzyMatch($newName, $dbName);
            $designationScore = $this->fuzzyMatch($newDesignation, $dbDesignation);

            // Email match (exact match with any email)
            $emailScore = 0;
            foreach ($newEmails as $ne) {
                foreach ($dbEmails as $de) {
                    if (strtolower($ne) === strtolower($de)) {
                        $emailScore = 100;
                        break 2;
                    }
                }
            }

            // Mobile match (exact match with any mobile)
            $mobileScore = 0;
            foreach ($newMobiles as $nm) {
                foreach ($dbMobiles as $dm) {
                    if ($nm === $dm) {
                        $mobileScore = 100;
                        break 2;
                    }
                }
            }

            $totalScore = round(($nameScore + $designationScore + $emailScore + $mobileScore) / 4);

            // Match type
            if ($nameScore === 100 && $designationScore === 100 && $emailScore === 100 && $mobileScore === 100) {
                $matchingType = 'exact match';
            } elseif ($totalScore >= 50) {
                $matchingType = 'partial match';
            } else {
                $matchingType = 'no match';
            }

            if ($matchingType !== 'no match') {
                $db->table('matching_contact_session')->insert([
                    'contact_id' => $newId,
                    'matching_contact_id' => $dbId,
                    'company_id' => $newCompanyId,
                    'matching_company_id' => $dbCompanyId,
                    'matching_type' => $matchingType,
                    'name' => $nameScore,
                    'designation' => $designationScore,
                    'email' => $emailScore,
                    'mobile' => $mobileScore
                ]);
            }

//                 $db->table('matching_contact_session')
//    ->groupStart()
//        ->where('name', '100')
//        ->orWhere('email', '100')
//        ->orWhere('mobile', '100')
//        ->orWhere('designation', '100')
//    ->groupEnd()
//    ->delete();


        }
    }

    return $this->index(); // show the results
}



    /**
     * Fuzzy match helper
     */
    private function fuzzyMatch($str1, $str2)
    {
        if (empty($str1) || empty($str2)) return 0;
        similar_text(strtolower($str1), strtolower($str2), $percent);
        return round($percent);
    }

    /**
     * Show results for both company & contact sessions
     */
    private function showMatchingResults()
    {
        $db = \Config\Database::connect();
        $companyMatches = $db->table('matching_session')->get()->getResultArray();
        $contactMatches = $db->table('matching_contact_session')->get()->getResultArray();

        return view('matching_session_view', [
            'company_matches' => $companyMatches,
            'contact_matches' => $contactMatches
        ]);
    }

public function handleAction()
{
    $request = $this->request->getPost();

    // ✅ Safe fetch of POST values
    $type = $request['type'] ?? null;           // company or contact
    $id = $request['id'] ?? null;               // target company/contact ID
    $matchId = $request['match_id'] ?? null;    // matching company/contact ID
    $action = $request['action'] ?? null;       // overwrite / merge / skip

if ($type === 'all') {
    echo "TYPE OK<br>";

    if ($action === 'overwrite') {
    $this->overwriteCompany($id, $matchId);
    }


    // // Validate required parameters
    // if (!$type || !$id || !$matchId || !$action) {
    //     return redirect()->back()->with('error', 'Missing required request parameters.');
    // }

    // // If IDs are the same, no action is needed
    // if ($id == $matchId) {
    //     return redirect()->back()->with('info', 'Target and matching company are the same.');
    // }

    // // Fetch matching company
    // $matchingCompany = $this->companyModel->find($matchId);
    // if (!$matchingCompany) {
    //     return redirect()->back()->with('error', 'Matching company not found.');
    // }

    // -----------------------------
// if ($type === 'all') {

// if($action === 'overwrite'){
//     // echo "hello";
//     // exit;
//     // Start transaction using one of the models
//     $this->companyModel->db->transStart();

//     // 1️⃣ Update related tables
//     $this->sourceModel
//         ->where('company_id', $matchId)
//         ->set('company_id', $id)
//         ->update();
//     // Then, insert a new record with custom notes
//     // $this->sourceModel->insert([
//     //     'company_id'  => $id,
//     //     'source_id'   => 55,         // set this to your relevant source_id
//     //     'event_date'  => date('Y-m-d'),     // or your custom date
//     //     'notes'       => 'Custom text here' // your custom message
//     // ]);


//     $this->updationModel
//         ->where('company_id', $matchId)
//         ->set('company_id', $id)
//         ->update();

//     // 2️⃣ Get current company data
//     $before = $this->companyModel->find($id);
//     if (!$before) throw new \Exception("Company ID {$id} not found");

//     // 3️⃣ Update target company
//     $updateData = [
//         'company_name' => $matchingCompany['company_name'] ?? $before['company_name'],
//         'category'     => $matchingCompany['category'] ?? $before['category'],
//         'address'      => $matchingCompany['address'] ?? $before['address'],
//         'city'         => $matchingCompany['city'] ?? $before['city'],
//         'pincode'      => $matchingCompany['pincode'] ?? $before['pincode'],
//         'state'        => $matchingCompany['state'] ?? $before['state'],
//         'updated_at'   => date('Y-m-d H:i:s')
//     ];
//     $this->companyModel->update($id, $updateData);
//     // echo $updateData;
//     // exit;

//     $after = $this->companyModel->find($id);

//     // 4️⃣ Delete matching session
//     $this->matchingSessionModel
//         ->where('company_id', $id)
//         ->where('matching_company_id', $matchId)
//         ->delete();

//     // Complete transaction
//     $this->companyModel->db->transComplete();

//     if ($this->companyModel->db->transStatus() === false) {
//         throw new \Exception("Company overwrite transaction failed");
//     }

//     log_message('info', "Company ID {$id} updated successfully. Before: " . json_encode($before) . " | After: " . json_encode($after));


//     }


    // -----------------------------
    // 2️⃣ Merge logic
    // -----------------------------
    elseif ($type === 'company') {
        // Example: combine addresses instead of overwriting
        $targetCompany = $this->companyModel->find($id);
        if ($targetCompany) {
            $mergedAddress = trim($targetCompany['address'] . ', ' . $matchingCompany['address']);
            $this->companyModel
                ->where('id', $id)
                ->set([
                    'address' => $mergedAddress,
                    // merge other fields if needed
                ])
                ->update();
        }

        // Merge sources/updation tables
        $this->sourceModel
            ->where('company_id', $matchId)
            ->set('company_id', $id)
            ->update();
        $this->updationModel
            ->where('company_id', $matchId)
            ->set('company_id', $id)
            ->update();
    }

    // -----------------------------
    // 3️⃣ Skip logic
    // -----------------------------
    elseif ($action === 'skip') {
        // Do nothing
    }

}



    // -----------------------------
    // 2️⃣ Merge logic
    // -----------------------------
    elseif ($action === 'merge' && $type === 'company') {
        // Example: combine addresses instead of overwriting
        $targetCompany = $this->companyModel->find($id);
        if ($targetCompany) {
            $mergedAddress = trim($targetCompany['address'] . ', ' . $matchingCompany['address']);
            $this->companyModel
                ->where('id', $id)
                ->set([
                    'address' => $mergedAddress,
                    // merge other fields if needed
                ])
                ->update();
        }

        // Merge sources/updation tables
        $this->sourceModel
            ->where('company_id', $matchId)
            ->set('company_id', $id)
            ->update();
        $this->updationModel
            ->where('company_id', $matchId)
            ->set('company_id', $id)
            ->update();
    }

    // -----------------------------
    // 3️⃣ Skip logic
    // -----------------------------
    elseif ($action === 'skip') {
        // Do nothing
    }
    // $this->companyCrossValidation();
return redirect()->back();
}





//     public function handleActionContact()
// {
//     $request = $this->request->getPost();
//     $type = $request['type']; // company or contact
//     $id = $request['id'];
//     $matchId = $request['match_id'];
//     $action = $request['action']; // overwrite / merge / skip

//         $modelCompany = $this->companyModel;
//         // $modelContact = $this->contactModel;

//         // action = {
            
//         // merge address
//         // overwrite address
//         // Overwrite Company Name
//         // just add source
        
//         // }

//     if ($action === 'overwrite') {
//             $id = $request['id'];

//         // Add Source with id
// $this->sourceModel
//      ->where('company_id', $matchId)
//      ->set('company_id', $id)
//      ->update();
// $this->updationModel
//      ->where('company_id', $matchId)
//      ->set('company_id', $id)
//      ->update();
        
// // 1️⃣ Get matching company details
// $matchingCompany = $this->companyModel->find($matchId);


//     // 2️⃣ Update the target company ($id) with matching company data
//     $this->companyModel
//          ->where('id', $id)
//          ->set([
//              'company_name' => $matchingCompany['company_name'],
//              'category'     => $matchingCompany['category'],
//              'address'      => $matchingCompany['address'],
//              'city'         => $matchingCompany['city'],
//              'pincode'      => $matchingCompany['pincode'],
//              'state'        => $matchingCompany['state'],
//          ])
//          ->update();


//         // delete everthing where id = id
//         // set id to id where id is matchId

//     }


//     // i have to update soucre updation contact
//     //     set active = false where comapny id = id 
//     //     set note = "Overwrittenr whtih "
//     //     set company id = id where company id = match id
        
//     //     set contact id from contact where company id = matcid
//     //     set contact id from contact_email where company id = matcid
//     //     set contact id from contact_mobile where company id = matcid
//     //     select contact id where company id = matcid

//     // merge    what details are not matching add them

//         $data = $model->find($matchId);
//         $model->update($id, $data);
//     } elseif ($action === 'merge') {
//         // Implement your merge logic here
//     } elseif ($action === 'skip') {
//         // Do nothing
//     }

//     return redirect()->to('crossvalidation');
// }

// Handle
// If Contact and Company Match Exhactly Merge Them
// Update that is has Merged

public function overwriteCompany(string $id, string $matchId): void
{
    echo "TYPE OK<br>";



    echo "ACTION OVERWRITE OK<br>";

    $this->companyModel->db->transStart();
    echo "TRANSACTION STARTED<br><hr>";

    // 1️⃣ Update source table
    $this->sourceModel
        ->where('company_id', $matchId)
        ->set('company_id', $id)
        ->update();
    echo "SOURCE UPDATED (company_id: $matchId → $id)<br>";

    // 2️⃣ Update updation table
    $this->updationModel
        ->where('company_id', $matchId)
        ->set('company_id', $id)
        ->update();
    echo "UPDATION UPDATED (company_id: $matchId → $id)<br><hr>";

    // 3️⃣ Fetch BEFORE data
    $before = $this->companyModel->find($id);
    echo "<strong>BEFORE DATA:</strong><br><pre>";
    print_r($before);
    echo "</pre><hr>";

    if (!$before) {
        echo "❌ COMPANY NOT FOUND<br>";
        exit;
    }

    $matchingCompany = $this->companyModel->find($matchId);

    // 4️⃣ Prepare update data (debug)
    echo "<strong>UPDATE DATA USED:</strong><br><pre>";
    print_r([
        'company_name' => $matchingCompany['company_name'] ?? $before['company_name'],
        'category'     => $matchingCompany['category'] ?? $before['category'],
        'address'      => $matchingCompany['address'] ?? $before['address'],
        'city'         => $matchingCompany['city'] ?? $before['city'],
        'pincode'      => $matchingCompany['pincode'] ?? $before['pincode'],
        'state'        => $matchingCompany['state'] ?? $before['state'],
        'Cross'        => $matchingCompany['cross_validation'] ?? $before['cross_validation'],
    ]);
    echo "</pre><hr>";

    $newData = $this->companyModel->find($matchId);
    echo $id;
    echo $matchId;

    // 5️⃣ Update main company
    $this->companyModel->update($id, [
        'company_name'      => $newData['company_name'] ?? $before['company_name'],
        'category'          => $newData['category'] ?? $before['category'],
        'address'           => $newData['address'] ?? $before['address'],
        'city'              => $newData['city'] ?? $before['city'],
        'pincode'           => $newData['pincode'] ?? $before['pincode'],
        'state'             => $newData['state'] ?? $before['state'],
        'updated_at'        => date('Y-m-d H:i:s'),
        'cross_validation'  => "0",
    ]);

    echo "COMPANY UPDATED<br><hr>";

    // 6️⃣ Update matching company
    $this->companyModel->update($matchId, [
        'company_name'      => "Bhosda",
        'category'          => $newData['category'] ?? $before['category'],
        'address'           => $newData['address'] ?? $before['address'],
        'city'              => $newData['city'] ?? $before['city'],
        'pincode'           => $newData['pincode'] ?? $before['pincode'],
        'state'             => $newData['state'] ?? $before['state'],
        'updated_at'        => date('Y-m-d H:i:s'),
        'cross_validation'  => true,
    ]);

    // 7️⃣ Fetch AFTER data
    $after = $this->companyModel->find($id);
    echo "<strong>AFTER DATA:</strong><br><pre>";
    print_r($after);
    echo "</pre><hr>";

    $newData = $this->companyModel->find($matchId);
    print_r($newData);

    // 8️⃣ Delete matching session
    $this->matchingSessionModel
        ->where('company_id', $id)
        ->where('matching_company_id', $matchId)
        ->delete();
    echo "MATCHING SESSION DELETED<br><hr>";

    // 9️⃣ Complete transaction
    $this->companyModel->db->transComplete();
    echo "TRANSACTION COMPLETED<br>";

    if ($this->companyModel->db->transStatus() === false) {
        echo "❌ TRANSACTION FAILED<br>";
        exit;
    }

    echo "<strong>✅ OVERWRITE FLOW FINISHED SUCCESSFULLY</strong><br>";
}

}
