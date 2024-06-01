<?php

namespace App\Http\Controllers;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(
            Employee::class,
            ['position','department','hasUser','company','createdBy','modifiedBy'], 
            EmployeeRequest::class,
            [
                    'name', 'email',
                    'department' => ['departments.name'],
                    'position' => ['positions.name'],
                    'createdBy' => ['name'],
                    'modifiedBy' => ['name']
            ]
        );
    }
}
