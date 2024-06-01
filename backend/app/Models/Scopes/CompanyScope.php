<?php
namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\{Builder, Model, Scope};

//Todos os models que estiver usando esse escopo vai retornar registros apenas da compania do usuário que está logado.
class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->check()) {
            $tableName = $model->getTable();
            $builder->where("$tableName.company_id", auth()->user()->company_id);
        }
    }
}
