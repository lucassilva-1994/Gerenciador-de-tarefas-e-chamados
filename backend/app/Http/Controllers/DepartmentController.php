<?php

namespace App\Http\Controllers;
use App\Helpers\HelperModel;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    use HelperModel;
    public function showAll(){
        return Department::all();
    }

    public function showById(Department $department){
        return $department->load('positions','positions.employees');
    }

    public function create(DepartmentRequest $request){
        return self::setData($request->all(), Department::class);
    }

    public function update(DepartmentRequest $request, Department $department){
        return self::updateData($request->all(), Department::class,['id' => $department->id]);
    }

    public function delete(Department $department){
        return self::setStatusDeleted(Department::class,['id' => $department->id]);
    }
}
