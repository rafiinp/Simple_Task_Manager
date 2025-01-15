<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Tasks extends BaseController
{
    protected $taskModel;
    
    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }
    
    public function index()
    {
        $status = $this->request->getGet('status');
        
        // Get tasks based on filter
        $tasks = [];
        switch($status) {
            case 'pending':
                $tasks = $this->taskModel->where('status', 'pending')->findAll();
                break;
            case 'completed':
                $tasks = $this->taskModel->where('status', 'completed')->findAll();
                break;
            default:
                $tasks = $this->taskModel->findAll();
        }
        
        // Count tasks for each status
        $taskCounts = [
            'all' => $this->taskModel->countAll(),
            'pending' => $this->taskModel->where('status', 'pending')->countAllResults(),
            'completed' => $this->taskModel->where('status', 'completed')->countAllResults()
        ];
        
        $data = [
            'title' => 'Task List',
            'tasks' => $tasks,
            'currentStatus' => $status,
            'taskCounts' => $taskCounts
        ];
        
        return view('tasks/index', $data);
    }

    
    public function new()
    {
        return view('tasks/create', ['title' => 'Create New Task']);
    }
    
    public function create()
    {
        if (!$this->validate($this->taskModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $this->taskModel->save([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date')
            // Status akan diset otomatis oleh beforeInsert callback
        ]);
        
        return redirect()->to('/')->with('message', 'Task created successfully');
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Task',
            'task' => $this->taskModel->find($id)
        ];
        
        return view('tasks/edit', $data);
    }
    
    public function update($id)
    {
        if (!$this->validate($this->taskModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $this->taskModel->update($id, [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
            'status' => $this->request->getPost('status')
        ]);
        
        return redirect()->to('/')->with('message', 'Task updated successfully');
    }
    
    public function delete($id)
    {
        $this->taskModel->delete($id);
        return redirect()->to('/')->with('message', 'Task deleted successfully');
    }
}