<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegistrationModel;

class Register extends BaseController
{
    public function index()
    {
        // Load the registration form view
        return view('register_form');
    }

    public function submit()
    {
        helper(['form', 'url']);

        $validationRules = [
            'title' => 'required',
            'select2' => 'required|min_length[2]',
            'lastname' => 'permit_empty',
            'designation' => 'required',
            'organisation' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric|min_length[10]|max_length[10]',
            'address' => 'permit_empty',
            'city' => 'permit_empty',
            'state' => 'permit_empty',
            'pincode' => 'permit_empty|numeric',
            'country' => 'permit_empty',
            'website' => 'permit_empty|valid_url',
            'Message' => 'permit_empty'
        ];

        if (!$this->validate($validationRules)) {
            // Return validation errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepare data for saving
        $data = [
            'title' => $this->request->getPost('title'),
            'first_name' => $this->request->getPost('select2'),
            'last_name' => $this->request->getPost('lastname'),
            'designation' => $this->request->getPost('designation'),
            'organisation' => $this->request->getPost('organisation'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'pincode' => $this->request->getPost('pincode'),
            'country' => $this->request->getPost('country'),
            'website' => $this->request->getPost('website'),
            'message' => $this->request->getPost('Message')
        ];

        $model = new RegistrationModel();
        $model->save($data);

        return redirect()->to('/register')->with('success', 'Registration submitted successfully!');
    }
}