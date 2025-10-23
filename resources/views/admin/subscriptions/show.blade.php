@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('laravel_subscription_managment::global.show') }} {{ trans('laravel_subscription_managment::cruds.subscription.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.subscriptions.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.id') }}
                        </th>
                        <td>
                            {{ $subscription->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.subscriber') }}
                        </th>
                        <td>
                            {{ $subscription->subscriber }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.subscriber_type') }}
                        </th>
                        <td>
                            {{ $subscription->subscriber_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.product') }}
                        </th>
                        <td>
                            {{ $subscription->product->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.unlimited') }}
                        </th>
                        <td>
                            {{ \Amirhome\LaravelSubscriptionManagment\Models\Subscription::UNLIMITED_SELECT[$subscription->unlimited] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.start_at') }}
                        </th>
                        <td>
                            {{ $subscription->start_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.end_at') }}
                        </th>
                        <td>
                            {{ $subscription->end_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.suppressed_at') }}
                        </th>
                        <td>
                            {{ $subscription->suppressed_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscription.fields.canceled_at') }}
                        </th>
                        <td>
                            {{ $subscription->canceled_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.subscriptions.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
