<?php

namespace Amirhome\LaravelSubscriptionManagment\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionFeature extends Model
{
    use SoftDeletes, HasFactory;

    // protected $table = 'features';
    public function getTable(): string
    {
        return subscriptionTablePrefix() . 'features';
    }

    public const LIMITED_SELECT = [
        '0' => 'NO',
        '1' => 'YES',
    ];
    public const ACTIVE_SELECT = [
        '1' => 'Active',
        '0' => 'Passive',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'code',
        'description',
        'group_id',
        'active',
        'limited',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function group()
    {
        return $this->belongsTo(SubscriptionGroup::class, 'group_id');
    }

    // public function group(): BelongsTo
    // {
    //     return $this->belongsTo(SubscriptionGroup::class)->withDefault(function (SubscriptionGroup $group) {
    //         $group->setAttribute('name', 'Others');
    //     });
    // }

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
