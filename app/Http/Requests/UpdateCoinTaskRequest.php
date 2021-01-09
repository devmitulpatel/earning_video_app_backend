<?php

namespace App\Http\Requests;

use App\Models\CoinTask;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCoinTaskRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coin_task_edit');
    }

    public function rules()
    {
        return [
            'name'                 => [
                'string',
                'nullable',
            ],
            'coin_earn'            => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'task_finished_bies.*' => [
                'integer',
            ],
            'task_finished_bies'   => [
                'array',
            ],
        ];
    }
}
