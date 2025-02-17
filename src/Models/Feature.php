<?php

namespace Amirhome\LaravelSubscriptionManagment\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?Group $group
 */
class Feature extends BaseModel
{
    protected $fillable = ['name', 'code', 'description', 'group_id', 'active', 'limited'];
    protected $casts = [
        'limited' => 'bool',
        'active' => 'bool',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class)->withDefault(function (Group $group) {
            $group->setAttribute('name', 'Others');
        });
    }

    public function isConsumable(): bool
    {
        return (bool)$this->limited;
    }

    public function isActive(): bool
    {
        return (bool)$this->active;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->whereAny(['name', 'description'], "like", "%$keyword%");
    }
}
