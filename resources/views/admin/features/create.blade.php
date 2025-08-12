@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    {{ trans('laravel_subscription_managment::global.create') }} {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.title_singular') }}
    </div>

    <div class="card-body">
    <form method="POST" action="{{ route('ajax.subscription_features.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="code">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                @if($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="group_id">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.group') }}</label>
                <select class="form-control select2 {{ $errors->has('group') ? 'is-invalid' : '' }}" name="group_id" id="group_id">
                    @foreach($groups as $id => $entry)
                        <option value="{{ $id }}" {{ old('group_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('group'))
                    <span class="text-danger">{{ $errors->first('group') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.group_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.active') }}</label>
                
                <select class="form-control {{ $errors->has('active') ? 'is-invalid' : '' }}" name="active" id="active">
                    <option value disabled {{ old('active', null) === null ? 'selected' : '' }}>{{ trans('laravel_subscription_managment::global.pleaseSelect') }}</option>
                    @foreach($activeSelect as $key => $label)
                        <option value="{{ $key }}" {{ old('active', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('active'))
                    <span class="text-danger">{{ $errors->first('active') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.active_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.limited') }}</label>
                <select class="form-control {{ $errors->has('limited') ? 'is-invalid' : '' }}" name="limited" id="limited">
                    <option value disabled {{ old('limited', null) === null ? 'selected' : '' }}>{{ trans('laravel_subscription_managment::global.pleaseSelect') }}</option>
                    @foreach($limitedSelect as $key => $label)
                        <option value="{{ $key }}" {{ old('limited', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('limited'))
                    <span class="text-danger">{{ $errors->first('limited') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.limited_helper') }}</span>
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