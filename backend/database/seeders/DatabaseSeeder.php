<?php

namespace Database\Seeders;

use App\Models\{ Department, Permission, Role, User};
use App\Traits\ModelTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    use ModelTrait;
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            PermissionRoleSeeder::class,
            RoleUserSeeder::class
        ]);
        foreach(Department::get() as $department){
            $data['created_by'] = Arr::random(User::pluck('id')->toArray());
            $data['modified_by'] = Arr::random(User::pluck('id')->toArray());
            self::updateRecord(Department::class,$data,['id' => $department->id]);
        }
        foreach(User::get() as $user){
            $data['created_by'] = Arr::random(User::pluck('id')->toArray());
            $data['modified_by'] = Arr::random(User::pluck('id')->toArray());
            self::updateRecord(User::class,$data,['id' => $user->id]);
        }
        foreach(Permission::get() as $permission){
            $data['created_by'] = Arr::random(User::pluck('id')->toArray());
            $data['modified_by'] = Arr::random(User::pluck('id')->toArray());
            self::updateRecord(Permission::class,$data,['id' => $permission->id]);
        }
        foreach(Role::get() as $role){
            $data['created_by'] = Arr::random(User::pluck('id')->toArray());
            $data['modified_by'] = Arr::random(User::pluck('id')->toArray());
            self::updateRecord(Role::class,$data,['id' => $role->id]);
        }
    }
}
