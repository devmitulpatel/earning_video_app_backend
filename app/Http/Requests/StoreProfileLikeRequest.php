<?php

namespace App\Http\Requests;

use App\Models\ProfileLike;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProfileLikeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('profile_like_create');
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
