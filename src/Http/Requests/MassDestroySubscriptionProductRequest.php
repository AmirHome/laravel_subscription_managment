<?php

namespace App\Http\Requests;

use App\Models\SubscriptionProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySubscriptionProductRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('subscription_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:subscription_products,id',
        ];
    }
}
