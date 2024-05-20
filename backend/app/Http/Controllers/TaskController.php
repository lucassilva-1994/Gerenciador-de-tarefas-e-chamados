<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    use HelperModel;
    public function showAll(){
        return Task::all();
    }

    public function showById(Task $task){
        return $task;
    }

    public function create(TaskRequest $request){
        return self::setData($request->all(), Task::class);
    }

    public function update(TaskRequest $request, Task $task){
        return self::updateData($request->all(), Task::class,['id' => $task->id]);
    }

    public function delete(Task $task){
        return self::setStatusDeleted(Task::class,['id' => $task->id]);
    }
}
