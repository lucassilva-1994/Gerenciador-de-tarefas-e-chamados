<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id','sequence','name','description','created_by','modified_by','deleted','created_at','updated_at'];
    public $timestamps = false;
    public $incrementing = false;

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class,'permission_role','permission_id','role_id');
    }
}
