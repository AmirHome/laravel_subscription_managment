<?php

namespace Amirhome\LaravelSubscriptionManagment\Models;

use Amirhome\LaravelSubscriptionManagment\Concerns\ContractUI;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionProduct extends Model implements ContractUI
{
    use SoftDeletes, HasFactory;

    public function getTable(): string
    {
        return subscriptionTablePrefix() . 'products';
    }

    public const CONCURRENCY_RADIO = [
        '1' => '$',
        '2' => '₺',
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

    public const TYPE_SELECT = [
        '0' => 'non-recurring',
        '1' => 'recurring',
    ];

    protected $fillable = [
        'name',
        'code',
        'description',
        'group_id',
        'active',
        'type',
        'price',
        'price_yearly',
        'concurrency',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function group()
    {
        return $this->belongsTo(SubscriptionGroup::class, 'group_id');
    }

    public function features()
    {
        $prefix = subscriptionTablePrefix();

        return $this->belongsToMany(
            Feature::class,
            "{$prefix}product_feature",
            "plan_id",
            "feature_id",
        )->withPivot('value', 'active');
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function isRecurring(): bool
    {
        return $this->type === self::TYPE_SELECT['1'];
    }

    public function isActive(): bool
    {
        return (bool)$this->active;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function getFeatures()
    {
        $this->loadMissing('features');

        return $this->features;
    }

    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->whereAny(['name', 'description'], "like", "%$keyword%");
    }
}
