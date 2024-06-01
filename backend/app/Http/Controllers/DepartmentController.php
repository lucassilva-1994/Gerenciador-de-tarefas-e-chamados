<?php

namespace App\Http\Controllers;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;

class DepartmentController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(
            Department::class,
            ['positions','employees','createdBy','modifiedBy'], 
            DepartmentRequest::class,
            [
                'name',
                'positions' => ['positions.name'],
                'employees' => ['employees.name'],
                'createdBy' => ['name'],
                'modifiedBy' => ['name']
            ]
        );
    }
}
