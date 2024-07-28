<?php

namespace App\Observers;

use App\Models\{Task,TaskComment};
use App\Traits\ModelTrait;

class TaskObserver
{
    use ModelTrait;
    public function created(Task $task): void
    {
        $name = $task->createdBy->name;
        $status = $task->is_done == 0 ? 'Aberto' : 'Finalizado';
        $owner = $task->owner->name;
        self::createRecord(TaskComment::class,[
            'comment' => "Criado por: $name, Status: $status,  Responsável: $owner",
            'task_id' => $task->id,
            'source' => 'automatic'
        ]);
    }

    public function updated(Task $task): void
    {
        $name = $task->createdBy->name;
        $status = $task->is_done == 0 ? 'Aberto' : 'Finalizado';
        $owner = $task->owner->name;
        self::createRecord(TaskComment::class,[
            'comment' => "Atualizado por: $name, Status: $status, Responsável: $owner",
            'task_id' => $task->id,
            'source' => 'automatic'
        ]);
    }
}
