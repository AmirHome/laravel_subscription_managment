<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubscriptionFeatureRequest;
use App\Http\Requests\StoreSubscriptionFeatureRequest;
use App\Http\Requests\UpdateSubscriptionFeatureRequest;
use App\Models\SubscriptionFeature;
use App\Models\SubscriptionGroup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionFeaturesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('subscription_feature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SubscriptionFeature::with(['group'])->select(sprintf('%s.*', (new SubscriptionFeature)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'subscription_feature_show';
                $editGate      = 'subscription_feature_edit';
                $deleteGate    = 'subscription_feature_delete';
                $crudRoutePart = 'subscription-features';

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

            $table->editColumn('active', function ($row) {
                return $row->active ? SubscriptionFeature::ACTIVE_SELECT[$row->active] : '';
            });
            $table->editColumn('limited', function ($row) {
                return $row->limited ? SubscriptionFeature::LIMITED_SELECT[$row->limited] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'group']);

            return $table->make(true);
        }

        return view('admin.subscriptionFeatures.index');
    }

    public function create()
    {
        abort_if(Gate::denies('subscription_feature_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subscriptionFeatures.create', compact('groups'));
    }

    public function store(StoreSubscriptionFeatureRequest $request)
    {
        $subscriptionFeature = SubscriptionFeature::create($request->all());

        return redirect()->route('admin.subscription-features.index');
    }

    public function edit(SubscriptionFeature $subscriptionFeature)
    {
        abort_if(Gate::denies('subscription_feature_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subscriptionFeature->load('group');

        return view('admin.subscriptionFeatures.edit', compact('groups', 'subscriptionFeature'));
    }

    public function update(UpdateSubscriptionFeatureRequest $request, SubscriptionFeature $subscriptionFeature)
    {
        $subscriptionFeature->update($request->all());

        return redirect()->route('admin.subscription-features.index');
    }

    public function show(SubscriptionFeature $subscriptionFeature)
    {
        abort_if(Gate::denies('subscription_feature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionFeature->load('group');

        return view('admin.subscriptionFeatures.show', compact('subscriptionFeature'));
    }

    public function destroy(SubscriptionFeature $subscriptionFeature)
    {
        abort_if(Gate::denies('subscription_feature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionFeature->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionFeatureRequest $request)
    {
        $subscriptionFeatures = SubscriptionFeature::find(request('ids'));

        foreach ($subscriptionFeatures as $subscriptionFeature) {
            $subscriptionFeature->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
