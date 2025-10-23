<?php

/**
 * NOTE FOR PUBLISHED CONTROLLERS:
 * When you publish this controller into your application (php artisan vendor:publish --tag=laravel_subscription_managment_controllers)
 * you MUST update the namespace and base Controller import to match your app structure. Example changes you should make
 * in the published file located at app/Http/Controllers/Admin/SubscriptionFeaturesController.php:
 *
 * namespace App\Http\Controllers\Admin;
 *
 * use App\Http\Controllers\Controller;
 *
 * Without these edits the controller will continue to reference the package namespace and may not integrate with your
 * application (policies, requests, resources or models you expect to use from App\ namespace).
 */

namespace Amirhome\LaravelSubscriptionManagment\Http\Controllers;

use Illuminate\Http\Request;
use Amirhome\LaravelSubscriptionManagment\Http\Requests\MassDestroySubscriptionFeatureRequest;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Amirhome\LaravelSubscriptionManagment\Models\SubscriptionGroup;
use Amirhome\LaravelSubscriptionManagment\Models\SubscriptionFeature;

use function PHPUnit\Framework\isNull;

class SubscriptionFeaturesController extends Controller
{
    public function index(Request $request)
    {
        // abort_if(Gate::denies('subscription_feature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = SubscriptionFeature::with(['group'])->select(sprintf('%s.*', (new SubscriptionFeature)->getTable()));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'subscription_feature_show';
                $editGate      = 'subscription_feature_edit';
                $deleteGate    = 'subscription_feature_delete';
                $crudRoutePart = 'subscription-features';

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
                return !is_null($row->active) ? SubscriptionFeature::ACTIVE_SELECT[$row->active] : '';
            });
            $table->editColumn('limited', function ($row) {
                return !is_null($row->limited) ? SubscriptionFeature::LIMITED_SELECT[$row->limited] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'group']);

            return $table->make(true);
        }

        return view('laravel_subscription_managment::admin.features.index');
    }

    public function create()
    {
        // abort_if(Gate::denies('subscription_feature_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $activeSelect = SubscriptionFeature::ACTIVE_SELECT;
    $limitedSelect = SubscriptionFeature::LIMITED_SELECT;
        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('laravel_subscription_managment::global.pleaseSelect'), '');

        return view('laravel_subscription_managment::admin.features.create', compact('groups', 'activeSelect', 'limitedSelect'));
    }

    public function store(Request $request)
    {
    $subscriptionFeature = SubscriptionFeature::create($request->all());

        
    return redirect()->route('ajax.subscription-features.index');
    }

    public function edit(SubscriptionFeature $subscriptionFeature)
    {
        // abort_if(Gate::denies('subscription_feature_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activeSelect = SubscriptionFeature::ACTIVE_SELECT;
        $limitedSelect = SubscriptionFeature::LIMITED_SELECT;
        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('laravel_subscription_managment::global.pleaseSelect'), '');

        $subscriptionFeature->load('group');

        return view('laravel_subscription_managment::admin.features.edit', compact('groups', 'subscriptionFeature', 'activeSelect', 'limitedSelect'));
    }

    public function update(Request $request, SubscriptionFeature $subscriptionFeature)
    {
        $subscriptionFeature->update($request->all());

    return redirect()->route('ajax.subscription-features.index');

    }

    public function show(SubscriptionFeature $subscriptionFeature)
    {
        // abort_if(Gate::denies('subscription_feature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionFeature->load('group');

        return view('laravel_subscription_managment::admin.features.show', compact('subscriptionFeature'));
    }

    public function destroy(SubscriptionFeature $subscriptionFeature)
    {
        // abort_if(Gate::denies('subscription_feature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
