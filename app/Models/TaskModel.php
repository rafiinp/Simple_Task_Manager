<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'due_date', 'status'];
    protected $useTimestamps = true;
    
    // Hapus status dari validation rules karena akan diset default
    protected $validationRules = [
        'title' => 'required|min_length[3]',
        'description' => 'required',
        'due_date' => 'required|valid_date'
    ];

    // Tambahkan default values
    protected $beforeInsert = ['setDefaultStatus'];
    
    protected function setDefaultStatus(array $data)
    {
        if (!isset($data['data']['status'])) {
            $data['data']['status'] = 'pending';
        }
        return $data;
    }
}