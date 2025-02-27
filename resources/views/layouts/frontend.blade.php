<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.home') }}">
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('frontend.profile.index') }}">{{ __('My profile') }}</a>

                                    @can('user_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.userManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('permission_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.permissions.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.permission.title') }}
                                        </a>
                                    @endcan
                                    @can('role_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.roles.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.role.title') }}
                                        </a>
                                    @endcan
                                    @can('user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.users.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.user.title') }}
                                        </a>
                                    @endcan
                                    @can('team_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.teams.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.team.title') }}
                                        </a>
                                    @endcan
                                    @can('user_profile_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.user-profiles.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.userProfile.title') }}
                                        </a>
                                    @endcan
                                    @can('grant_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.grantManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('organization_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.organization-types.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.organizationType.title') }}
                                        </a>
                                    @endcan
                                    @can('organization_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.organizations.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.organization.title') }}
                                        </a>
                                    @endcan
                                    @can('grant_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.grant-types.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.grantType.title') }}
                                        </a>
                                    @endcan
                                    @can('grant_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.grants.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.grant.title') }}
                                        </a>
                                    @endcan
                                    @can('grant_document_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.grant-documents.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.grantDocument.title') }}
                                        </a>
                                    @endcan
                                    @can('grant_tab_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.grant-tabs.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.grantTab.title') }}
                                        </a>
                                    @endcan
                                    @can('company_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.companyManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('company_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.company-types.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.companyType.title') }}
                                        </a>
                                    @endcan
                                    @can('company_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.companies.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.company.title') }}
                                        </a>
                                    @endcan
                                    @can('feature_company_setting_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.feature-company-settings.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.featureCompanySetting.title') }}
                                        </a>
                                    @endcan
                                    @can('report_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.reports.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.report.title') }}
                                        </a>
                                    @endcan
                                    @can('user_alert_access')
                                        <a class="dropdown-item" href="{{ route('frontend.user-alerts.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.userAlert.title') }}
                                        </a>
                                    @endcan
                                    @can('feature_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.featureManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('feature_group_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.feature-groups.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.featureGroup.title') }}
                                        </a>
                                    @endcan
                                    @can('feature_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.feature-types.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.featureType.title') }}
                                        </a>
                                    @endcan
                                    @can('feature_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.features.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.feature.title') }}
                                        </a>
                                    @endcan
                                    @can('feature_value_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.feature-values.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.featureValue.title') }}
                                        </a>
                                    @endcan
                                    @can('faq_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.faqManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('faq_category_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.faq-categories.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.faqCategory.title') }}
                                        </a>
                                    @endcan
                                    @can('faq_question_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.faq-questions.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.faqQuestion.title') }}
                                        </a>
                                    @endcan
                                    @can('basic_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.basic.title') }}
                                        </a>
                                    @endcan
                                    @can('country_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.countries.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.country.title') }}
                                        </a>
                                    @endcan
                                    @can('city_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.cities.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.city.title') }}
                                        </a>
                                    @endcan
                                    @can('setting_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.settings.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.setting.title') }}
                                        </a>
                                    @endcan
                                    @can('content_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.contentManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('content_category_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.content-categories.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.contentCategory.title') }}
                                        </a>
                                    @endcan
                                    @can('content_tag_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.content-tags.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.contentTag.title') }}
                                        </a>
                                    @endcan
                                    @can('content_page_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.content-pages.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.contentPage.title') }}
                                        </a>
                                    @endcan
                                    @can('card_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.cards.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.card.title') }}
                                        </a>
                                    @endcan
                                    @can('basic_c_r_m_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.basicCRM.title') }}
                                        </a>
                                    @endcan
                                    @can('crm_status_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.crm-statuses.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.crmStatus.title') }}
                                        </a>
                                    @endcan
                                    @can('crm_customer_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.crm-customers.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.crmCustomer.title') }}
                                        </a>
                                    @endcan
                                    @can('crm_note_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.crm-notes.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.crmNote.title') }}
                                        </a>
                                    @endcan
                                    @can('crm_document_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.crm-documents.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.crmDocument.title') }}
                                        </a>
                                    @endcan
                                    @can('client_management_setting_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.clientManagementSetting.title') }}
                                        </a>
                                    @endcan
                                    @can('currency_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.currencies.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.currency.title') }}
                                        </a>
                                    @endcan
                                    @can('transaction_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.transaction-types.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.transactionType.title') }}
                                        </a>
                                    @endcan
                                    @can('income_source_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.income-sources.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.incomeSource.title') }}
                                        </a>
                                    @endcan
                                    @can('client_status_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.client-statuses.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.clientStatus.title') }}
                                        </a>
                                    @endcan
                                    @can('project_status_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.project-statuses.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.projectStatus.title') }}
                                        </a>
                                    @endcan
                                    @can('client_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.clientManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('client_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.clients.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.client.title') }}
                                        </a>
                                    @endcan
                                    @can('project_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.projects.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.project.title') }}
                                        </a>
                                    @endcan
                                    @can('note_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.notes.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.note.title') }}
                                        </a>
                                    @endcan
                                    @can('document_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.documents.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.document.title') }}
                                        </a>
                                    @endcan
                                    @can('transaction_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.transactions.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.transaction.title') }}
                                        </a>
                                    @endcan
                                    @can('slider_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.sliderManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('slider_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.sliders.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.slider.title') }}
                                        </a>
                                    @endcan
                                    @can('slider_item_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.slider-items.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.sliderItem.title') }}
                                        </a>
                                    @endcan
                                    @can('new_menu_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('laravel_subscription_managment::cruds.newMenu.title') }}
                                        </a>
                                    @endcan
                                    @can('group_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.groups.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.group.title') }}
                                        </a>
                                    @endcan
                                    @can('product_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.products.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.product.title') }}
                                        </a>
                                    @endcan
                                    @can('xfeatue_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.xfeatues.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.xfeatue.title') }}
                                        </a>
                                    @endcan
                                    @can('product_feature_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.product-features.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.productFeature.title') }}
                                        </a>
                                    @endcan
                                    @can('subscription_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.subscriptions.index') }}">
                                            {{ trans('laravel_subscription_managment::cruds.subscription.title') }}
                                        </a>
                                    @endcan

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(session('message'))
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                </div>
            @endif
            @if($errors->count() > 0)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                <ul class="list-unstyled mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@yield('scripts')

</html>