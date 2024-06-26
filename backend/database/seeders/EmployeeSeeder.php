<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Company, Employee};
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class EmployeeSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        $companies = Company::get();
        foreach ($companies as $company) {
                for ($i = 0; $i < 20;  $i++) {
                    $name = self::replaceName(fake()->name());
                    $email = self::generateEmail($name);
                    $verify = Employee::whereEmail($email)->exists();
                    if (!$verify) {
                        self::setData([
                            'name' => $name,
                            'email' => $email,
                            'visibility_level' => Arr::random(['GENERAL','RESTRICTED']),
                            'company_id' => $company->id,
                            'position_id' => Arr::random($company->positions->pluck('id')->toArray())
                        ],Employee::class, true);
                    }
            }
        }
    }

    private static function generateEmail($name)
    {
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $name =  preg_replace('/[^a-zA-Z0-9]/', '', strtolower(str_replace([' ', 'Dr.', 'Sr.', 'Srta.', 'Sra.'], '', $name)));
        return $name . '@' . Arr::random([fake()->freeEmailDomain()]);
    }

    private static function replaceName($name) {
        return preg_replace('/^(Dr\.|Sr\.|Srta\.|Sra\.)\s*/', '', $name);
    }
}
