<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Company, Department};
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        $companies = Company::get(['id']);
        foreach ($companies as $company) {
            foreach (self::departments() as $department) {
                self::setData([
                    'name' => $department,
                    'company_id' => $company->id
                ],Department::class, true);
            }
        }
    }

    private static function departments()
    {
        return [
            'Recursos Humanos',
            'Finanças',
            'Vendas',
            'Marketing',
            'Tecnologia da Informação (TI)',
            'Operações',
            'Jurídico',
            'Atendimento ao Cliente',
            'Compras',
            'Qualidade',
            'Comunicação',
            'Sustentabilidade'
        ];
    }
}
