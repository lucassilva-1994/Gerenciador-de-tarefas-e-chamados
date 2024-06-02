<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Company, Role};
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class RoleSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        foreach(Company::get(['id']) as $company){
            foreach(self::roles() as $role){
                $role['company_id'] = $company->id;
                self::setData($role, Role::class, true);
            }
        }
    }

    private static function roles(){
        return [
            ['name' => 'SUPERADMIN','description' => 'Super administrador do sistema'],
            ['name' => 'ADMIN','description' => 'Administrador do sistema'],
            ['name' => 'DIRETOR','description' => 'Diretoria'],
            ['name' => 'GERENTE','description' => 'Gerência'],
            ['name' => 'CONVIDADO','description' => 'Convidado']
        ];
    }
}
