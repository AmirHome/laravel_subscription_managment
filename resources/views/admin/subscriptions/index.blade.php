@extends('laravel_subscription_managment::layouts.admin')
@section('content')
{{-- @can('subscription_create') --}}
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('ajax.subscriptions.create') }}">
                {{ trans('laravel_subscription_managment::global.add') }} {{ trans('laravel_subscription_managment::cruds.subscription.title_singular') }}
            </a>
        </div>
    </div>
{{-- @endcan --}}
<div class="card">
    <div class="card-header">
        {{ trans('laravel_subscription_managment::cruds.subscription.title_singular') }} {{ trans('laravel_subscription_managment::global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Subscription">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscription.fields.id') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscription.fields.unlimited') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscription.fields.start_at') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscription.fields.end_at') }}
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
{{-- @can('subscription_delete') --}}
  let deleteButtonTrans = '{{ trans('laravel_subscription_managment::global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('ajax.subscriptions.massDestroy') }}",
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
{{-- @endcan --}}

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('ajax.subscriptions.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'unlimited', name: 'unlimited' },
{ data: 'start_at', name: 'start_at' },
{ data: 'end_at', name: 'end_at' },
{ data: 'actions', name: '{{ trans('laravel_subscription_managment::global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Subscription').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
