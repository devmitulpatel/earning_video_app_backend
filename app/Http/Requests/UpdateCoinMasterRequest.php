<?php

namespace App\Http\Requests;

use App\Models\CoinMaster;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCoinMasterRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coin_master_edit');
    }

    public function rules()
    {
        return [
            'coin_amount' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
