@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.follower.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.followers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="host_id">{{ trans('cruds.follower.fields.host') }}</label>
                <select class="form-control select2 {{ $errors->has('host') ? 'is-invalid' : '' }}" name="host_id" id="host_id">
                    @foreach($hosts as $id => $host)
                        <option value="{{ $id }}" {{ old('host_id') == $id ? 'selected' : '' }}>{{ $host }}</option>
                    @endforeach
                </select>
                @if($errors->has('host'))
                    <span class="text-danger">{{ $errors->first('host') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.follower.fields.host_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="followers">{{ trans('cruds.follower.fields.followers') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('followers') ? 'is-invalid' : '' }}" name="followers[]" id="followers" multiple>
                    @foreach($followers as $id => $followers)
                        <option value="{{ $id }}" {{ in_array($id, old('followers', [])) ? 'selected' : '' }}>{{ $followers }}</option>
                    @endforeach
                </select>
                @if($errors->has('followers'))
                    <span class="text-danger">{{ $errors->first('followers') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.follower.fields.followers_helper') }}</span>
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