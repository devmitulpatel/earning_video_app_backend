<?php

namespace App\Http\Requests;

use App\Models\VideoComment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVideoCommentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('video_comment_create');
    }

    public function rules()
    {
        return [];
    }
}
