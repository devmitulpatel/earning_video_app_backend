@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.videoLike.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.video-likes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.videoLike.fields.id') }}
                        </th>
                        <td>
                            {{ $videoLike->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoLike.fields.video') }}
                        </th>
                        <td>
                            {{ $videoLike->video->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoLike.fields.like_by') }}
                        </th>
                        <td>
                            @foreach($videoLike->like_bies as $key => $like_by)
                                <span class="label label-info">{{ $like_by->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.video-likes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection