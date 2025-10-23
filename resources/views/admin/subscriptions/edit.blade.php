@extends('laravel_subscription_managment::layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('laravel_subscription_managment::global.edit') }} {{ trans('laravel_subscription_managment::cruds.subscription.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("ajax.subscriptions.update", [$subscription->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="subscriber">{{ trans('laravel_subscription_managment::cruds.subscription.fields.subscriber') }}</label>
                <input class="form-control {{ $errors->has('subscriber') ? 'is-invalid' : '' }}" type="number" name="subscriber" id="subscriber" value="{{ old('subscriber', $subscription->subscriber) }}" step="1">
                @if($errors->has('subscriber'))
                    <span class="text-danger">{{ $errors->first('subscriber') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscription.fields.subscriber_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="subscriber_type">{{ trans('laravel_subscription_managment::cruds.subscription.fields.subscriber_type') }}</label>
                <input class="form-control {{ $errors->has('subscriber_type') ? 'is-invalid' : '' }}" type="text" name="subscriber_type" id="subscriber_type" value="{{ old('subscriber_type', $subscription->subscriber_type) }}">
                @if($errors->has('subscriber_type'))
                    <span class="text-danger">{{ $errors->first('subscriber_type') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscription.fields.subscriber_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="product_id">{{ trans('laravel_subscription_managment::cruds.subscription.fields.product') }}</label>
                <select class="form-control select2 {{ $errors->has('product') ? 'is-invalid' : '' }}" name="product_id" id="product_id" required>
                    @foreach($products as $id => $entry)
                        <option value="{{ $id }}" {{ (old('product_id') ? old('product_id') : $subscription->product->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('product'))
                    <span class="text-danger">{{ $errors->first('product') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscription.fields.product_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('laravel_subscription_managment::cruds.subscription.fields.unlimited') }}</label>
                <select class="form-control {{ $errors->has('unlimited') ? 'is-invalid' : '' }}" name="unlimited" id="unlimited">
                    <option value disabled {{ old('unlimited', null) === null ? 'selected' : '' }}>{{ trans('laravel_subscription_managment::global.pleaseSelect') }}</option>
                    @foreach(\Amirhome\LaravelSubscriptionManagment\Models\Subscription::UNLIMITED_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('unlimited', $subscription->unlimited) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('unlimited'))
                    <span class="text-danger">{{ $errors->first('unlimited') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscription.fields.unlimited_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_at">{{ trans('laravel_subscription_managment::cruds.subscription.fields.start_at') }}</label>
                <input class="form-control datetime {{ $errors->has('start_at') ? 'is-invalid' : '' }}" type="text" name="start_at" id="start_at" value="{{ old('start_at', $subscription->start_at) }}">
                @if($errors->has('start_at'))
                    <span class="text-danger">{{ $errors->first('start_at') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscription.fields.start_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_at">{{ trans('laravel_subscription_managment::cruds.subscription.fields.end_at') }}</label>
                <input class="form-control datetime {{ $errors->has('end_at') ? 'is-invalid' : '' }}" type="text" name="end_at" id="end_at" value="{{ old('end_at', $subscription->end_at) }}">
                @if($errors->has('end_at'))
                    <span class="text-danger">{{ $errors->first('end_at') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscription.fields.end_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="suppressed_at">{{ trans('laravel_subscription_managment::cruds.subscription.fields.suppressed_at') }}</label>
                <input class="form-control datetime {{ $errors->has('suppressed_at') ? 'is-invalid' : '' }}" type="text" name="suppressed_at" id="suppressed_at" value="{{ old('suppressed_at', $subscription->suppressed_at) }}">
                @if($errors->has('suppressed_at'))
                    <span class="text-danger">{{ $errors->first('suppressed_at') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscription.fields.suppressed_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="canceled_at">{{ trans('laravel_subscription_managment::cruds.subscription.fields.canceled_at') }}</label>
                <input class="form-control datetime {{ $errors->has('canceled_at') ? 'is-invalid' : '' }}" type="text" name="canceled_at" id="canceled_at" value="{{ old('canceled_at', $subscription->canceled_at) }}">
                @if($errors->has('canceled_at'))
                    <span class="text-danger">{{ $errors->first('canceled_at') }}</span>
                @endif
                <span class="help-block">{{ trans('laravel_subscription_managment::cruds.subscription.fields.canceled_at_helper') }}</span>
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
