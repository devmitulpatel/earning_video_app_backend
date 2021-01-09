@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.withdraw.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.withdraws.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.withdraw.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdraw.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coin_amount">{{ trans('cruds.withdraw.fields.coin_amount') }}</label>
                <input class="form-control {{ $errors->has('coin_amount') ? 'is-invalid' : '' }}" type="number" name="coin_amount" id="coin_amount" value="{{ old('coin_amount', '') }}" step="1">
                @if($errors->has('coin_amount'))
                    <span class="text-danger">{{ $errors->first('coin_amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdraw.fields.coin_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rate">{{ trans('cruds.withdraw.fields.rate') }}</label>
                <input class="form-control {{ $errors->has('rate') ? 'is-invalid' : '' }}" type="number" name="rate" id="rate" value="{{ old('rate', '0') }}" step="0.01">
                @if($errors->has('rate'))
                    <span class="text-danger">{{ $errors->first('rate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdraw.fields.rate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="inr_amount">{{ trans('cruds.withdraw.fields.inr_amount') }}</label>
                <input class="form-control {{ $errors->has('inr_amount') ? 'is-invalid' : '' }}" type="number" name="inr_amount" id="inr_amount" value="{{ old('inr_amount', '') }}" step="0.01">
                @if($errors->has('inr_amount'))
                    <span class="text-danger">{{ $errors->first('inr_amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdraw.fields.inr_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="approved_by_id">{{ trans('cruds.withdraw.fields.approved_by') }}</label>
                <select class="form-control select2 {{ $errors->has('approved_by') ? 'is-invalid' : '' }}" name="approved_by_id" id="approved_by_id">
                    @foreach($approved_bies as $id => $approved_by)
                        <option value="{{ $id }}" {{ old('approved_by_id') == $id ? 'selected' : '' }}>{{ $approved_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('approved_by'))
                    <span class="text-danger">{{ $errors->first('approved_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdraw.fields.approved_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.withdraw.fields.status') }}</label>
                @foreach(App\Models\Withdraw::STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', '0') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdraw.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="transaction">{{ trans('cruds.withdraw.fields.transaction') }}</label>
                <input class="form-control {{ $errors->has('transaction') ? 'is-invalid' : '' }}" type="text" name="transaction" id="transaction" value="{{ old('transaction', '') }}">
                @if($errors->has('transaction'))
                    <span class="text-danger">{{ $errors->first('transaction') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdraw.fields.transaction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="transaction_data">{{ trans('cruds.withdraw.fields.transaction_data') }}</label>
                <input class="form-control {{ $errors->has('transaction_data') ? 'is-invalid' : '' }}" type="text" name="transaction_data" id="transaction_data" value="{{ old('transaction_data', '') }}">
                @if($errors->has('transaction_data'))
                    <span class="text-danger">{{ $errors->first('transaction_data') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdraw.fields.transaction_data_helper') }}</span>
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