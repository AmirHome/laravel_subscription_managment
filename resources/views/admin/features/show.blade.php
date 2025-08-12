@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    {{ trans('laravel_subscription_managment::global.show') }} {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.subscription_features.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.id') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.name') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.code') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.description') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.group') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.active') }}
                        </th>
                        <td>
                            {{ Amirhome\LaravelSubscriptionManagment\Models\Feature::ACTIVE_SELECT[$subscriptionFeature->active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.limited') }}
                        </th>
                        <td>
                            {{ Amirhome\LaravelSubscriptionManagment\Models\Feature::LIMITED_SELECT[$subscriptionFeature->limited] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.subscription_features.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection