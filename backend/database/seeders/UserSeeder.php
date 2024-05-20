<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Employee, User};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        foreach(Employee::get() as $employe){
            self::setData([
                'employee_id' => $employe->id,
                'password' => '12345678910',
                'company_id' => $employe->company_id
            ], User::class);
        }
    }
}
