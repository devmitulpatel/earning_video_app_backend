@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.videoList.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.video-lists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.videoList.fields.id') }}
                        </th>
                        <td>
                            {{ $videoList->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoList.fields.name') }}
                        </th>
                        <td>
                            {{ $videoList->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoList.fields.video') }}
                        </th>
                        <td>
                            @if($videoList->video)
                                <a href="{{ $videoList->video->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoList.fields.tags') }}
                        </th>
                        <td>
                            @foreach($videoList->tags as $key => $tags)
                                <span class="label label-info">{{ $tags->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoList.fields.categories') }}
                        </th>
                        <td>
                            {{ $videoList->categories->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoList.fields.event') }}
                        </th>
                        <td>
                            {{ $videoList->event->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoList.fields.channel') }}
                        </th>
                        <td>
                            {{ $videoList->channel->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.videoList.fields.user') }}
                        </th>
                        <td>
                            {{ $videoList->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.video-lists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection