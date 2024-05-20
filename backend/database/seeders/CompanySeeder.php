<?php

namespace Database\Seeders;
use App\Helpers\HelperModel;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Avlima\PhpCpfCnpjGenerator\Generator;

class CompanySeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $trade_name = fake()->company();
            $legal_name = fake()->company();
            $cnpj = Generator::cnpj(true);
            $verify = Company::whereTradeNameOrLegalNameOrCnpj($trade_name, $legal_name, $cnpj)->exists();
            if (!$verify) {
                self::setData([
                    'trade_name' => $trade_name,
                    'legal_name' => $legal_name,
                    'cnpj' => $cnpj
                ], Company::class);
            }
        }
    }
}
