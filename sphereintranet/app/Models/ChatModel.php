<?php namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chat'; 
    protected $primaryKey = 'id';

    protected $allowedFields = ['comment', 'time', 'empid'];

    public function getAllChatsWithUser()
    {
        return $this->db->table('chat c')
            ->select('c.id, c.comment, c.time, c.empid, u.name, u.designation')
            ->join('users u', 'c.empid = u.employee_id', 'left')  // join with users table now
            ->orderBy('c.time', 'ASC')
            ->get()
            ->getResultArray();
    }
}
