<?php

namespace App\Http\Requests;

use App\Models\SubscriptionFeature;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSubscriptionFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_feature_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'code' => [
                'string',
                'required',
                'unique:subscription_features',
            ],
            'description' => [
                'string',
                'nullable',
            ],
        ];
    }
}
