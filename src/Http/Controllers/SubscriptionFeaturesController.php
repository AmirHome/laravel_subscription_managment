<?php

namespace Amirhome\LaravelSubscriptionManagment\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Amirhome\LaravelSubscriptionManagment\Models\SubscriptionGroup;
use Amirhome\LaravelSubscriptionManagment\Models\Feature;

use function PHPUnit\Framework\isNull;

class SubscriptionFeaturesController extends Controller
{
    public function index(Request $request)
    {
        // abort_if(Gate::denies('subscription_feature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = Feature::with(['group'])->select(sprintf('%s.*', (new Feature)->getTable()));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'subscription_feature_show';
                $editGate      = 'subscription_feature_edit';
                $deleteGate    = 'subscription_feature_delete';
                $crudRoutePart = 'subscription_features';

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
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->addColumn('group_name', function ($row) {
                return $row->group ? $row->group->name : '';
            });

            $table->editColumn('active', function ($row) {
                return !is_null($row->active) ? Feature::ACTIVE_SELECT[$row->active] : '';
            });
            $table->editColumn('limited', function ($row) {
                return !is_null($row->limited) ? Feature::LIMITED_SELECT[$row->limited] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'group']);

            return $table->make(true);
        }

        return view('laravel_subscription_managment::admin.features.index');
    }

    public function create()
    {
        // abort_if(Gate::denies('subscription_feature_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $activeSelect = Feature::ACTIVE_SELECT;
        $limitedSelect = Feature::LIMITED_SELECT;
        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('laravel_subscription_managment::global.pleaseSelect'), '');

        return view('laravel_subscription_managment::admin.features.create', compact('groups', 'activeSelect', 'limitedSelect'));
    }

    public function store(Request $request)
    {
        $subscriptionFeature = Feature::create($request->all());

        
    return redirect()->route('ajax.subscription_features.index');
    }

    public function edit(Feature $subscriptionFeature)
    {
        // abort_if(Gate::denies('subscription_feature_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activeSelect = Feature::ACTIVE_SELECT;
        $limitedSelect = Feature::LIMITED_SELECT;
        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('laravel_subscription_managment::global.pleaseSelect'), '');

        $subscriptionFeature->load('group');

        return view('laravel_subscription_managment::admin.features.edit', compact('groups', 'subscriptionFeature', 'activeSelect', 'limitedSelect'));
    }

    public function update(Request $request, Feature $subscriptionFeature)
    {
        $subscriptionFeature->update($request->all());

    return redirect()->route('ajax.subscription_features.index');

    }

    public function show(Feature $subscriptionFeature)
    {
        // abort_if(Gate::denies('subscription_feature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionFeature->load('group');

        return view('laravel_subscription_managment::admin.features.show', compact('subscriptionFeature'));
    }

    public function destroy(Feature $subscriptionFeature)
    {
        // abort_if(Gate::denies('subscription_feature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionFeature->delete();

        return back();
    }

    public function massDestroy(MassDestroyFeatureRequest $request)
    {
        $subscriptionFeatures = Feature::find(request('ids'));

        foreach ($subscriptionFeatures as $subscriptionFeature) {
            $subscriptionFeature->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
