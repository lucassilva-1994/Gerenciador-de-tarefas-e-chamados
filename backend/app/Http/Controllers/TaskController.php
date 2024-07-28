<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\TaskComment;
use App\Traits\ModelTrait;
use Illuminate\Http\Request;

class TaskController extends CRUDController
{
    use ModelTrait;
    public function __construct()
    {
        parent::__construct(
            Task::class,
            TaskRequest::class,
            ['owner', 'createdBy', 'modifiedBy','project'],
            ['title', 'description', 'owner' => ['users.name'], 'createdBy' => ['users.name'], 'modifiedBy' => ['users.name'], 'project' => ['projects.name']],
            ['comments']
        );
    }

    public function comments(string $id){
        $task = Task::findOrFail($id);
        return response()->json([
            'pages' => ceil($task->comments()->paginate()->total() / request('perPage', 15)),
            'total' => $task->comments()->paginate()->total(),
            'itens' => $task->comments()->paginate(request('perPage',3))->load('user')
        ]);
    }

    public function storeComment(){
        return self::createRecord(TaskComment::class, request(['comment','task_id']));
    }
}
