<?php

namespace Amirhome\LaravelSubscriptionManagment\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends BaseModel
{
    use SoftDeletes, HasFactory;

    protected $table = 'features';

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
        return $this->belongsTo(Group::class, 'group_id');
    }
}
