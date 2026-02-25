<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table      = 'tickets';
    protected $primaryKey = 'id';
    
    // UPDATED: Added 'task_level' and 'user_id' to allowed fields
    protected $allowedFields = [
        'title', 
        'description', 
        'priority', 
        'status', 
        'resolved_at', 
        'department', 
        'parent_id', 
        'task_level', // existing
        'ticket_type',
        'user_id'     // newly added
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Optional: Helper to get only root tickets
     */
    public function getRoots()
    {
        return $this->where('parent_id', 0)->findAll();
    }

    /**
     * Optional: Helper to get all subtasks for a specific project
     */
    public function getSubtasks($rootId)
    {
        return $this->where('parent_id', $rootId)
                    ->orderBy('task_level', 'ASC')
                    ->findAll();
    }

    /**
     * Optional: Get tickets along with assigned user info
     */
    public function getTicketsWithUser()
    {
        return $this->select('tickets.*, users.name AS user_name, users.email AS user_email')
                    ->join('users', 'users.id = tickets.user_id', 'left')
                    ->findAll();
    }
}