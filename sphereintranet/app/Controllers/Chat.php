<?php

namespace App\Controllers;

use App\Models\ChatModel;
use CodeIgniter\Controller;

class Chat extends Controller
{
    protected $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    // Example method to load a chat page (optional)
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Chat Room',
            'username' => $session->get('username'),
            'user_type' => $session->get('user_type'),
        ];

        return view('chat_view', $data);  // your chat view page
    }

public function fetchChats()
{
    if (!$this->request->isAJAX()) {
        return $this->response
            ->setStatusCode(403)
            ->setJSON(['error' => 'Only AJAX requests allowed']);
    }

    $chats = $this->chatModel->getAllChatsWithUser();

    return $this->response->setJSON($chats);
}


    public function add()
{
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Only AJAX requests allowed');
    }

    $session = session();
    if (!$session->get('isLoggedIn')) {
        return $this->failUnauthorized('Not logged in');
    }

    $comment = $this->request->getPost('comment');
    if (!$comment) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Comment required']);
    }

    $this->chatModel->insert([
        'comment' => $comment,
        'time' => date('Y-m-d H:i:s'),
        'empid' => $session->get('employee_id') // make sure employee_id is stored in session
    ]);

    return $this->response->setJSON(['success' => true]);
}

}
