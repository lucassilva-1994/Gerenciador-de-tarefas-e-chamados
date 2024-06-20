<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope, NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class SupportTicket extends Model
{
    protected $table = 'support_tickets';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','title','description','status','created_by','modified_by','deleted','created_at','updated_at','owner_id','viewed_by','company_id','project_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function setOwnerIdAttribute($value) {
        if(auth()->user()->employee->visibility_level == 'RESTRICTED'){
            $this->attributes['owner_id'] = null;
        } else {
            $this->attributes['owner_id'] = $value;
        }
    }

    public function project(): BelongsTo{
        return $this->belongsTo(Project::class,'project_id','id')->select(['id','name']);
    }

    public function viewer(): BelongsTo{
        return $this->belongsTo(User::class,'viewed_by','id')->select(['id','name']);
    }

    public function owner(): BelongsTo{
        return $this->belongsTo(Employee::class,'owner_id','id')->select(['id','name','email']);
    }

    public function createdBy():BelongsTo{
        return $this->belongsTo(Employee::class,'created_by','id')->select(['id','name']);
    }

    public function modifiedBy(): BelongsTo{
        return $this->belongsTo(Employee::class,'modified_by','id')->select(['id','name']);
    }
}
