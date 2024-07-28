<?php

namespace App\Models;

use App\Models\Scopes\{VisibilityScope, NotDeletedScope};
use App\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([NotDeletedScope::class, VisibilityScope::class])]
#[ObservedBy([TaskObserver::class])]
class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id','sequence','title','description','is_done','deleted','created_by','modified_by','created_at','updated_at','owner_id','project_id'];
    public $timestamps = false;
    public $incrementing = false;

    public function getUpdatedAtAttribute($value)
    {
        return now()->parse($value)->format('d/m/Y H:i:s');
    }

    public function owner(): BelongsTo{
        return $this->belongsTo(User::class,'owner_id','id')->select(['id','name']);
    }

    public function createdBy():BelongsTo{
        return $this->belongsTo(User::class,'created_by','id')->select(['id','name']);
    }

    public function modifiedBy():BelongsTo{
        return $this->belongsTo(User::class,'modified_by','id')->select(['id','name']);
    }

    public function project(): BelongsTo{
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function comments(): HasMany{
        return $this->hasMany(TaskComment::class);
    }
}
