<?php

namespace Database\Seeders;

use App\Models\{Role, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{

    public function run(): void
    {
        foreach (User::get() as $user) {
            DB::table('role_user')->insert([
                'user_id' => $user->id,
                'role_id' => Arr::random(Role::pluck('id')->toArray())
            ]);
        }
    }
}
