<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyXfeatueRequest;
use App\Http\Requests\StoreXfeatueRequest;
use App\Http\Requests\UpdateXfeatueRequest;
use App\Models\Group;
use App\Models\Xfeatue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class XfeatuesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('xfeatue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Xfeatue::with(['group'])->select(sprintf('%s.*', (new Xfeatue)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'xfeatue_show';
                $editGate      = 'xfeatue_edit';
                $deleteGate    = 'xfeatue_delete';
                $crudRoutePart = 'xfeatues';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->addColumn('group_name', function ($row) {
                return $row->group ? $row->group->name : '';
            });

            $table->editColumn('group.type', function ($row) {
                return $row->group ? (is_string($row->group) ? $row->group : $row->group->type) : '';
            });
            $table->editColumn('active', function ($row) {
                return $row->active ? Xfeatue::ACTIVE_SELECT[$row->active] : '';
            });
            $table->editColumn('limited', function ($row) {
                return $row->limited ? Xfeatue::LIMITED_SELECT[$row->limited] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'group']);

            return $table->make(true);
        }

        return view('admin.xfeatues.index');
    }

    public function create()
    {
        abort_if(Gate::denies('xfeatue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = Group::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.xfeatues.create', compact('groups'));
    }

    public function store(StoreXfeatueRequest $request)
    {
        $xfeatue = Xfeatue::create($request->all());

        return redirect()->route('admin.xfeatues.index');
    }

    public function edit(Xfeatue $xfeatue)
    {
        abort_if(Gate::denies('xfeatue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = Group::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $xfeatue->load('group');

        return view('admin.xfeatues.edit', compact('groups', 'xfeatue'));
    }

    public function update(UpdateXfeatueRequest $request, Xfeatue $xfeatue)
    {
        $xfeatue->update($request->all());

        return redirect()->route('admin.xfeatues.index');
    }

    public function show(Xfeatue $xfeatue)
    {
        abort_if(Gate::denies('xfeatue_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $xfeatue->load('group');

        return view('admin.xfeatues.show', compact('xfeatue'));
    }

    public function destroy(Xfeatue $xfeatue)
    {
        abort_if(Gate::denies('xfeatue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $xfeatue->delete();

        return back();
    }

    public function massDestroy(MassDestroyXfeatueRequest $request)
    {
        $xfeatues = Xfeatue::find(request('ids'));

        foreach ($xfeatues as $xfeatue) {
            $xfeatue->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
