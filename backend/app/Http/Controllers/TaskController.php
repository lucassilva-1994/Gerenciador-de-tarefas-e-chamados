<?php

namespace App\Http\Controllers;
use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(Task::class,['project','viewer','owner','supportTicket','createdBy','modifiedBy'], TaskRequest::class);
    }
}
