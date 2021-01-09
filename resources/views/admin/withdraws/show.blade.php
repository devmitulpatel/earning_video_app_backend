@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.withdraw.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.withdraws.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.id') }}
                        </th>
                        <td>
                            {{ $withdraw->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.user') }}
                        </th>
                        <td>
                            {{ $withdraw->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.coin_amount') }}
                        </th>
                        <td>
                            {{ $withdraw->coin_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.rate') }}
                        </th>
                        <td>
                            {{ $withdraw->rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.inr_amount') }}
                        </th>
                        <td>
                            {{ $withdraw->inr_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.approved_by') }}
                        </th>
                        <td>
                            {{ $withdraw->approved_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Withdraw::STATUS_RADIO[$withdraw->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.transaction') }}
                        </th>
                        <td>
                            {{ $withdraw->transaction }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdraw.fields.transaction_data') }}
                        </th>
                        <td>
                            {{ $withdraw->transaction_data }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.withdraws.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection