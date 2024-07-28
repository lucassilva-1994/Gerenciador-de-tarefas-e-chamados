<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\{Builder, Model, Scope};

class VisibilityScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $user = auth()->user();
        if($user->visibility == 3){
            $builder->where('owner_id', $user->id);
        } else if($user->visibility == 2){
            $builder->whereHas('owner', function ($query) use($user) {
                $query->where('department_id', $user->department_id);
            });
            //$builder->orWhere('department_id', $user->department_id);
        }
    }
}
