<?php

namespace App\Http\Requests;

use App\Models\VideoLike;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVideoLikeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('video_like_create');
    }

    public function rules()
    {
        return [
            'like_bies.*' => [
                'integer',
            ],
            'like_bies'   => [
                'array',
            ],
        ];
    }
}
