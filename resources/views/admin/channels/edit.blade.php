@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.channel.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.channels.update", [$channel->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.channel.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $channel->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.channel.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.channel.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $channel->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.channel.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.channel.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $channel->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.channel.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="followed_bies">{{ trans('cruds.channel.fields.followed_by') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('followed_bies') ? 'is-invalid' : '' }}" name="followed_bies[]" id="followed_bies" multiple>
                    @foreach($followed_bies as $id => $followed_by)
                        <option value="{{ $id }}" {{ (in_array($id, old('followed_bies', [])) || $channel->followed_bies->contains($id)) ? 'selected' : '' }}>{{ $followed_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('followed_bies'))
                    <span class="text-danger">{{ $errors->first('followed_bies') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.channel.fields.followed_by_helper') }}</span>
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