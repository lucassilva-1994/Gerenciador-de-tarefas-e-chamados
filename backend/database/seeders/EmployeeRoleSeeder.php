<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EmployeeRoleSeeder extends Seeder
{

    public function run(): void
    {

        foreach(Company::get() as $company){
            foreach($company->employees as $employee){
                DB::table('employee_role')->insert([
                    'role_id' => Arr::random($company->roles->pluck('id')->toArray()),
                    'employee_id' => $employee->id
                ]);
            }
        }
    }
}
