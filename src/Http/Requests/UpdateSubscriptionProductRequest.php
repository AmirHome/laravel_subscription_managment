<?php

namespace App\Http\Requests;

use App\Models\SubscriptionProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubscriptionProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_product_edit');
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
                'unique:subscription_products,code,' . request()->route('subscription_product')->id,
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'price' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'price_yearly' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
