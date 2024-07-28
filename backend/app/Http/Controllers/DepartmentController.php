<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;

class DepartmentController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(Department::class,DepartmentRequest::class,['createdBy','modifiedBy'],['name','description'],['users']);
    }
}
