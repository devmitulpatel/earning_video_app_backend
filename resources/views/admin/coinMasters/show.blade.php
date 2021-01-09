@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.coinMaster.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coin-masters.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.coinMaster.fields.id') }}
                        </th>
                        <td>
                            {{ $coinMaster->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinMaster.fields.user') }}
                        </th>
                        <td>
                            {{ $coinMaster->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinMaster.fields.task') }}
                        </th>
                        <td>
                            {{ $coinMaster->task->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinMaster.fields.coin_amount') }}
                        </th>
                        <td>
                            {{ $coinMaster->coin_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coinMaster.fields.type_transaction') }}
                        </th>
                        <td>
                            {{ App\Models\CoinMaster::TYPE_TRANSACTION_RADIO[$coinMaster->type_transaction] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coin-masters.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection