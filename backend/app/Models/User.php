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
        return $this->belongsTo(Company::class);
    }

    public function employee(): BelongsTo{
        return $this->belongsTo(Employee::class);
    }

    public function position(): HasOneThrough{
        return $this->hasOneThrough(Position::class, Employee::class,'id','id','employee_id','position_id')->withoutGlobalScope(NotDeletedScope::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->employee->name,
            'email' => $this->employee->email,
            'photo' => $this->photo,
            'position' => $this->position->name,
            'department' => $this->position->department->name,
            'company' => $this->company->legal_name
        ];
    }
}
