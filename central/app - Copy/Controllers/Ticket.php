<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\UserModel;

class Ticket extends BaseController
{
    public function index()
    {
        $model = new TicketModel();
        $users = new UserModel();

        $data['ticket'] = $model->findAll();
        $data['users'] = $users->getAllUsers();
        // $data['users'] = 

        if ($this->request->getGet('edit')) {
            $data['editIssue'] = $model->find($this->request->getGet('edit'));
        }

        return view('ticket/index', $data);
    }


    public function storeajax()
{
    // 1. Get the data regardless of whether it's AJAX/JSON or standard Form Post
    $json = $this->request->getJSON(true);
    $data = !empty($json) ? $json : $this->request->getPost();

    // 2. Validate (Crucial: user_id and description are likely required in your DB)
    if (empty($data['title'])) {
        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Title is required']);
    }

    $model = new \App\Models\TicketModel(); // Adjust namespace to your project

    try {
        $insertData = [
            'title'       => $data['title'],
            'parent_id'   => $data['parent_id'] ?? 0,
            'task_level'  => $data['task_level'] ?? 0,
            'user_id'     => $data['user_id'] ?? session()->get('user_id'),
            'ticket_type' => $data['ticket_type'] ?? 'Task',
            'priority'    => $data['priority'] ?? 'Medium',
            'status'      => $data['status'] ?? 'Open',
            'description' => $data['description'] ?? '',
        ];

        $id = $model->insert($insertData);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true, 
                'id'      => $id, 
                'message' => 'Created successfully'
            ]);
        }

        return redirect()->to('/ticket')->with('success', 'Created');

    } catch (\Exception $e) {
        // This will send the actual error message back to the console instead of just '500'
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false, 
            'message' => $e->getMessage()
        ]);
    }
}


public function store()
{
    $model = new TicketModel();

    $status = $this->request->getPost('status');
$parentId = $this->request->getPost('parent_id') ?? 0;
$postTaskLevel = $this->request->getPost('task_level') ?? 0;

$data = [
    'title'        => $this->request->getPost('title'),
    'user_id'      => $this->request->getPost('user_id'),
    'description'  => $this->request->getPost('description'),
    'department'   => $this->request->getPost('department'),
    'priority'     => $this->request->getPost('priority'),
    'ticket_type'  => $this->request->getPost('ticket_type'),
    'parent_id'    => $parentId,
    'task_level'   => ($parentId == 0) ? 1 : (($postTaskLevel > 1) ? $postTaskLevel : 0),
    'status'       => $status,
    'resolved_at'  => ($status === 'Resolved') ? date('Y-m-d H:i:s') : null
];

var_dump($data);
// exit;
    $model->save($data);

    return redirect()->to('/ticket')->with('success', 'Ticket Created Successfully');
}


public function type($type)
{
    $session = session();
    $userId = $session->get('user_id');

    if (!$userId) {
        return redirect()->to('/');
    }

    $model = new \App\Models\TicketModel();
    $typeFormatted = ucfirst(strtolower($type));

    if ($typeFormatted == "Task") {

        $tickets = $model
            ->where('ticket_type', $typeFormatted)
            ->where('user_id', $userId)
            ->orderBy('id', 'ASC')
            ->findAll();

        // ✅ Build hierarchy here
        $data['tickets'] = $this->buildTicketTree($tickets);
    }

    $data['pageTitle'] = $typeFormatted . ' Management';

    return view('ticket/' . $type, $data);
}

private function buildTicketTree(array $tickets)
{
    $tree = [];
    $indexed = [];

    // Index tickets
    foreach ($tickets as $ticket) {
        $ticket['children'] = [];
        $indexed[$ticket['id']] = $ticket;
    }

    // Build tree
    foreach ($indexed as $id => &$ticket) {
        if ($ticket['parent_id'] != 0 && isset($indexed[$ticket['parent_id']])) {
            $indexed[$ticket['parent_id']]['children'][] = &$ticket;
        } else {
            $tree[] = &$ticket;
        }
    }

    return $tree;
}

private function getTicketTree($userId){
    $model = new \App\Models\TicketModel();



}

private function getTicketTreec($parentId = 0, $depth = 0, $userId)
{
    $db = \Config\Database::connect();
    $builder = $db->table('tickets');

    // Root tasks OR tasks assigned to user
    $builder->groupStart();
    $builder->where('parent_id', $parentId);
    $builder->orWhere('user_id', $userId); 
    $builder->groupEnd();

    $builder->where('ticket_type', 'Task');
    $builder->orderBy('id', 'ASC');

    $query = $builder->get();

    $branch = [];
    foreach ($query->getResultArray() as $ticket) {
        $ticket['depth'] = $depth;
        $branch[] = $ticket;

        // Recursively get children
        $children = $this->getTicketTree($ticket['id'], $depth + 1, $userId);
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

    public function view($id)
{
    $ticketModel = new \App\Models\TicketModel();

    $ticket = $ticketModel->find($id);

    if (!$ticket) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $data['ticket']  = $ticket;
    $data['tickets'] = $ticketModel->findAll(); // for subtasks tree

    return view('ticket/view', $data);
}
}