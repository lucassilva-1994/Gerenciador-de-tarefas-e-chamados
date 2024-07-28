<?php

namespace Database\Seeders;

use App\Models\{Permission,Role};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{

    public function run(): void
    {
        foreach(Permission::get() as $permission){
            foreach(Role::get() as $role){
                DB::table('permission_role')->insert([
                    'permission_id' => $permission->id,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
