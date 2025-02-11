<?php

namespace Amirhome\LaravelSubscriptionManagment\Enums;

enum TransactionTypeEnum: string
{
    case NEW = "new";
    case RENEW = "renew";
    case CANCEL = "cancel";
    case RESUME = "resume";
}
