<?php

namespace Database\Seeders;

use App\Models\{Company, Permission, Role};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach(Company::get() as $company){
            foreach($company->roles as $role){
                foreach($company->permissions as $permission){
                    DB::table('permission_role')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permission->id
                    ]);
                }
            }
        }
    }
}
