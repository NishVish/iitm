<?php

namespace App\Controllers;

use App\Models\IssueModel;

class Issue extends BaseController
{
    public function index()
    {
        $model = new IssueModel();

        $data['issues'] = $model->findAll();

        if ($this->request->getGet('edit')) {
            $data['editIssue'] = $model->find($this->request->getGet('edit'));
        }

        return view('issue/index', $data);
    }

    public function store()
    {
        $model = new IssueModel();

        $model->save([
            'title'        => $this->request->getPost('title'),
            'description'  => $this->request->getPost('description'),
            'priority'     => $this->request->getPost('priority'),
            'status'       => 'Open',
            'resolved_at'  => null
        ]);

        return redirect()->to('/issue')->with('success', 'Issue Created Successfully');
    }

    public function update($id)
    {
        $model = new IssueModel();

        $status = $this->request->getPost('status');
        
$data = [
    'title'       => $this->request->getPost('title'),
    'description' => $this->request->getPost('description'),
    'priority'    => $this->request->getPost('priority'),
    'status'      => $status,
    'department'  => $this->request->getPost('department') // Add this line
];

        // ✅ Set resolved_at automatically
        if ($status === 'Resolved') {
            $data['resolved_at'] = date('Y-m-d H:i:s');
        } else {
            $data['resolved_at'] = null;
        }

        $model->update($id, $data);

        return redirect()->to('/issue')->with('success', 'Issue Updated Successfully');
    }
}