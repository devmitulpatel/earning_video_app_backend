<?php

namespace App\Http\Requests;

use App\Models\ProfileLike;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProfileLikeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('profile_like_edit');
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
