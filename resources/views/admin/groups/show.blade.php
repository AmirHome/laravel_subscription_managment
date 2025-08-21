@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('laravel_subscription_managment::global.show') }} {{ trans('laravel_subscription_managment::cruds.subscriptionGroup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.subscription-groups.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionGroup.fields.id') }}
                        </th>
                        <td>
                            {{ $subscriptionGroup->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionGroup.fields.name') }}
                        </th>
                        <td>
                            {{ $subscriptionGroup->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('laravel_subscription_managment::cruds.subscriptionGroup.fields.type') }}
                        </th>
                        <td>
                            {{ $subscriptionGroup->type ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('ajax.subscription-groups.index') }}">
                    {{ trans('laravel_subscription_managment::global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection