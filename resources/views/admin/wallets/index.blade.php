@extends('layouts.admin')
@section('content')
@can('wallet_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.wallets.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.wallet.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.wallet.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Wallet">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.wallet.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.wallet.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.wallet.fields.balance') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wallets as $key => $wallet)
                        <tr data-entry-id="{{ $wallet->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $wallet->id ?? '' }}
                            </td>
                            <td>
                                {{ $wallet->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $wallet->user->email ?? '' }}
                            </td>
                            <td>
                                {{ $wallet->balance ?? '' }}
                            </td>
                            <td>
                                @can('wallet_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.wallets.show', $wallet->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('wallet_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.wallets.edit', $wallet->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('wallet_delete')
                                    <form action="{{ route('admin.wallets.destroy', $wallet->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('wallet_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.wallets.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Wallet:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection