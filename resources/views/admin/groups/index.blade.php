@extends('laravel_subscription_managment::layouts.admin')
@section('content')
@can('group_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('ajax.groups.create') }}">
                {{ trans('laravel_subscription_managment::global.add') }} {{ trans('laravel_subscription_managment::cruds.group.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
         {{ trans('laravel_subscription_managment::cruds.group.title_singular') }} {{ trans('laravel_subscription_managment::global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Group">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.group.fields.id') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.group.fields.name') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.group.fields.type') }}
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
@can('group_delete')
  let deleteButtonTrans = '{{ trans('laravel_subscription_managment::global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('ajax.groups.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('laravel_subscription_managment::global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('laravel_subscription_managment::global.areYouSure') }}')) {
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
    ajax: "{{ route('ajax.groups.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'type', name: 'type' },
{ data: 'actions', name: '{{ trans('laravel_subscription_managment::global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Group').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection