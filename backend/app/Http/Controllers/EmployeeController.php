<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    use HelperModel;
    public function showAll(){
        return Employee::all();
    }

    public function showById(Employee $employee){
        return $employee->load('position','user');
    }

    public function create(EmployeeRequest $request){
        return self::setData($request->all(), Employee::class);
    }

    public function update(EmployeeRequest $request, Employee $employee){
        return self::updateData($request->all(), Employee::class,['id' => $employee->id]);
    }

    public function delete(Employee $employee){
        return self::setStatusDeleted(Employee::class,['id' => $employee->id]);
    }
}
