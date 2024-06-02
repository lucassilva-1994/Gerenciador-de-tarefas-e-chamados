<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Company, Permission};
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        foreach(Company::get() as $company){
            foreach(self::permissions() as $permission){
                $permission['company_id'] = $company->id;
                self::setData($permission,Permission::class, true);
            }
        }
    }

    private static function permissions() {
        return [
            ['name' => 'create_employee', 'description' => 'Criar funcionário'],
            ['name' => 'show_employees', 'description' => 'Listar funcionários'],
            ['name' => 'delete_employee', 'description' => 'Excluir funcionário'],
            ['name' => 'update_employee', 'description' => 'Atualizar funcionário'],
    
            ['name' => 'create_department', 'description' => 'Criar departamento'],
            ['name' => 'show_departments', 'description' => 'Listar departamentos'],
            ['name' => 'delete_department', 'description' => 'Excluir departamento'],
            ['name' => 'update_department', 'description' => 'Atualizar departamento'],
    
            ['name' => 'create_position', 'description' => 'Criar cargo'],
            ['name' => 'show_positions', 'description' => 'Listar cargos'],
            ['name' => 'delete_position', 'description' => 'Excluir cargo'],
            ['name' => 'update_position', 'description' => 'Atualizar cargo'],
    
            ['name' => 'create_project', 'description' => 'Criar projeto'],
            ['name' => 'show_projects', 'description' => 'Listar projetos'],
            ['name' => 'delete_project', 'description' => 'Excluir projeto'],
            ['name' => 'update_project', 'description' => 'Atualizar projeto'],
    
            ['name' => 'create_task', 'description' => 'Criar tarefa'],
            ['name' => 'show_tasks', 'description' => 'Listar tarefas'],
            ['name' => 'delete_task', 'description' => 'Excluir tarefa'],
            ['name' => 'update_task', 'description' => 'Atualizar tarefa'],
    
            ['name' => 'create_support_ticket', 'description' => 'Criar chamado'],
            ['name' => 'show_support_tickets', 'description' => 'Listar chamados'],
            ['name' => 'delete_support_ticket', 'description' => 'Excluir chamado'],
            ['name' => 'update_support_ticket', 'description' => 'Atualizar chamado'],
    
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
