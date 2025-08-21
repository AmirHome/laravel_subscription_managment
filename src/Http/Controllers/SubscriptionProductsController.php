<?php

namespace Amirhome\LaravelSubscriptionManagment\Http\Controllers;

use App\Http\Controllers\Controller;
// use Amirhome\LaravelSubscriptionManagment\Http\Requests\MassDestroySubscriptionProductRequest;
// use Amirhome\LaravelSubscriptionManagment\Http\Requests\StoreSubscriptionProductRequest;
// use Amirhome\LaravelSubscriptionManagment\Http\Requests\UpdateSubscriptionProductRequest;
use Amirhome\LaravelSubscriptionManagment\Models\SubscriptionGroup;
use Amirhome\LaravelSubscriptionManagment\Models\SubscriptionProduct;

use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionProductsController extends Controller
{
    public function index(Request $request)
    {
        // abort_if(Gate::denies('subscription_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SubscriptionProduct::with(['group'])->select(sprintf('%s.*', (new SubscriptionProduct)->getTable()));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'subscription_product_show';
                $editGate      = 'subscription_product_edit';
                $deleteGate    = 'subscription_product_delete';
                $crudRoutePart = 'subscription-products';

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
                return !is_null($row->active) ? SubscriptionProduct::ACTIVE_SELECT[$row->active] : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ;
                // return !is_null($row->type) ?  SubscriptionProduct::TYPE_SELECT[1] : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('price_yearly', function ($row) {
                return $row->price_yearly ? $row->price_yearly : '';
            });
            $table->editColumn('concurrency', function ($row) {
                return !is_null($row->concurrency) ? SubscriptionProduct::CONCURRENCY_RADIO[$row->concurrency] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'group']);

            return $table->make(true);
        }

        return view('laravel_subscription_managment::admin.products.index');
    }

    public function create()
    {
        // abort_if(Gate::denies('subscription_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('laravel_subscription_managment::global.pleaseSelect'), '');
        $productTypes = SubscriptionProduct::TYPE_SELECT;
        $productActiveStatus = SubscriptionProduct::ACTIVE_SELECT;

        return view('laravel_subscription_managment::admin.products.create', compact('groups', 'productTypes', 'productActiveStatus'));
    }

    public function store(Request $request)
    {
        $subscriptionProduct = SubscriptionProduct::create($request->all());

    return redirect()->route('ajax.subscription-products.index');
    }

    public function edit(SubscriptionProduct $subscriptionProduct)
    {
        // abort_if(Gate::denies('subscription_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('laravel_subscription_managment::global.pleaseSelect'), '');

        $subscriptionProduct->load('group');
        $productActiveStatus = SubscriptionProduct::ACTIVE_SELECT;
        $productTypes = SubscriptionProduct::TYPE_SELECT;

        return view('laravel_subscription_managment::admin.products.edit', compact('groups', 'productTypes', 'productActiveStatus', 'subscriptionProduct'));
    }

    public function update(Request $request, SubscriptionProduct $subscriptionProduct)
    {
        $subscriptionProduct->update($request->all());

    return redirect()->route('ajax.subscription-products.index');
    }

    public function show(SubscriptionProduct $subscriptionProduct)
    {
        // abort_if(Gate::denies('subscription_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionProduct->load('group');

        return view('laravel_subscription_managment::admin.products.show', compact('subscriptionProduct'));
    }

    public function destroy(SubscriptionProduct $subscriptionProduct)
    {
        // abort_if(Gate::denies('subscription_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionProduct->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionProductRequest $request)
    {
        $subscriptionProducts = SubscriptionProduct::find(request('ids'));

        foreach ($subscriptionProducts as $subscriptionProduct) {
            $subscriptionProduct->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
