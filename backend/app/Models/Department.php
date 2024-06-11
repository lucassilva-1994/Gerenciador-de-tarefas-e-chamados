<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope,NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasManyThrough, HasOneThrough};

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','sequence', 'name','created_by','modified_by','deleted','created_at','updated_at','company_id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $hidden = ['sequence','created_at','updated_at','company_id','deleted'];

    public function positions(): HasMany{
        return $this->hasMany(Position::class);
    }

    public function employees(): HasManyThrough {
        return $this->hasManyThrough(Employee::class, Position::class, 'department_id', 'position_id')->select(['employees.name']);;
    }

    public function createdBy():BelongsTo{
        return $this->belongsTo(Employee::class,'created_by','id')->select(['id','name']);
    }

    public function modifiedBy(): BelongsTo{
        return $this->belongsTo(Employee::class,'modified_by','id')->select(['id','name']);
    }
}
