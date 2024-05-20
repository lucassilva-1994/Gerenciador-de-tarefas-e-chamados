<?php

namespace App\Models;

use App\Models\Scopes\{CompanyScope, NotDeletedScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasOne};

#[ScopedBy([NotDeletedScope::class, CompanyScope::class])]
class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','email','created_by','modified_by','deleted','created_at','updated_at','position_id','company_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function user(): HasOne{
        return $this->hasOne(User::class);
    }

    public function position(): BelongsTo{
        return $this->belongsTo(Position::class);
    }
}
