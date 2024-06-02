<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope, NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','description', 'created_at', 'updated_at','created_by','modified_by','company_id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $hidden = ['sequence','created_at','updated_at','company_id','deleted'];

    public function employees(): BelongsToMany{
        return $this->belongsToMany(Employee::class,'employee_role');
    }

    public function permissions(): BelongsToMany{
        return $this->belongsToMany(Permission::class,'permission_role')->select(['id','name','description']);
    }
}
