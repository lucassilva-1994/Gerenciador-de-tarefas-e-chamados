<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskComment extends Model
{
    protected $table = 'task_comments';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id','sequence','comment','task_id', 'source','user_id','deleted','created_at','updated_at'];
    public $timestamps = false;
    public $incrementing = false;

    public function user():BelongsTo{
        return $this->belongsTo(User::class)->select(['id','name','email','photo']);
    }

    public function getCreatedAtAttribute($value)
    {
        return now()->parse($value)->diffForHumans();
    }

    protected static function booted(): void
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->orderByDesc('sequence');
        });
    }
}
