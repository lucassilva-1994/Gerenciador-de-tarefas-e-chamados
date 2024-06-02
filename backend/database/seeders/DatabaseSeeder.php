<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            EmployeeSeeder::class,
            EmployeeRoleSeeder::class,
            UserSeeder::class,
            UpdateSeeder::class
        ]);
    }
}
