<?php

namespace Amirhome\LaravelSubscriptionManagment\Models;


use Illuminate\Database\Eloquent\Builder;

class Group extends BaseModel
{
    protected $fillable = ['name', 'type'];
    protected $casts = [
        // 'type' => GroupTypeEnum::class,
    ];

    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->where('name', "like", "%$keyword%");
    }
}
