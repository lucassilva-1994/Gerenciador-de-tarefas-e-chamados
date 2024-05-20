<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Department, Position};
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        foreach (self::departments() as $department => $position) {
            $departments = Department::where('name', $department)->get(['id','company_id']);
            foreach($departments as $department_id){
                foreach ($position as $positionName) {
                    self::setData([
                        'name' => $positionName,
                        'department_id' => $department_id->id,
                        'company_id' => $department_id->company_id
                    ], Position::class);
                }
            }
        }
    }

    private static function departments(){
        return [
            'Recursos Humanos' => [
                'Gerente de Recursos Humanos',
                'Analista de Treinamento',
                'Assistente de Recrutamento',
            ],
            'Finanças' => [
                'Diretor Financeiro',
                'Analista Financeiro',
                'Assistente Contábil',
            ],
            'Vendas' => [
                'Diretor de Vendas',
                'Gerente de Contas',
                'Representante de Vendas',
            ],
            'Marketing' => [
                'Diretor de Marketing',
                'Especialista em SEO',
                'Analista de Mídias Sociais',
            ],
            'Tecnologia da Informação (TI)' => [
                'Diretor de TI',
                'Desenvolvedor de Software',
                'Administrador de Sistemas',
            ],
            'Operações' => [
                'Diretor de Operações',
                'Gerente de Produção',
                'Supervisor de Logística',
            ],
            'Jurídico' => [
                'Diretor Jurídico',
                'Advogado Corporativo',
                'Analista Jurídico',
            ],
            'Atendimento ao Cliente' => [
                'Gerente de Atendimento ao Cliente',
                'Especialista em Suporte',
                'Assistente de Atendimento',
            ],
            'Compras' => [
                'Diretor de Compras',
                'Analista de Compras',
                'Especialista em Suprimentos',
            ],
            'Qualidade' => [
                'Diretor de Qualidade',
                'Engenheiro de Qualidade',
                'Analista de Controle de Qualidade',
            ],
            'Comunicação' => [
                'Diretor de Comunicação',
                'Assessor de Imprensa',
                'Especialista em Comunicação Interna',
            ],
            'Sustentabilidade' => [
                'Coordenador de Sustentabilidade',
                'Analista de Responsabilidade Social',
            ],
        ];
    }
}
