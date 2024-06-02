<?php

namespace App\Models;

use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\{Model};
use Illuminate\Database\Eloquent\Relations\{HasMany, HasManyThrough};

class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','legal_name','trade_name','cnpj','deleted','created_at','updated_at'];
    public $incrementing = false;
    public $timestamps = false;

    public function employees(): HasMany{
        return $this->hasMany(Employee::class);
    }

    public function departments(): HasMany{
        return $this->hasMany(Department::class);
    }

    public function positions(): HasManyThrough{
        return $this->hasManyThrough(Position::class, Department::class)->withoutGlobalScope(NotDeletedScope::class);
    }

    public function users():HasMany{
        return $this->hasMany(User::class);
    }

    public function roles(): HasMany{
        return $this->hasMany(Role::class);
    }

    public function permissions(): HasMany{
        return $this->hasMany(Permission::class);
    }
}
