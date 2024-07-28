<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id', 'sequence', 'name', 'username', 'password', 'email', 'deleted','photo', 'visibility','created_by','modified_by', 'created_at', 'updated_at', 'department_id','role_type'];
    public $timestamps = false;
    public $incrementing = false;
    protected $hidden = ['password'];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class)->select(['id','name','description']);
    }

    public function projects(): HasMany{
        return $this->hasMany(Project::class);
    }

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'department' => $this->department->name ?? 'Departamento inativo',
            'username' => $this->username,
            'visibility' => $this->visibility,
            'visibility_name' => $this->visibility == 1 ? 'Administrador' : ($this->visibility == 2 ? 'Gerente' : 'Operacional')
        ];
    }
}
