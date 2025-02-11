<?php

namespace Amirhome\LaravelSubscriptionManagment\Exceptions;

class FeatureNotFoundExp extends \Exception
{
    /** @var string */
    protected $message = "The feature you are trying to access in not found under the current subscription";
}
