<?php

namespace App\Models;

use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([NotDeletedScope::class])]
class Project extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id','sequence','name','description','created_by','modified_by','deleted','created_at','updated_at'];
    public $timestamps = false;
    public $incrementing = false;

    public function createdBy():BelongsTo{
        return $this->belongsTo(User::class,'created_by','id')->select(['id','name']);
    }

    public function modifiedBy():BelongsTo{
        return $this->belongsTo(User::class,'modified_by','id')->select(['id','name']);
    }
}
