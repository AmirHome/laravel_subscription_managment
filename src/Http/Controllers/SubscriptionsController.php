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

use Amirhome\LaravelSubscriptionManagment\Http\Requests\MassDestroySubscriptionRequest;
use Amirhome\LaravelSubscriptionManagment\Http\Requests\StoreSubscriptionRequest;
use Amirhome\LaravelSubscriptionManagment\Http\Requests\UpdateSubscriptionRequest;
use Amirhome\LaravelSubscriptionManagment\Models\SubscriptionProduct;
use Amirhome\LaravelSubscriptionManagment\Models\Subscription;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionsController extends Controller
{
    public function index(Request $request)
    {
    // abort_if(Gate::denies('subscription_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Subscription::with(['product'])->select(sprintf('%s.*', (new Subscription)->getTable()));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'subscription_show';
                $editGate      = 'subscription_edit';
                $deleteGate    = 'subscription_delete';
                $crudRoutePart = 'subscriptions';

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
            $table->editColumn('unlimited', function ($row) {
                return $row->unlimited ? 'Yes' : 'No';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

    return view('laravel_subscription_managment::admin.subscriptions.index');
    }

    public function create()
    {
    // abort_if(Gate::denies('subscription_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = SubscriptionProduct::pluck('name', 'id')->prepend(trans('laravel_subscription_managment::global.pleaseSelect'), '');

    return view('laravel_subscription_managment::admin.subscriptions.create', compact('products'));
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $subscription = Subscription::create($request->all());

    return redirect()->route('ajax.subscriptions.index');
    }

    public function edit(Subscription $subscription)
    {
    // abort_if(Gate::denies('subscription_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = SubscriptionProduct::pluck('name', 'id')->prepend(trans('laravel_subscription_managment::global.pleaseSelect'), '');

        $subscription->load('product');

    return view('laravel_subscription_managment::admin.subscriptions.edit', compact('products', 'subscription'));
    }

    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $subscription->update($request->all());

    return redirect()->route('ajax.subscriptions.index');
    }

    public function show(Subscription $subscription)
    {
    // abort_if(Gate::denies('subscription_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription->load('product');

    return view('laravel_subscription_managment::admin.subscriptions.show', compact('subscription'));
    }

    public function destroy(Subscription $subscription)
    {
    // abort_if(Gate::denies('subscription_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionRequest $request)
    {
        $subscriptions = Subscription::find(request('ids'));

        foreach ($subscriptions as $subscription) {
            $subscription->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
