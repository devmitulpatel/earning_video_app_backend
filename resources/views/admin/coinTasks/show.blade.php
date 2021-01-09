@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.coinTask.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coin-tasks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.coinTask.fields.id') }}
                        </th>
                        <td>
                            {{ $coinTask->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinTask.fields.name') }}
                        </th>
                        <td>
                            {{ $coinTask->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinTask.fields.description') }}
                        </th>
                        <td>
                            {{ $coinTask->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinTask.fields.coin_earn') }}
                        </th>
                        <td>
                            {{ $coinTask->coin_earn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinTask.fields.single_task') }}
                        </th>
                        <td>
                            {{ App\Models\CoinTask::SINGLE_TASK_RADIO[$coinTask->single_task] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinTask.fields.task_finished_by') }}
                        </th>
                        <td>
                            @foreach($coinTask->task_finished_bies as $key => $task_finished_by)
                                <span class="label label-info">{{ $task_finished_by->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coin-tasks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection