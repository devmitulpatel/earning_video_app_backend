@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.videoComment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.video-comments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="video_id">{{ trans('cruds.videoComment.fields.video') }}</label>
                <select class="form-control select2 {{ $errors->has('video') ? 'is-invalid' : '' }}" name="video_id" id="video_id">
                    @foreach($videos as $id => $video)
                        <option value="{{ $id }}" {{ old('video_id') == $id ? 'selected' : '' }}>{{ $video }}</option>
                    @endforeach
                </select>
                @if($errors->has('video'))
                    <span class="text-danger">{{ $errors->first('video') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.videoComment.fields.video_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.videoComment.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.videoComment.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="replay_to_id">{{ trans('cruds.videoComment.fields.replay_to') }}</label>
                <select class="form-control select2 {{ $errors->has('replay_to') ? 'is-invalid' : '' }}" name="replay_to_id" id="replay_to_id">
                    @foreach($replay_tos as $id => $replay_to)
                        <option value="{{ $id }}" {{ old('replay_to_id') == $id ? 'selected' : '' }}>{{ $replay_to }}</option>
                    @endforeach
                </select>
                @if($errors->has('replay_to'))
                    <span class="text-danger">{{ $errors->first('replay_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.videoComment.fields.replay_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comment">{{ trans('cruds.videoComment.fields.comment') }}</label>
                <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" id="comment">{{ old('comment') }}</textarea>
                @if($errors->has('comment'))
                    <span class="text-danger">{{ $errors->first('comment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.videoComment.fields.comment_helper') }}</span>
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