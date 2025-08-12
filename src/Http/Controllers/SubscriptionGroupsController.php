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



class SubscriptionGroupsController extends Controller
{
    public function index(Request $request)
    {
        // abort_if(Gate::denies('group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            $query = Group::query()->select(sprintf('%s.*', (new Group)->getTable()));
            $table = Datatables::of($query);

            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'group_show';
                $editGate      = 'group_edit';
                $deleteGate    = 'group_delete';
                $crudRoutePart = 'subscription_groups';

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

            $table->rawColumns(['actions']);

            return $table->make(true);

        }
        return view('laravel_subscription_managment::admin.groups.index');

        // return new GroupResource(Group::all());
    }

    public function create()
    {
        // abort_if(Gate::denies('group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $groupTypes = Group::TYPE_SELECT;

        return view('laravel_subscription_managment::admin.groups.create', compact('groupTypes'));
    }

    public function store(Request $request)
    {
        $subscriptionGroup = Group::create($request->all());

    return redirect()->route('ajax.subscription_groups.index');


        // return (new GroupResource($subscriptionGroup))
        //     ->response()
        //     ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Group $subscriptionGroup)
    {
        // abort_if(Gate::denies('group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('laravel_subscription_managment::admin.groups.show', compact('subscriptionGroup'));

        // return new GroupResource($subscriptionGroup);
    }

    public function edit(Group $subscriptionGroup)
    {
        // abort_if(Gate::denies('group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groupTypes = Group::TYPE_SELECT;
        return view('laravel_subscription_managment::admin.groups.edit', compact('subscriptionGroup','groupTypes'));
    }

    public function update(UpdateGroupRequest $request, Group $subscriptionGroup)
    {
        $subscriptionGroup->update($request->all());

    return redirect()->route('ajax.subscription_groups.index');

        // return (new GroupResource($subscriptionGroup))
        //     ->response()
        //     ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Group $subscriptionGroup)
    {
        // abort_if(Gate::denies('group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionGroup->delete();

        return back();

        // return response(null, Response::HTTP_NO_CONTENT);
    }
}
