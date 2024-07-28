<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\{Builder,Model, Scope};

class NotDeletedScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tableName = $model->getTable();
        $builder->where("$tableName.deleted",0)->orderByDesc("sequence");
    }
}
