<?php

namespace App\Http\Requests;

use App\Models\CoinMaster;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCoinMasterRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('coin_master_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:coin_masters,id',
        ];
    }
}
