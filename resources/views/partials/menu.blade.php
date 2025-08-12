<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('laravel_subscription_managment::panel.site_title') }}</span>
    </a>

    @php
        $path = config('laravel_subscription_managment.path');
    @endphp

<!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- @can('user_management_access') --}}
                    <li class="nav-item has-treeview {{ request()->is("$path/permissions*") ? "menu-open" : "" }} {{ request()->is("$path/roles*") ? "menu-open" : "" }} {{ request()->is("$path/groups*") ? "menu-open" : "" }} {{ request()->is("$path/teams*") ? "menu-open" : "" }} {{ request()->is("$path/user-profiles*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("$path/permissions*") ? "active" : "" }} {{ request()->is("$path/roles*") ? "active" : "" }} {{ request()->is("$path/groups*") ? "active" : "" }} {{ request()->is("$path/teams*") ? "active" : "" }} {{ request()->is("$path/user-profiles*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-puzzle-piece">

                            </i>
                            <p>
                                {{ trans('laravel_subscription_managment::cruds.general.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- @can('group_access') --}}
                            <li class="nav-item">
                                <a href="{{ route("ajax.subscription_groups.index") }}" class="nav-link {{ request()->is("$path/subscription_groups") || request()->is("$path/subscription_groups/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-layer-group"></i>
                                    <p>
                                        {{ trans('laravel_subscription_managment::cruds.subscriptionGroup.title') }}
                                    </p>
                                </a>
                            </li>
                            {{-- @endcan --}}
                            {{-- @can('feature_access') --}}
                            <li class="nav-item">
                                <a href="{{ route('ajax.subscription_features.index') }}" class="nav-link {{ request()->is("$path/subscription_features") || request()->is("$path/subscription_features/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-star"></i>
                                    <p>
                                        {{ trans('laravel_subscription_managment::cruds.subscriptionFeature.title') }}
                                    </p>
                                </a>
                            </li>
                            {{-- @endcan --}}
                        </ul>
                    </li>
                {{-- @endcan --}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>