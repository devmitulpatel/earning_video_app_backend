@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.coinTask.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.coin-tasks.update", [$coinTask->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.coinTask.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $coinTask->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinTask.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.coinTask.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $coinTask->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinTask.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coin_earn">{{ trans('cruds.coinTask.fields.coin_earn') }}</label>
                <input class="form-control {{ $errors->has('coin_earn') ? 'is-invalid' : '' }}" type="number" name="coin_earn" id="coin_earn" value="{{ old('coin_earn', $coinTask->coin_earn) }}" step="1">
                @if($errors->has('coin_earn'))
                    <span class="text-danger">{{ $errors->first('coin_earn') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinTask.fields.coin_earn_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.coinTask.fields.single_task') }}</label>
                @foreach(App\Models\CoinTask::SINGLE_TASK_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('single_task') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="single_task_{{ $key }}" name="single_task" value="{{ $key }}" {{ old('single_task', $coinTask->single_task) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="single_task_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('single_task'))
                    <span class="text-danger">{{ $errors->first('single_task') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinTask.fields.single_task_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="task_finished_bies">{{ trans('cruds.coinTask.fields.task_finished_by') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('task_finished_bies') ? 'is-invalid' : '' }}" name="task_finished_bies[]" id="task_finished_bies" multiple>
                    @foreach($task_finished_bies as $id => $task_finished_by)
                        <option value="{{ $id }}" {{ (in_array($id, old('task_finished_bies', [])) || $coinTask->task_finished_bies->contains($id)) ? 'selected' : '' }}>{{ $task_finished_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('task_finished_bies'))
                    <span class="text-danger">{{ $errors->first('task_finished_bies') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinTask.fields.task_finished_by_helper') }}</span>
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