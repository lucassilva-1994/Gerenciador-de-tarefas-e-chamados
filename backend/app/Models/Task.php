<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope, NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\{Builder,Model};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','title','description','status','created_by','modified_by','deleted','created_at','updated_at','owner_id','viewed_by','company_id','support_ticket_id','project_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function project(): BelongsTo{
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function supportTicket(): BelongsTo{
        return $this->belongsTo(SupportTicket::class,'support_ticket_id','id');
    }

    public function viewer(): BelongsTo{
        return $this->belongsTo(User::class,'viewed_by','id');
    }

    public function owner(): BelongsTo{
        return $this->belongsTo(Employee::class,'owner_id','id');
    }

    public function createdBy():BelongsTo{
        return $this->belongsTo(Employee::class,'created_by','id');
    }

    public function modifiedBy(): BelongsTo{
        return $this->belongsTo(Employee::class,'modified_by','id');
    }

    protected static function booted(): void
    {
        static::addGlobalScope('taskScope', function (Builder $builder) {
            if(auth()->user()->employee->visibility_level == 'RESTRICTED'){
                $builder->where('owner_id', auth()->user()->employee_id);
            }
        });
    }
}
