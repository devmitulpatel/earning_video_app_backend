<?php

namespace App\Http\Requests;

use App\Models\VideoList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVideoListRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('video_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:video_lists,id',
        ];
    }
}
