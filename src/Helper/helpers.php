<?php

use Amirhome\LaravelSubscriptionManagment\Models\Subscription;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;


if (!function_exists('subscription')) {
    function subscription(Model $model): ?Subscription
    {
        if (method_exists($model, 'getSubscription')) {
            return $model->getSubscription();
        }

        return null;
    }
}

if (!function_exists('gracedEndDateColumn')) {
    function gracedEndDateColumn(): Illuminate\Contracts\Database\Query\Expression|string
    {
        $graceDays = config('laravel_subscription_managment.grace_period', 0);
        if ($graceDays > 0) {
            if (DB::getDriverName() === 'sqlite') {
                return DB::raw(sprintf('date(end_at, "+%d days")', $graceDays));
            } else {
                return DB::raw(sprintf("DATE_ADD(end_at, INTERVAL %d DAY)", $graceDays));
            }
        }

        return "end_at";
    }
}

if (!function_exists('carbonParse')) {
    function carbonParse(mixed $datetime): CarbonInterface
    {
        return Carbon::parse($datetime);
    }
}

if (!function_exists('css')) {
    function css($filename): Htmlable
    {
        //        if (($light = @file_get_contents(__DIR__ . '/../../resources/styles.css')) === false) {
        //            throw new RuntimeException('Unable to load the dashboard light CSS.');
        //        }

        if (($app = @file_get_contents(__DIR__ . '/../../resources/css/'.$filename)) === false) {
            throw new RuntimeException('Unable to load the dashboard CSS.');
        }

        return new HtmlString(<<<HTML
            <style>{$app}</style>
            HTML
        );
    }
}
if (!function_exists('js')) {
    function js($filename): Htmlable
    {
        if (($js = @file_get_contents(__DIR__ . '/../../resources/js/'.$filename)) === false) {
            throw new RuntimeException('Unable to load the  dashboard JavaScript.');
        }

        $variable = Js::from([
            'path' => config('laravel_subscription_managment.path'),
        ]);

        return new HtmlString(<<<HTML
            <script type="module">
                window.Global = {$variable};
                {$js}
            </script>
            HTML
        );
    }
}

