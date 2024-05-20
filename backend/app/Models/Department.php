<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope,NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasManyThrough};

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','created_by','modified_by','deleted','created_at','updated_at','company_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function positions(): HasMany{
        return $this->hasMany(Position::class);
    }
}
