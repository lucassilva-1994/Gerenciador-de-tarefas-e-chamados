<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;

class ProjectController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(Project::class,['createdBy','modifiedBy'], ProjectRequest::class);
    }
}
