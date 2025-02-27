{{-- @can($viewGate) --}}
    <a class="btn btn-xs btn-primary" href="{{ route('ajax.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('laravel_subscription_managment::global.view') }}
    </a>
{{-- @endcan
@can($editGate) --}}
    <a class="btn btn-xs btn-info" href="{{ route('ajax.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('laravel_subscription_managment::global.edit') }}
    </a>
{{-- @endcan
@can($deleteGate) --}}
    <form action="{{ route('ajax.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('laravel_subscription_managment::global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('laravel_subscription_managment::global.delete') }}">
    </form>
{{-- @endcan --}}