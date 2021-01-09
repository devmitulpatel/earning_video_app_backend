@extends('layouts.admin')
@section('content')
@can('withdraw_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.withdraws.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.withdraw.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.withdraw.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Withdraw">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.coin_amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.rate') }}
                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.inr_amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.approved_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.transaction') }}
                    </th>
                    <th>
                        {{ trans('cruds.withdraw.fields.transaction_data') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('withdraw_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.withdraws.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.withdraws.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user.name' },
{ data: 'coin_amount', name: 'coin_amount' },
{ data: 'rate', name: 'rate' },
{ data: 'inr_amount', name: 'inr_amount' },
{ data: 'approved_by_name', name: 'approved_by.name' },
{ data: 'status', name: 'status' },
{ data: 'transaction', name: 'transaction' },
{ data: 'transaction_data', name: 'transaction_data' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-Withdraw').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection