<?php

namespace App\Http\Requests;

use App\Models\SubscriptionFeature;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubscriptionFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_feature_edit');
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
                'unique:subscription-features,code,' . request()->route('subscription_feature')->id,
            ],
            'description' => [
                'string',
                'nullable',
            ],
        ];
    }
}
