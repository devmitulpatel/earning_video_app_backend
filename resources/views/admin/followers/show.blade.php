@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.follower.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.followers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.follower.fields.id') }}
                        </th>
                        <td>
                            {{ $follower->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.follower.fields.host') }}
                        </th>
                        <td>
                            {{ $follower->host->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.follower.fields.followers') }}
                        </th>
                        <td>
                            @foreach($follower->followers as $key => $followers)
                                <span class="label label-info">{{ $followers->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.followers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection