<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id','sequence','name','description','created_by','modified_by','deleted','created_at','updated_at'];
    public $timestamps = false;
    public $incrementing = false;

    public function users(): BelongsToMany{
        return $this->belongsToMany(User::class,'role_user','role_id','user_id');
    }

    public function permissions(): BelongsToMany{
        return $this->belongsToMany(Permission::class,'permission_role','role_id','permission_id');
    }
}
