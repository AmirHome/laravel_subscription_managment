<?php

namespace Amirhome\LaravelSubscriptionManagment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGroupRequest extends FormRequest
{
    // public function authorize()
    // {
    //     // return Gate::allows('group_create');
    // }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
