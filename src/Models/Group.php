<?php

namespace Amirhome\LaravelSubscriptionManagment\Models;

use Illuminate\Database\Eloquent\Builder;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends BaseModel
{
    use SoftDeletes;

    // protected $table = 'groups';
    
    protected $fillable = ['name', 'type'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        '1' => 'plan',
        '2' => 'plugin',
        '3' => 'feature',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->where('name', "like", "%$keyword%");
    }
}
