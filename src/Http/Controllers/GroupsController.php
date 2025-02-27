<?php

namespace Amirhome\LaravelSubscriptionManagment\Http\Controllers;

// use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreGroupRequest;
// use App\Http\Requests\UpdateGroupRequest;
// use App\Http\Resources\GroupResource;
// use App\Models\Group;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Amirhome\LaravelSubscriptionManagment\Models\Group;
use Amirhome\LaravelSubscriptionManagment\Http\Resources\GroupResource;
use Amirhome\LaravelSubscriptionManagment\Http\Requests\StoreGroupRequest;  
use Amirhome\LaravelSubscriptionManagment\Http\Requests\UpdateGroupRequest;
use Yajra\DataTables\Facades\DataTables;



class GroupsController extends Controller
{
    public function index(Request $request)
    {
        // abort_if(Gate::denies('group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            $query = Group::query()->select(sprintf('%s.*', (new Group)->getTable()));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'group_show';
                $editGate      = 'group_edit';
                $deleteGate    = 'group_delete';
                $crudRoutePart = 'groups';

                return view('laravel_subscription_managment::partials.datatablesActions', compact(
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
            $table->editColumn('type', function ($row) {
                return $row->type ;
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);

        }
        return view('laravel_subscription_managment::admin.groups.index');

        // return new GroupResource(Group::all());
    }

    public function store(Request $request)
    {

        $group = Group::create($request->all());

        return (new GroupResource($group))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Group $group)
    {
        // abort_if(Gate::denies('group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('laravel_subscription_managment::admin.groups.show', compact('group'));

        // return new GroupResource($group);
    }

    public function update(UpdateGroupRequest $request, Group $group)
    {
        $group->update($request->all());

        return (new GroupResource($group))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Group $group)
    {
        abort_if(Gate::denies('group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $group->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
