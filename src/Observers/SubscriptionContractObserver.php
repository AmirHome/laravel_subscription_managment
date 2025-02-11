<?php

namespace Amirhome\LaravelSubscriptionManagment\Observers;

use Amirhome\LaravelSubscriptionManagment\Models\SubscriptionContract;

class SubscriptionContractObserver
{
    public function creating(SubscriptionContract $item): void
    {
        $nextNumber = SubscriptionContract::latest()->first()->number ?? 0;
        $item->setAttribute('number', $nextNumber + 1);
    }
}
