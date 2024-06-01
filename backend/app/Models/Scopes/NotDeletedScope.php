<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\{Builder, Model, Scope};
//Todos os models que estiver usando esse scopo por padrão vai retornar apenas registro ao qual  o status "deleted" estiver como "falso"
class NotDeletedScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        // Aplica o escopo caso o modelo não tenha nenhum relacionamento HasManyThrough ou HasOneThrough
        $tableName = $model->getTable();
        $builder->where("$tableName.deleted", 0)->orderBy("$tableName.sequence", 'DESC');
    }
}
