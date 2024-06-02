<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ScopedBy([CompanyScope::class])]
class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','description','created_at','updated_at','company_id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $hidden = ['created_at','updated_at','company_id','sequence'];

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class,'permission_role','permission_id','role_id');
    }
}
