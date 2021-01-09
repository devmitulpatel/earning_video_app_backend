<?php

namespace App\Http\Requests;

use App\Models\VideoComment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVideoCommentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('video_comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:video_comments,id',
        ];
    }
}
