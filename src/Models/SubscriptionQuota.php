<?php

namespace Amirhome\LaravelSubscriptionManagment\Models;

use Amirhome\LaravelSubscriptionManagment\Traits\ValidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?Carbon $end_at
 * @property Feature $feature
 */
class SubscriptionQuota extends Model
{
    use ValidTrait;
    
    public function getTable(): string
    {
        return subscriptionTablePrefix() . 'quotas';
    }

    protected $fillable = ['subscription_id', 'code', 'limited', 'feature_id', 'quota', 'consumed', 'end_at'];
    protected $casts = [
        'quota' => 'double',
        'consumed' => 'double',
        'end_at' => 'datetime',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(SubscriptionFeature::class);
    }

    public function isActive(): bool
    {
        return (!$this->limited || ($this->consumed < $this->quota)) && $this->isValid();
    }

    public function scopeActive(Builder $query): Builder
    {
        /* @phpstan-ignore-next-line  */
        return $query->valid()->where(function (Builder $query) {
            $query->where('limited', false)
                ->orWhere(function (Builder $limited) {
                    $limited->where('limited', true)
                        ->whereColumn('quota', '>', 'consumed');
                });
        });
    }
}
