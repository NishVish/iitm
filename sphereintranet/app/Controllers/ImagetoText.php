<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ImagetoText extends Controller
{
    // Show the upload form
public function uploadForm()
{

    // Pass to view
    return view('major/ImagetoText/imagetoform');
}

// public function allImage(){

//     $model = new \App\Models\ImageDataModel();

//     // Fetch all image records
//     $images = $model->findAll();

//     // Pass to view
//     return view('major/ImagetoText/allData', ['images' => $images]);
// }

public function allImage()
{
    $model = new \App\Models\ImageDataModel();

    // Fetch all image records
    $images = $model->findAll();

    // Get the ID to highlight from query param, default to first image
    $highlightId = $this->request->getGet('highlight_id');

    if (!$highlightId && !empty($images)) {
        $highlightId = $images[0]['id']; // default to first
    }

    return view('major/ImagetoText/allData', [
        'images' => $images,
        'highlightId' => $highlightId,
    ]);
}


public function allImageTable()
{
    $model = new \App\Models\ImageDataModel();

    // Fetch all image records
    $images = $model->findAll();

   

return view('major/ImagetoText/allDatatable', ['images' => $images]);
}




public function updateData($id)
{
    $model = new \App\Models\ImageDataModel();

    // Validate as needed here (optional)

$companyRaw = $this->request->getPost('company_name');

// Remove everything after '|' (pipe) including the pipe itself
$companyRaw = trim(explode('|', $companyRaw)[0]);

// Then convert to lowercase, replace underscores with spaces, and capitalize words
$companyCleaned = ucwords(str_replace('_', ' ', strtolower($companyRaw)));


// Website.................................................................
$websiteRaw = $this->request->getPost('website');

// 1. Trim whitespace
$websiteCleaned = strtolower(str_replace(' ', '', trim($websiteRaw)));

// 2. Remove leading @, Q, www.
$websiteCleaned = preg_replace('/^[@Q\s]*(www\.)?/i', '', $websiteCleaned);

// 3. Remove any trailing 'andXmore' or 'and X more' variants (with or without spaces)
$websiteCleaned = preg_replace('/and\s*\d+\s*more$/i', '', $websiteCleaned);

// 4. Extract domain (optional: match domain using regex instead of cleanup)
preg_match('/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}/', $websiteCleaned, $matches);
$websiteCleaned = $matches[0] ?? '';  // fallback to empty if not found

// 5. (Optional) Convert to lowercase
$websiteCleaned = strtolower($websiteCleaned);

// 5. Optionally re-add "https://" if you want a full URL
// if (!preg_match('/^https?:\/\//', $websiteCleaned)) {
//     $websiteCleaned = 'https://' . $websiteCleaned;
// }

// Mobileeessssssssssssssssssssssssssssssssssssssssssssss
$rawPhone = $this->request->getPost('phone');

// Extract the first valid phone number (7+ digits, optional +, spaces, dashes, parentheses)
if (preg_match('/(?:\+?\d[\d\s\-().]{6,})/', $rawPhone, $matches)) {
    $phoneCleaned = trim($matches[0]);
} else {
    $phoneCleaned = ''; // or null if nothing found
}

$data['phone'] = $phoneCleaned;


$updateData = [
    'company_name' => $companyCleaned,
    'email'        => filter_var($this->request->getPost('email'), FILTER_SANITIZE_EMAIL),
    'phone'        => $phoneCleaned,
    'address'      => htmlspecialchars($this->request->getPost('address')),
    'website'      => $websiteCleaned,
    'ocr_text'   => $this->request->getPost('ocr_text')
];


    $model->update($id, $updateData);

    // Redirect back to images/all (or same page)
    // return redirect()->to('/images/all')->with('success', 'Record updated!');
return redirect()->to('/images/all?highlight_id=' . $id)
                 ->with('success', 'Record updated!');
}






    public function uploadImages()
    {
        helper(['form', 'url']);
        $files = $this->request->getFiles();

        if ($files && isset($files['images'])) {
            $model = new \App\Models\ImageDataModel();

            foreach ($files['images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    // Move the uploaded file
$newName = $img->getRandomName();
$uploadPath = FCPATH . 'imagetoTextFile';  // FCPATH points to your 'public/' folder

if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0755, true);
}

$img->move($uploadPath, $newName);

// $imagePath for processing with Tesseract needs the full system path
$imagePath = $uploadPath . '/' . $newName;

// OCR output folder stays inside writable (for internal use)
$outputBase = WRITEPATH . 'uploads/ocr_output/' . pathinfo($newName, PATHINFO_FILENAME);

                    // Ensure output directory exists
                    if (!is_dir(dirname($outputBase))) {
                        mkdir(dirname($outputBase), 0755, true);
                    }

                    // Run Tesseract OCR command
                    $cmd = "tesseract \"$imagePath\" \"$outputBase\" 2>&1";
                    exec($cmd, $outputLines, $returnCode);

                    if ($returnCode !== 0) {
                        // Log error and skip this file
                        log_message('error', "Tesseract OCR failed: " . implode("\n", $outputLines));
                        continue;
                    }

                    // Read the OCR output
                    $ocrTextFile = $outputBase . '.txt';
                    $ocrText = '';
                    if (file_exists($ocrTextFile)) {
                        $ocrText = file_get_contents($ocrTextFile);
                    }

                    // Extract data from OCR text
                    $companyName = $this->extractCompanyName($ocrText);
                    $email = $this->extractEmail($ocrText);
                    $phone = $this->extractPhone($ocrText);
                    $address = $this->extractAddress($ocrText);
                    $website = $this->extractWebsite($ocrText);

                    // Insert into DB
                    $model->insert([
                        'image_path' => 'imagetoTextFile/' . $newName,
                        'ocr_text' => $ocrText,
                        'company_name' => $companyName,
                        'email' => $email,
                        'phone' => $phone,
                        'address' => $address,
                        'website' => $website,
                    ]);
                }
            }

return redirect()->to('/imagetotext/uploadform')->with('message', 'Images uploaded and OCR processed.');
        }

        return redirect()->to('/imagetotext/upload')->with('error', 'No images uploaded.');
    }

    // Extraction helper methods (inside the controller class)

    private function extractCompanyName($text)
    {
        $lines = explode("\n", trim($text));
        return $lines[0] ?? '';
    }

    private function extractEmail($text)
    {
        if (preg_match('/[a-z0-9_\.-]+@[a-z0-9\.-]+\.[a-z]{2,6}/i', $text, $matches)) {
            return $matches[0];
        }
        return '';
    }

    private function extractPhone($text)
    {
        if (preg_match('/(\+?\d[\d\s\-\(\)]{7,}\d)/', $text, $matches)) {
            return $matches[0];
        }
        return '';
    }

    private function extractAddress($text)
    {
        // Add your own logic for address parsing if needed
        return '';
    }

    private function extractWebsite($text)
    {
        if (preg_match('/(https?:\/\/[^\s]+)/', $text, $matches)) {
            return $matches[0];
        }
        return '';
    }


    public function redoOCR(){


    }
}
