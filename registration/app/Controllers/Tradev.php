<?php

namespace App\Controllers;
use App\Models\TradevModel;

class Tradev extends BaseController
{
    protected $tradevModel;

    public function __construct()
    {
        $this->tradevModel = new TradevModel();
        helper('form');
        helper('url');
    }

    // List all records
    public function index()
    {
        $data['tradev_list'] = $this->tradevModel->findAll();
        return view('tradev/index', $data);
    }

    
    // Show edit form / update record
    public function edit($id)
    {
        $data['tradev'] = $this->tradevModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $updateData = $this->request->getPost();
            $this->tradevModel->update($id, $updateData);
            return redirect()->to('/tradev');
        }

        return view('tradev/edit', $data);
    }

    // Delete record
    public function delete($id)
    {
        $this->tradevModel->delete($id);
        return redirect()->to('/tradev');
    }
}