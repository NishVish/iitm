<?php

namespace App\Controllers;

use App\Models\TicketModel;

class Ticket extends BaseController
{
    public function index()
    {
        $model = new TicketModel();

        $data['ticket'] = $model->findAll();

        if ($this->request->getGet('edit')) {
            $data['editIssue'] = $model->find($this->request->getGet('edit'));
        }

        return view('ticket/index', $data);
    }

public function store()
{
    $model = new TicketModel();

    $status = $this->request->getPost('status');

    $data = [
        'title'        => $this->request->getPost('title'),
        'description'  => $this->request->getPost('description'),
        'department'   => $this->request->getPost('department'),
        'priority'     => $this->request->getPost('priority'),
        'ticket_type'  => $this->request->getPost('ticket_type'),
        'parent_id'    => $this->request->getPost('parent_id') ?? 0,
        'status'       => $status,
        'resolved_at'  => ($status === 'Resolved') ? date('Y-m-d H:i:s') : null
    ];

    $model->save($data);

    return redirect()->to('/ticket')->with('success', 'Ticket Created Successfully');
}

public function type($type)
{
    $model = new \App\Models\TicketModel();
    $typeFormatted = ucfirst(strtolower($type));
    $allowedTypes = ['Task', 'Issue', 'Update'];

    if (!in_array($typeFormatted, $allowedTypes)) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Logic: Tasks show the hierarchy tree, others show a flat list
    if ($typeFormatted == "Task") {
        // NOTE: Make sure getTicketTree is defined in this class or a helper
        $data['tickets'] = $this->getTicketTree(); 
    } else {
        $data['tickets'] = $model
            ->where('ticket_type', $typeFormatted)
            ->findAll();
            
        // For flat lists, set depth to 0 so the table CSS doesn't break
        foreach($data['tickets'] as &$t) { $t['depth'] = 0; }
    }

    $data['pageTitle'] = $typeFormatted . ' Management';

    // Best practice: Use one view file (e.g., list.php) for all types
    return view('ticket/'.$type, $data);
}

// Ensure this is inside your Controller class
private function getTicketTree($parentId = 0, $depth = 0) {
    $db = \Config\Database::connect();
    $builder = $db->table('tickets');
    $builder->where('parent_id', $parentId);
    // Only show the specific type hierarchy if needed, 
    // but usually, hierarchy is for 'Tasks'
    $builder->where('ticket_type', 'Task'); 
    $builder->orderBy('id', 'ASC');
    $query = $builder->get();
    
    $branch = [];
    foreach ($query->getResultArray() as $ticket) {
        $ticket['depth'] = $depth;
        $branch[] = $ticket;
        
        $children = $this->getTicketTree($ticket['id'], $depth + 1);
        if (!empty($children)) {
            $branch = array_merge($branch, $children);
        }
    }
    return $branch;
}




    public function update($id)
    {
        $model = new TicketModel();

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

        return redirect()->to('/ticket')->with('success', 'Issue Updated Successfully');
    }
}