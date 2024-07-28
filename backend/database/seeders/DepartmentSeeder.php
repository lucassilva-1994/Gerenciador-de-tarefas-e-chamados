<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Traits\ModelTrait;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    use ModelTrait;
    public function run(): void
    {
        foreach(self::departments() as $department){
            self::createRecord(Department::class, $department);
        }
    }

    private static function departments() {
        return [
            ['name' => 'Financeiro', 'description' => 'Gerencia as finanças e orçamentos da empresa'],
            ['name' => 'Recursos Humanos', 'description' => 'Responsável pelo recrutamento e gestão de funcionários'],
            ['name' => 'Marketing', 'description' => 'Promove a empresa e seus produtos ou serviços'],
            ['name' => 'Vendas', 'description' => 'Gerencia as atividades de vendas e relacionamento com clientes'],
            ['name' => 'TI', 'description' => 'Cuida da infraestrutura tecnológica e suporte de TI'],
            ['name' => 'Operações', 'description' => 'Gerencia as operações diárias e produção'],
            ['name' => 'Logística', 'description' => 'Coordena o transporte e armazenamento de produtos'],
            ['name' => 'Compras', 'description' => 'Responsável pela aquisição de bens e serviços'],
            ['name' => 'Pesquisa e Desenvolvimento', 'description' => 'Foca na inovação e desenvolvimento de novos produtos'],
            ['name' => 'Produção', 'description' => 'Gerencia a fabricação de produtos'],
            ['name' => 'Controle de Qualidade', 'description' => 'Assegura a qualidade dos produtos e processos'],
            ['name' => 'Serviço ao Cliente', 'description' => 'Oferece suporte e atendimento aos clientes'],
            ['name' => 'Jurídico', 'description' => 'Cuida de assuntos legais e conformidade jurídica'],
            ['name' => 'Relações Públicas', 'description' => 'Gerencia a imagem da empresa e comunicação externa'],
            ['name' => 'Administração', 'description' => 'Coordena as atividades administrativas da empresa'],
            ['name' => 'Auditoria', 'description' => 'Realiza auditorias internas e externas'],
            ['name' => 'Treinamento e Desenvolvimento', 'description' => 'Desenvolve programas de treinamento para funcionários'],
            ['name' => 'Planejamento Estratégico', 'description' => 'Define as estratégias e objetivos da empresa'],
            ['name' => 'Desenvolvimento de Negócios', 'description' => 'Explora novas oportunidades de negócio'],
            ['name' => 'Gestão de Projetos', 'description' => 'Gerencia projetos e iniciativas da empresa'],
            ['name' => 'Compliance', 'description' => 'Assegura que a empresa esteja em conformidade com regulamentações'],
            ['name' => 'Gestão de Riscos', 'description' => 'Identifica e mitiga riscos operacionais'],
            ['name' => 'Gestão de Mudanças', 'description' => 'Gerencia mudanças organizacionais'],
            ['name' => 'Suporte Técnico', 'description' => 'Oferece suporte técnico a funcionários e clientes'],
            ['name' => 'Desenvolvimento de Produto', 'description' => 'Gerencia o ciclo de vida dos produtos'],
            ['name' => 'Engenharia', 'description' => 'Desenvolve soluções de engenharia para a empresa'],
            ['name' => 'Manutenção', 'description' => 'Realiza manutenção de equipamentos e instalações'],
            ['name' => 'Segurança da Informação', 'description' => 'Protege as informações e dados da empresa'],
            ['name' => 'Saúde e Segurança Ocupacional', 'description' => 'Promove a saúde e segurança dos funcionários'],
            ['name' => 'Meio Ambiente', 'description' => 'Gerencia as práticas ambientais da empresa']
        ];
    }
}
