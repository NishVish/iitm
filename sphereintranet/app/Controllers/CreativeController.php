<?php

namespace App\Controllers;

use App\Models\CreativeModel;
use CodeIgniter\Controller;

class CreativeController extends BaseController
{
    public function index()
    {
        $model = new CreativeModel();

        // Get all messages ordered by created_at
        $messages = $model->orderBy('created_at', 'ASC')->findAll();

        // Return JSON response
        return $this->response->setJSON(['messages' => $messages]);
    }

    // Example in Home controller
    // public function index()
    // {
    //     $model = new CreativeModel();
    //     $messages = $model->orderBy('created_at', 'ASC')->findAll();

    //     return view('content/creative');
    // }

    // New method for handling file upload
public function upload()
{
    helper(['form', 'url']);
    $session = session();

    $validationRules = [
        'image' => [
            'uploaded[image]',
            'is_image[image]',
            'max_size[image,2048]', // max 2MB
            'ext_in[image,jpg,jpeg,png,gif]'
        ],
        'department' => 'required',
        'message' => 'required'
    ];

    if (! $this->validate($validationRules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $imageFile = $this->request->getFile('image');

    if ($imageFile->isValid() && ! $imageFile->hasMoved()) {
        $newName = $imageFile->getRandomName();
        $imageFile->move(ROOTPATH . 'public/uploads', $newName);

        // Use session name as sender
        $senderName = $session->get('name');

        // Save to DB
        $model = new CreativeModel();
        $model->insert([
            'image_url' => $newName,
            'sender' => $senderName,
            'department' => $this->request->getPost('department'),
            'message' => $this->request->getPost('message'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('home')->with('success', 'Image uploaded successfully!');
    }

    return redirect()->back()->with('error', 'Failed to upload image.');
}


public function fetchDepartmentList()
{
    $userModel = new \App\Models\UserModel();

    // Get distinct departments
    $departments = $userModel->select('department')->distinct()->findAll();

    // Map to just department strings
    $deptNames = array_map(fn($d) => $d['department'], $departments);

    return $this->response->setJSON($deptNames);
}




}
