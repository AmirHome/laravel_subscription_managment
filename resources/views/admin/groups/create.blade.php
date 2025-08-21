@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('laravel_subscription_managment::global.create') }} {{ trans('laravel_subscription_managment::cruds.subscriptionGroup.title_singular') }}
    </div>

    <div class="card-body">
    <form method="POST" action="{{ route("ajax.subscription-groups.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('laravel_subscription_managment::cruds.subscriptionGroup.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionGroup.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('laravel_subscription_managment::cruds.subscriptionGroup.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('laravel_subscription_managment::global.pleaseSelect') }}</option>
                    @foreach($groupTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $label ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionGroup.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('laravel_subscription_managment::global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection