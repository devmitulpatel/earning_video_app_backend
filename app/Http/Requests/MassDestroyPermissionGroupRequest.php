<?php

namespace App\Http\Requests;

use App\Models\PermissionGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPermissionGroupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('permission_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:permission_groups,id',
        ];
    }
}
