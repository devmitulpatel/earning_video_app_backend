@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.profileLike.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.profile-likes.update", [$profileLike->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="profile_by_id">{{ trans('cruds.profileLike.fields.profile_by') }}</label>
                <select class="form-control select2 {{ $errors->has('profile_by') ? 'is-invalid' : '' }}" name="profile_by_id" id="profile_by_id">
                    @foreach($profile_bies as $id => $profile_by)
                        <option value="{{ $id }}" {{ (old('profile_by_id') ? old('profile_by_id') : $profileLike->profile_by->id ?? '') == $id ? 'selected' : '' }}>{{ $profile_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('profile_by'))
                    <span class="text-danger">{{ $errors->first('profile_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.profileLike.fields.profile_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="like_bies">{{ trans('cruds.profileLike.fields.like_by') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('like_bies') ? 'is-invalid' : '' }}" name="like_bies[]" id="like_bies" multiple>
                    @foreach($like_bies as $id => $like_by)
                        <option value="{{ $id }}" {{ (in_array($id, old('like_bies', [])) || $profileLike->like_bies->contains($id)) ? 'selected' : '' }}>{{ $like_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('like_bies'))
                    <span class="text-danger">{{ $errors->first('like_bies') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.profileLike.fields.like_by_helper') }}</span>
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