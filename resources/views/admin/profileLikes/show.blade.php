@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.profileLike.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.profile-likes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.profileLike.fields.id') }}
                        </th>
                        <td>
                            {{ $profileLike->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.profileLike.fields.profile_by') }}
                        </th>
                        <td>
                            {{ $profileLike->profile_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.profileLike.fields.like_by') }}
                        </th>
                        <td>
                            @foreach($profileLike->like_bies as $key => $like_by)
                                <span class="label label-info">{{ $like_by->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.profile-likes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection