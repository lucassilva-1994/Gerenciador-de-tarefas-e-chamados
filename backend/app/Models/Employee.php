<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope, NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasOne, HasOneThrough};

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','email','created_by','modified_by','deleted','created_at','updated_at','position_id','company_id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $hidden = ['position_id','company_id'];

    public function user(): HasOne{
        return $this->hasOne(User::class)->select(['id as user_id','employee_id']);
    }

    public function company(): BelongsTo{
        return $this->belongsTo(Company::class,'company_id','id')->select(['id','legal_name']);
    }

    public function position(): BelongsTo{
        return $this->belongsTo(Position::class)->select(['id','name']);
    }

    public function createdBy():BelongsTo{
        return $this->belongsTo(Employee::class,'created_by','id')->select(['id','name']);
    }

    public function modifiedBy(): BelongsTo{
        return $this->belongsTo(Employee::class,'modified_by','id')->select(['id','name']);
    }
}
