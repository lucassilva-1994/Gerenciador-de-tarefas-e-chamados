<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope, NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasOne, HasOneThrough};

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','email', 'visibility_level','created_by','modified_by','deleted','created_at','updated_at','position_id','company_id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $hidden = ['position_id','company_id','updated_at'];

    public function hasUser(): HasOne{
        return $this->hasOne(User::class)->select(['id','employee_id']);
    }

    public function company(): BelongsTo{
        return $this->belongsTo(Company::class,'company_id','id')->select(['id','legal_name']);
    }

    public function position(): BelongsTo{
        return $this->belongsTo(Position::class);
    }


    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class,'employee_role','employee_id','role_id');
    }

    public function abilities(){
        return $this->roles->map->permissions->flatten()->pluck('name');
    }

    public function department(): HasOneThrough {
        return $this->hasOneThrough(Department::class, Position::class, 'id', 'id', 'position_id', 'department_id');
    }
    

    public function createdBy():BelongsTo{
        return $this->belongsTo(Employee::class,'created_by','id')->select(['id','name']);
    }

    public function modifiedBy(): BelongsTo{
        return $this->belongsTo(Employee::class,'modified_by','id')->select(['id','name']);
    }
}
