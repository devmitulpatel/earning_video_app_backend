@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.videoLike.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.video-likes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="video_id">{{ trans('cruds.videoLike.fields.video') }}</label>
                <select class="form-control select2 {{ $errors->has('video') ? 'is-invalid' : '' }}" name="video_id" id="video_id">
                    @foreach($videos as $id => $video)
                        <option value="{{ $id }}" {{ old('video_id') == $id ? 'selected' : '' }}>{{ $video }}</option>
                    @endforeach
                </select>
                @if($errors->has('video'))
                    <span class="text-danger">{{ $errors->first('video') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.videoLike.fields.video_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="like_bies">{{ trans('cruds.videoLike.fields.like_by') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('like_bies') ? 'is-invalid' : '' }}" name="like_bies[]" id="like_bies" multiple>
                    @foreach($like_bies as $id => $like_by)
                        <option value="{{ $id }}" {{ in_array($id, old('like_bies', [])) ? 'selected' : '' }}>{{ $like_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('like_bies'))
                    <span class="text-danger">{{ $errors->first('like_bies') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.videoLike.fields.like_by_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection