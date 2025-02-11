<?php

namespace Amirhome\LaravelSubscriptionManagment\Exceptions;

class SubscriptionRequiredExp extends \Exception
{
    /** @var string */
    protected $message = "You have to initialize subscription for this account first";
}
