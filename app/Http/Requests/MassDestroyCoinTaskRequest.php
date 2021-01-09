<?php

namespace App\Http\Requests;

use App\Models\CoinTask;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCoinTaskRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('coin_task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:coin_tasks,id',
        ];
    }
}
