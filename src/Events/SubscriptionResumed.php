<?php

namespace Amirhome\LaravelSubscriptionManagment\Events;

use Amirhome\LaravelSubscriptionManagment\Models\Subscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionResumed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Subscription $subscription)
    {
    }
}
