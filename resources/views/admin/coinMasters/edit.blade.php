@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.coinMaster.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.coin-masters.update", [$coinMaster->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.coinMaster.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $coinMaster->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinMaster.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="task_id">{{ trans('cruds.coinMaster.fields.task') }}</label>
                <select class="form-control select2 {{ $errors->has('task') ? 'is-invalid' : '' }}" name="task_id" id="task_id">
                    @foreach($tasks as $id => $task)
                        <option value="{{ $id }}" {{ (old('task_id') ? old('task_id') : $coinMaster->task->id ?? '') == $id ? 'selected' : '' }}>{{ $task }}</option>
                    @endforeach
                </select>
                @if($errors->has('task'))
                    <span class="text-danger">{{ $errors->first('task') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinMaster.fields.task_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coin_amount">{{ trans('cruds.coinMaster.fields.coin_amount') }}</label>
                <input class="form-control {{ $errors->has('coin_amount') ? 'is-invalid' : '' }}" type="number" name="coin_amount" id="coin_amount" value="{{ old('coin_amount', $coinMaster->coin_amount) }}" step="1">
                @if($errors->has('coin_amount'))
                    <span class="text-danger">{{ $errors->first('coin_amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinMaster.fields.coin_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.coinMaster.fields.type_transaction') }}</label>
                @foreach(App\Models\CoinMaster::TYPE_TRANSACTION_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('type_transaction') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="type_transaction_{{ $key }}" name="type_transaction" value="{{ $key }}" {{ old('type_transaction', $coinMaster->type_transaction) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_transaction_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('type_transaction'))
                    <span class="text-danger">{{ $errors->first('type_transaction') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coinMaster.fields.type_transaction_helper') }}</span>
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