<?php

namespace Amirhome\LaravelSubscriptionManagment\Enums;

enum GroupTypeEnum: string
{
    case PLAN = "plan";
    case PLUGIN = "plugin";
    case FEATURE = "feature";
}
