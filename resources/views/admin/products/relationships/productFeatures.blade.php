<div class="card">
    <div class="card-header">
        {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.title') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('ajax.subscription-products.updateProductFeatures', $subscriptionProduct->id) }}">
            @csrf
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.name') }}</th>
                            <th width="200">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.value') }}</th>
                            <th width="100">{{ trans('laravel_subscription_managment::cruds.subscriptionFeature.fields.active') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $all_features = \Amirhome\LaravelSubscriptionManagment\Models\SubscriptionFeature::with('group')->get()->groupBy('group.name');
                            $attached_features = $subscriptionProduct->features->pluck('pivot', 'id');
                        @endphp

                        @foreach($all_features as $group_name => $features)
                            <tr class="table-secondary">
                                <td colspan="3">
                                    <strong>{{ $group_name ?: trans('laravel_subscription_managment::global.ungrouped') }}</strong>
                                </td>
                            </tr>
                            @foreach($features as $feature)
                                @php
                                    $pivot = $attached_features->get($feature->id);
                                    $is_attached = !is_null($pivot);
                                    $value = $is_attached ? $pivot->value : 0;
                                    $active = $is_attached ? $pivot->active : 0;
                                @endphp
                                <tr>
                                    <td>
                                        {{ $feature->name }}
                                        @if($feature->code)
                                            <small class="text-muted">({{ $feature->code }})</small>
                                        @endif
                                        @if($feature->limited)
                                            <span class="badge badge-info ml-2">Limited</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($feature->limited)
                                            <input 
                                                type="text" 
                                                name="features[{{ $feature->id }}][value]" 
                                                class="form-control form-control-sm" 
                                                value="{{ old('features.' . $feature->id . '.value', $value) }}"
                                                placeholder="{{ trans('laravel_subscription_managment::global.enter_limit') }}"
                                            >
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <input 
                                            type="checkbox" 
                                            name="features[{{ $feature->id }}][active]" 
                                            value="1"
                                            {{ old('features.' . $feature->id . '.active', $active) ? 'checked' : '' }}
                                        >
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group mt-3">
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-save"></i>
                    {{ trans('laravel_subscription_managment::global.save') }} {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.title') }}
                </button>
                <a href="{{ route('ajax.subscription-products.index') }}" class="btn btn-default">
                    {{ trans('laravel_subscription_managment::global.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .table-secondary td {
        background-color: #e9ecef !important;
        font-weight: 600;
        font-size: 14px;
    }
    
    .form-control-sm {
        height: calc(1.5em + 0.5rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>
