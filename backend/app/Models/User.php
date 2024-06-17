<?php

namespace App\Models;

use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Relations\{ BelongsTo, HasOneThrough};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','employee_id','password','created_by','modified_by','photo','created_at','updated_at','company_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function company(): BelongsTo{
        return $this->belongsTo(Company::class)->select(['id','legal_name']);
    }

    public function employee(): BelongsTo{
        return $this->belongsTo(Employee::class);
    }

    public function position(): HasOneThrough{
        return $this->hasOneThrough(Position::class, Employee::class,'id','id','employee_id','position_id')->withoutGlobalScope(NotDeletedScope::class);
    }
    
    public function createdBy():BelongsTo{
        return $this->belongsTo(Employee::class,'created_by','id')->select(['id','name']);
    }

    public function modifiedBy(): BelongsTo{
        return $this->belongsTo(Employee::class,'modified_by','id')->select(['id','name']);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'employee_id' => $this->employee->id,
            'name' => $this->employee->name,
            'email' => $this->employee->email,
            'visibility_level'  => $this->employee->visibility_level,
            'photo' => $this->photo,
            'position' => $this->position->name,
            'department' => $this->position->department ? $this->position->department->name : '',
            'role' => $this->employee->roles->pluck('name')[0],
            'company' => $this->company->legal_name
        ];
    }
}
