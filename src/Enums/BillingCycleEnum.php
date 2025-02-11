<?php

namespace Amirhome\LaravelSubscriptionManagment\Enums;

enum BillingCycleEnum: string
{
    case RECURRING = "recurring";
    case NON_RECURRING = "non-recurring";
}
