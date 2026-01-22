<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Tools extends Controller
{

    public function convertImageToText()
{
    helper(['filesystem']);

    $imageData = $this->request->getPost('imageData');

    if (!$imageData) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No image data received.'
        ]);
    }

    // Case 1: base64 image string (from Choose File)
    if (strpos($imageData, 'base64,') !== false) {
        $imageData = explode(',', $imageData)[1];
        $decodedImage = base64_decode($imageData);
        if (!$decodedImage) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to decode base64 image.'
            ]);
        }
        $imagePath = WRITEPATH . 'uploads/ocr_image.jpg';
        write_file($imagePath, $decodedImage);
    }
    // Case 2: static file path (from Phone Uploaded)
    else {
        $imagePath = FCPATH . $imageData; // public/uploads/1.jpg
        if (!file_exists($imagePath)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Image file not found: ' . $imagePath
            ]);
        }
    }

    // Run Tesseract OCR
    $outputPath = WRITEPATH . 'uploads/ocr_output';
    $cmd = "tesseract \"$imagePath\" \"$outputPath\" 2>&1";
    exec($cmd, $outputLines, $returnCode);

    if ($returnCode !== 0) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Tesseract OCR failed.',
            'details' => $outputLines
        ]);
    }


    
$textFile = $outputPath . '.txt';

if (!file_exists($textFile)) {
    return $this->response->setJSON([
        'success' => false,
        'message' => 'OCR output file not found.'
    ]);
}

// Read the OCR text from the file
$ocrText = file_get_contents($textFile);

// Optional: Cleanup - Delete the OCR text file after reading
unlink($textFile);

// Default values if details aren't found
$companyName = "Not Found";  
$email = "Not Found";        
$phone = "Not Found";        
$address = "Not Found";      
$website = "Not Found";      

// 1. Extract Company Name (Improved regex for matching company names)
if (preg_match('/([A-Za-z\s]+)\s*\|?\s*(?:Trekking|Adventure)/i', $ocrText, $matches)) {
    $companyName = trim($matches[1]);
}

// 2. Extract Email (Clean up `wa.me` format)
if (preg_match('/wa\.me\/\d+/', $ocrText, $matches)) {
    $email = trim($matches[0]);
}

// 3. Extract Phone Number (More robust phone number extraction)
if (preg_match('/(\+?\(?\d{1,4}\)?[\s\-]?\(?\d+\)?[\s\-]?\d+[\s\-]?\d+)/', $ocrText, $matches)) {
    $phone = trim($matches[0]);
}

// 4. Extract Website URL (Enhanced URL matching)
if (preg_match('/https?:\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}(\/[^\s]*)?/', $ocrText, $matches)) {
    $website = trim($matches[0]);
}

// Append the extracted details at the bottom of the OCR text
$ocrText .= "\n\nCompany Name: " . $companyName . "\nEmail: " . $email . "\nPhone: " . $phone . "\nAddress: " . $address . "\nWebsite: " . $website;

// Return the OCR text with the added information
return $this->response->setJSON([
    'success' => true,
    'ocr_text' => $ocrText
]);


}




    public function xconvertImageToText()
    {
        helper(['filesystem']);

        $imageData = $this->request->getPost('imageData');

        if (!$imageData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No image data received.'
            ]);
        }

        // Remove base64 prefix if it exists
        if (strpos($imageData, ';base64,') !== false) {
            $imageData = explode(',', $imageData)[1];
        }

        $decodedImage = base64_decode($imageData);
        if (!$decodedImage) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to decode base64 image.'
            ]);
        }

        // Save image to /writable/uploads/
        $uploadDir = WRITEPATH . 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imagePath = $uploadDir . 'ocr_image.jpg';
        write_file($imagePath, $decodedImage);

        // Run Tesseract
        $outputPath = $uploadDir . 'ocr_output';
        $cmd = "tesseract \"$imagePath\" \"$outputPath\" 2>&1";
        exec($cmd, $outputLines, $returnCode);

        if ($returnCode !== 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tesseract OCR failed.',
                'details' => $outputLines
            ]);
        }

$textFile = $outputPath . '.txt';

if (!file_exists($textFile)) {
    return $this->response->setJSON([
        'success' => false,
        'message' => 'OCR output file not found.'
    ]);
}

// Read the OCR text from the file
$ocrText = file_get_contents($textFile);

// Optional: Cleanup - Delete the OCR text file after reading
unlink($textFile);

// Define or extract company name, email, phone, address, and website
$companyName = "Example Company";  // Modify based on your extraction logic
$email = "example@example.com";    // Modify based on your extraction logic
$phone = "+1234567890";            // Modify based on your extraction logic
$address = "123 Example St, Example City"; // Modify based on your extraction logic

// Extract website URL using regex (example pattern for URLs)
preg_match('/https?:\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}(\/[^\s]*)?/', $ocrText, $matches);
$website = isset($matches[0]) ? $matches[0] : 'Not Found';  // If URL found, use it, else 'Not Found'

// Append the extracted details at the bottom of the OCR text
$ocrText .= "\n\nCompany Name: " . $companyName . "\nEmail: " . $email . "\nPhone: " . $phone . "\nAddress: " . $address . "\nWebsite: " . $website;

// Return the OCR text with the added information
return $this->response->setJSON([
    'success' => true,
    'ocr_text' => $ocrText
]);

    }



public function imageUploadPage()
{
    // Fetch success/error message and last image URL from session
    $successMessage = session()->getFlashdata('success');
    $errorMessage = session()->getFlashdata('error');
    $lastImage = session()->get('last_image');

    // Pass data to the view
    return view('content/tools/imageUpload', [
        'successMessage' => $successMessage,
        'errorMessage'   => $errorMessage,
        'lastImage'      => $lastImage
    ]);
}

public function saveImage()
{
    $imageFile = $this->request->getFile('image');

    if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
        $newName = '1.jpg';  // You can modify this to dynamically name the image

        // Save inside /public/uploads/
        $uploadPath = FCPATH . 'uploads/';

        // Create folder if it doesn’t exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Move the file to the uploads folder
        $imageFile->move($uploadPath, $newName, true);

        // Set success message and image URL in session
        session()->setFlashdata('success', 'Image uploaded successfully!');
        session()->set('last_image', base_url('uploads/' . $newName));

        // Redirect back to the upload page with the success message
        return redirect()->to('tools/upload');
    }

    // If the upload fails, set the error message
    session()->setFlashdata('error', 'Upload failed. Please try again.');

    // Redirect back to the same page
    return redirect()->to('tools/upload');
}






}
