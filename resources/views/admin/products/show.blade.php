@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    {{ trans('laravel_subscription_managment::global.show') }} {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.subscription_products.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.id') }}
                        </th>
                        <td>
                            {{ $subscriptionProduct->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.name') }}
                        </th>
                        <td>
                            {{ $subscriptionProduct->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.code') }}
                        </th>
                        <td>
                            {{ $subscriptionProduct->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.description') }}
                        </th>
                        <td>
                            {{ $subscriptionProduct->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.group') }}
                        </th>
                        <td>
                            {{ $subscriptionProduct->group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.active') }}
                        </th>
                        <td>
                            {{ isset($subscriptionProduct->active) && !is_null($subscriptionProduct->active) ? Amirhome\LaravelSubscriptionManagment\Models\SubscriptionProduct::ACTIVE_SELECT[$subscriptionProduct->active] : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.type') }}
                        </th>
                        <td>
                            {{ $subscriptionProduct->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price') }}
                        </th>
                        <td>
                            {{ $subscriptionProduct->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price_yearly') }}
                        </th>
                        <td>
                            {{ $subscriptionProduct->price_yearly }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.concurrency') }}
                        </th>
                        <td>
                            {{ isset($subscriptionProduct->concurrency) && !is_null($subscriptionProduct->concurrency) ? Amirhome\LaravelSubscriptionManagment\Models\SubscriptionProduct::CONCURRENCY_RADIO[$subscriptionProduct->concurrency] : '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.subscription_products.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection