@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subscriptionFeature.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscription-features.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionFeature.fields.id') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionFeature.fields.name') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionFeature.fields.code') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionFeature.fields.description') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionFeature.fields.group') }}
                        </th>
                        <td>
                            {{ $subscriptionFeature->group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionFeature.fields.active') }}
                        </th>
                        <td>
                            {{ App\Models\SubscriptionFeature::ACTIVE_SELECT[$subscriptionFeature->active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionFeature.fields.limited') }}
                        </th>
                        <td>
                            {{ App\Models\SubscriptionFeature::LIMITED_SELECT[$subscriptionFeature->limited] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscription-features.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection