@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    {{ trans('laravel_subscription_managment::global.show') }} {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.features.index') }}">
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
                            {{ $feature->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.name') }}
                        </th>
                        <td>
                            {{ $feature->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.code') }}
                        </th>
                        <td>
                            {{ $feature->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.description') }}
                        </th>
                        <td>
                            {{ $feature->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.group') }}
                        </th>
                        <td>
                            {{ $feature->group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.active') }}
                        </th>
                        <td>
                            {{ Amirhome\LaravelSubscriptionManagment\Models\Feature::ACTIVE_SELECT[$feature->active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.limited') }}
                        </th>
                        <td>
                            {{ Amirhome\LaravelSubscriptionManagment\Models\Feature::LIMITED_SELECT[$feature->limited] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.features.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection