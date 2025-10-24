@extends('laravel_subscription_managment::layouts.admin')
@section('content')
{{-- @can('subscription_product_create') --}}
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('ajax.subscription-products.create') }}">
                {{ trans('laravel_subscription_managment::global.add') }} {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.title_singular') }}
            </a>
        </div>
    </div>
{{-- @endcan --}}
<div class="card">
    <div class="card-header">
    {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.title_singular') }} {{ trans('laravel_subscription_managment::global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SubscriptionProduct">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.id') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.name') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.code') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.group') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.active') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.type') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.price_yearly') }}
                    </th>
                    <th>
                        {{ trans('laravel_subscription_managment::cruds.subscriptionProduct.fields.concurrency') }}
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
@can('subscription_product_delete')
    let deleteButtonTrans = '{{ trans('laravel_subscription_managment::global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('ajax.subscription-products.massDestroy') }}",
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
    ajax: "{{ route('ajax.subscription-products.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'code', name: 'code' },
{ data: 'group_name', name: 'group.name' },
{ data: 'active', name: 'active' },
{ data: 'type', name: 'type' },
{ data: 'price', name: 'price' },
{ data: 'price_yearly', name: 'price_yearly' },
{ data: 'concurrency', name: 'concurrency' },
                { data: 'actions', name: '{{ trans('laravel_subscription_managment::global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-SubscriptionProduct').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection