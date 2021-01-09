<?php

namespace App\Http\Requests;

use App\Models\VideoComment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVideoCommentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('video_comment_edit');
    }

    public function rules()
    {
        return [];
    }
}
