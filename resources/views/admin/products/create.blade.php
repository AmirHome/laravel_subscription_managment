@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    {{ trans('laravel_subscription_managment::global.create') }} {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.title_singular') }}
    </div>

    <div class="card-body">
    <form method="POST" action="{{ route("ajax.subscription_products.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="code">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                @if($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="group_id">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.group') }}</label>
                <select class="form-control select2 {{ $errors->has('group') ? 'is-invalid' : '' }}" name="group_id" id="group_id">
                    @foreach($groups as $id => $entry)
                        <option value="{{ $id }}" {{ old('group_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('group'))
                    <span class="text-danger">{{ $errors->first('group') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.group_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.active') }}</label>
                <select class="form-control {{ $errors->has('active') ? 'is-invalid' : '' }}" name="active" id="active">
                    <option value disabled {{ is_null(old('active', null)) ? 'selected' : '' }}>{{ trans('laravel_subscription_managment::global.pleaseSelect') }}</option>
                    @foreach(Amirhome\LaravelSubscriptionManagment\Models\SubscriptionProduct::ACTIVE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (string) old('active', null) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('active'))
                    <span class="text-danger">{{ $errors->first('active') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.active_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ is_null(old('type', null)) ? 'selected' : '' }}>{{ trans('laravel_subscription_managment::global.pleaseSelect') }}</option>
                    @foreach(Amirhome\LaravelSubscriptionManagment\Models\SubscriptionProduct::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (string) old('type', null) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '0') }}" step="1">
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price_yearly">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price_yearly') }}</label>
                <input class="form-control {{ $errors->has('price_yearly') ? 'is-invalid' : '' }}" type="number" name="price_yearly" id="price_yearly" value="{{ old('price_yearly', '0') }}" step="1">
                @if($errors->has('price_yearly'))
                    <span class="text-danger">{{ $errors->first('price_yearly') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price_yearly_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.concurrency') }}</label>
                @foreach(Amirhome\LaravelSubscriptionManagment\Models\SubscriptionProduct::CONCURRENCY_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('concurrency') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="concurrency_{{ $key }}" name="concurrency" value="{{ $key }}" {{ (string) old('concurrency', null) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="concurrency_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('concurrency'))
                    <span class="text-danger">{{ $errors->first('concurrency') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.concurrency_helper') }}</span>
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