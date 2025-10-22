@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#product_edit" role="tab" data-toggle="tab">
                {{ trans('laravel_subscription_managment::global.edit') }} {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.title_singular') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#product_features" role="tab" data-toggle="tab">
                {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.title') }}
            </a>
        </li>
    </ul>

    <div class="tab-content">
        {{-- Tab 1: Product Edit Form --}}
        <div class="tab-pane active m-3" role="tabpanel" id="product_edit">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route("ajax.subscription-products.update", [$subscriptionProduct->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $subscriptionProduct->name) }}">
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="code">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.code') }}</label>
                            <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $subscriptionProduct->code) }}" required>
                            @if($errors->has('code'))
                                <span class="text-danger">{{ $errors->first('code') }}</span>
                            @endif
                            <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.description') }}</label>
                            <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', $subscriptionProduct->description) }}">
                            @if($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                            <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="group_id">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.group') }}</label>
                            <select class="form-control select2 {{ $errors->has('group') ? 'is-invalid' : '' }}" name="group_id" id="group_id">
                                @foreach($groups as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('group_id') ? old('group_id') : $subscriptionProduct->group->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                                <option value disabled {{ is_null(old('active', isset($subscriptionProduct) ? $subscriptionProduct->active : null)) ? 'selected' : '' }}>{{ trans('laravel_subscription_managment::global.pleaseSelect') }}</option>
                                @foreach($productActiveStatus as $key => $label)
                                    <option value="{{ $key }}" {{ (string) old('active', isset($subscriptionProduct) ? $subscriptionProduct->active : null) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                                <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('laravel_subscription_managment::global.pleaseSelect') }}</option>
                                @foreach($productTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', $subscriptionProduct->type) === (string) $label ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                            <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="price">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price') }}</label>
                            <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $subscriptionProduct->price) }}" step="1">
                            @if($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                            <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="price_yearly">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price_yearly') }}</label>
                            <input class="form-control {{ $errors->has('price_yearly') ? 'is-invalid' : '' }}" type="number" name="price_yearly" id="price_yearly" value="{{ old('price_yearly', $subscriptionProduct->price_yearly) }}" step="1">
                            @if($errors->has('price_yearly'))
                                <span class="text-danger">{{ $errors->first('price_yearly') }}</span>
                            @endif
                            <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price_yearly_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.concurrency') }}</label>
                            @foreach(Amirhome\LaravelSubscriptionManagment\Models\SubscriptionProduct::CONCURRENCY_RADIO as $key => $label)
                                <div class="form-check {{ $errors->has('concurrency') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="concurrency_{{ $key }}" name="concurrency" value="{{ $key }}" {{ (string) old('concurrency', isset($subscriptionProduct) ? $subscriptionProduct->concurrency : null) === (string) $key ? 'checked' : '' }}>
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
        </div>

        {{-- Tab 2: Product Features --}}
        <div class="tab-pane m-3" role="tabpanel" id="product_features">
            @includeIf('laravel_subscription_managment::admin.products.relationships.productFeatures')
        </div>
    </div>
</div>

@endsection