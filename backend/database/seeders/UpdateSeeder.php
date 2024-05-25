<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Company, Department, Employee, Position};
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UpdateSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        foreach(Company::get() as $company){
            foreach($company->departments as $department){
                self::updateData([
                    'created_by' => Arr::random($company->employees->pluck('id')->toArray()),
                    'modified_by' => Arr::random($company->employees->pluck('id')->toArray()),
                ], Department::class,['id' => $department->id]);
            }
            foreach($company->positions as $position){
                self::updateData([
                    'created_by' => Arr::random($company->employees->pluck('id')->toArray()),
                    'modified_by' => Arr::random($company->employees->pluck('id')->toArray()),
                ], Position::class,['id' => $position->id]);
            }

            foreach($company->employees as $employee){
                self::updateData([
                    'created_by' => Arr::random($company->employees->pluck('id')->toArray()),
                    'modified_by' => Arr::random($company->employees->pluck('id')->toArray()),
                ], Employee::class,['id' => $employee->id]);
            }
        }
    }
}
