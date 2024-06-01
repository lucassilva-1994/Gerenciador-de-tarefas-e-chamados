<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Employee, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        Employee::chunk(1000, function ($employees) {
            foreach ($employees as $employee) {
                if (!User::whereEmployeeId($employee->id)->exists()) {
                    self::setData([
                        'employee_id' => $employee->id,
                        'password' => '12345678910',
                        'company_id' => $employee->company_id,
                        'created_by' => Arr::random($employee->company->employees->pluck('id')->toArray())
                    ], User::class);
                }
            }
        });
    }
}
