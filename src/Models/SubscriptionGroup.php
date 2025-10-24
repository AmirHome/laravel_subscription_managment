<?php

namespace Amirhome\LaravelSubscriptionManagment\Models;

use Illuminate\Database\Eloquent\Builder;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class SubscriptionGroup extends Model
{
    use SoftDeletes;

    public function getTable(): string
    {
        return subscriptionTablePrefix() . 'groups';
    }

    protected $fillable = ['name', 'type'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        '1' => 'Product',
        '2' => 'Feature',
        // '3' => 'plugin',
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
