<?php

namespace Database\Seeders;

use App\Models\{Permission, User};
use App\Traits\ModelTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PermissionSeeder extends Seeder
{
    use ModelTrait;
    public function run(): void
    {
        foreach(self::permissions() as $permission){
            $permission['created_by'] = Arr::random(User::pluck('id')->toArray());
            $permission['modified_by'] = Arr::random(User::pluck('id')->toArray());
            self::createRecord(Permission::class, $permission);
        }
    }

    private static function permissions() {
        return [
            ['name' => 'create_department', 'description' => 'Criar departamento'],
            ['name' => 'show_departments', 'description' => 'Listar departamentos'],
            ['name' => 'delete_department', 'description' => 'Excluir departamento'],
            ['name' => 'update_department', 'description' => 'Atualizar departamento'],
            
            ['name' => 'create_project', 'description' => 'Criar projeto'],
            ['name' => 'show_projects', 'description' => 'Listar projetos'],
            ['name' => 'delete_project', 'description' => 'Excluir projeto'],
            ['name' => 'update_project', 'description' => 'Atualizar projeto'],
    
            ['name' => 'create_task', 'description' => 'Criar tarefa'],
            ['name' => 'show_tasks', 'description' => 'Listar tarefas'],
            ['name' => 'delete_task', 'description' => 'Excluir tarefa'],
            ['name' => 'update_task', 'description' => 'Atualizar tarefa'],

    
            ['name' => 'create_role', 'description' => 'Criar papel'],
            ['name' => 'show_roles', 'description' => 'Listar papéis'],
            ['name' => 'delete_role', 'description' => 'Excluir papel'],
            ['name' => 'update_role', 'description' => 'Atualizar papel'],
    
            ['name' => 'create_permission', 'description' => 'Criar permissão'],
            ['name' => 'show_permissions', 'description' => 'Listar permissões'],
            ['name' => 'delete_permission', 'description' => 'Excluir permissão'],
            ['name' => 'update_permission', 'description' => 'Atualizar permissão'],
        ];
    }
}
