<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope, NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class Position extends Model
{
    protected $table = 'positions';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','created_by','modified_by','deleted','created_at','updated_at','company_id','department_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function department(): BelongsTo{
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function employees(): HasMany{
        return $this->hasMany(Employee::class);
    }

    public function createdBy():BelongsTo{
        return $this->belongsTo(Employee::class,'created_by','id')->select(['id','name']);
    }

    public function modifiedBy(): BelongsTo{
        return $this->belongsTo(Employee::class,'modified_by','id')->select(['id','name']);
    }
}
