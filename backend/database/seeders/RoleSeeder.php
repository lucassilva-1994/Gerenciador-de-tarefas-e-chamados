<?php

namespace Database\Seeders;

use App\Models\{Role, User};
use App\Traits\ModelTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class RoleSeeder extends Seeder
{
    use ModelTrait;
    public function run(): void
    {
        foreach(self::roles() as $role){
            $role['created_by'] = Arr::random(User::pluck('id')->toArray());
            $role['modified_by'] = Arr::random(User::pluck('id')->toArray());
            self::createRecord(Role::class, $role);
        }
    }

    private static function roles(){
        return [
            ['name' => 'SUPERADMIN', 'description' => 'Super administrador do sistema com acesso total a todas as funcionalidades e áreas do sistema, incluindo configurações e gerenciamento de usuários.'],
            ['name' => 'DIRETOR', 'description' => 'Diretor responsável por supervisionar e gerenciar todas as operações dentro de sua unidade específica, com acesso a tarefas e dados relacionados à unidade.'],
            ['name' => 'GERENTE', 'description' => 'Gerente responsável por coordenar e gerenciar as tarefas e operações dentro de seu departamento específico, com acesso a dados e tarefas relacionadas ao departamento.'],
            ['name' => 'OPERACIONAL', 'description' => 'Usuário operacional com acesso restrito apenas às suas próprias tarefas e informações, permitindo a realização de atividades específicas conforme designado.']
        ];
    }
}
