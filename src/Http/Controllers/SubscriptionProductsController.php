<?php

namespace Amirhome\LaravelSubscriptionManagment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubscriptionProductRequest;
use App\Http\Requests\StoreSubscriptionProductRequest;
use App\Http\Requests\UpdateSubscriptionProductRequest;
use App\Models\SubscriptionGroup;
use App\Models\SubscriptionProduct;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionProductsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('subscription_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SubscriptionSubscriptionProduct::with(['group'])->select(sprintf('%s.*', (new SubscriptionProduct)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'subscription_product_show';
                $editGate      = 'subscription_product_edit';
                $deleteGate    = 'subscription_product_delete';
                $crudRoutePart = 'subscription-products';

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
                return $row->active ? SubscriptionSubscriptionProduct::ACTIVE_SELECT[$row->active] : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? SubscriptionSubscriptionProduct::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('price_yearly', function ($row) {
                return $row->price_yearly ? $row->price_yearly : '';
            });
            $table->editColumn('concurrency', function ($row) {
                return $row->concurrency ? SubscriptionSubscriptionProduct::CONCURRENCY_RADIO[$row->concurrency] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'group']);

            return $table->make(true);
        }

        return view('admin.subscriptionProducts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('subscription_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subscriptionProducts.create', compact('groups'));
    }

    public function store(StoreSubscriptionProductRequest $request)
    {
        $subscriptionProduct = SubscriptionSubscriptionProduct::create($request->all());

        return redirect()->route('admin.subscription-products.index');
    }

    public function edit(SubscriptionProduct $subscriptionProduct)
    {
        abort_if(Gate::denies('subscription_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $groups = SubscriptionGroup::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subscriptionProduct->load('group');

        return view('admin.subscriptionProducts.edit', compact('groups', 'subscriptionProduct'));
    }

    public function update(UpdateSubscriptionProductRequest $request, SubscriptionProduct $subscriptionProduct)
    {
        $subscriptionProduct->update($request->all());

        return redirect()->route('admin.subscription-products.index');
    }

    public function show(SubscriptionProduct $subscriptionProduct)
    {
        abort_if(Gate::denies('subscription_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionProduct->load('group');

        return view('admin.subscriptionProducts.show', compact('subscriptionProduct'));
    }

    public function destroy(SubscriptionProduct $subscriptionProduct)
    {
        abort_if(Gate::denies('subscription_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionProduct->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionProductRequest $request)
    {
        $subscriptionProducts = SubscriptionSubscriptionProduct::find(request('ids'));

        foreach ($subscriptionProducts as $subscriptionProduct) {
            $subscriptionProduct->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
