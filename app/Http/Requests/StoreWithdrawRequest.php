<?php

namespace App\Http\Requests;

use App\Models\Withdraw;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWithdrawRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('withdraw_create');
    }

    public function rules()
    {
        return [
            'coin_amount'      => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'transaction'      => [
                'string',
                'nullable',
            ],
            'transaction_data' => [
                'string',
                'nullable',
            ],
        ];
    }
}
