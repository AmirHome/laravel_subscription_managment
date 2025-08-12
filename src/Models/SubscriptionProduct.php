<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionProduct extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'subscription_products';

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
}
