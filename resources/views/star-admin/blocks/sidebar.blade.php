<?php 
    $route_name = Route::currentRouteName();
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- <li class="nav-item {{ $route_name == 'sashboard' ? 'active' : null }}">
            <a class="nav-link" href="index.html">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li> --}}
        <li class="nav-item nav-category">Nội dung</li>
        @can('index', App\Models\Product::class)
        <li class="nav-item {{ $route_name == 'products' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('products') }}">
                <i class="fa-fw fa-brands fa-product-hunt menu-icon"></i>
                <span class="menu-title">{{ __('text.product') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\Article::class)
        <li class="nav-item {{ $route_name == 'articles' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('articles') }}">
                <i class="fa-fw fa-solid fa-file-signature menu-icon"></i>
                <span class="menu-title">{{ __('text.article') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\Category::class)
        <li class="nav-item {{ $route_name == 'categories' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('categories') }}">
                <i class="fa-fw fa-solid fa-layer-group menu-icon"></i>
                <span class="menu-title">{{ __('text.category') }}</span>
            </a>
        </li>
        @endcan
        <li class="nav-item {{ $route_name == 'images' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('images') }}">
                <i class="fa-fw fa-regular fa-images menu-icon"></i>
                <span class="menu-title">{{ __('text.image') }}</span>
            </a>
        </li>

        <li class="nav-item nav-category">Khách hàng - Đối tác</li>
        @can('index', App\Models\Project::class)
        <li class="nav-item {{ $route_name == 'projects' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('projects') }}">
                <i class="fa-solid fa-city menu-icon"></i>
                <span class="menu-title">{{ __('text.project') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\Customer::class)
        <li class="nav-item {{ $route_name == 'customers' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('customers') }}">
                <i class="fa-fw fa-solid fa-people-group menu-icon"></i>
                <span class="menu-title">{{ __('text.customer') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\Supplier::class)
        <li class="nav-item {{ $route_name == 'suppliers' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('suppliers') }}">
                <i class="fa-solid fa-store menu-icon"></i>
                <span class="menu-title">{{ __('text.supplier') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\SupplierOrder::class)
        <li class="nav-item {{ $route_name == 'supplier-order' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('supplier_orders') }}">
                <i class="fa-solid fa-cart-shopping menu-icon"></i>
                <span class="menu-title">Đặt hàng Nhà cung cấp</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\Order::class)
        <li class="nav-item {{ $route_name == 'orders' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('orders') }}">
                <i class="fa-fw fa-solid fa-bag-shopping menu-icon"></i>
                <span class="menu-title">{{ __('text.order') }}</span>
            </a>
        </li>
        @endcan

        <li class="nav-item nav-category">Quản lý bán hàng</li>
        @can('index', App\Models\Inventory::class)
        <li class="nav-item {{ $route_name == 'inventories' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('inventories') }}">
                <i class="fa-solid fa-warehouse menu-icon"></i>
                <span class="menu-title">{{ __('text.inventory') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\Import::class)
        <li class="nav-item {{ $route_name == 'imports' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('imports') }}">
                <i class="fa-solid fa-cart-flatbed menu-icon"></i>
                <span class="menu-title">{{ __('text.import') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\InventoryProduct::class)
        <li class="nav-item {{ $route_name == 'inventory_products' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('inventory_products') }}">
                <i class="fa-solid fa-boxes-stacked menu-icon"></i>
                <span class="menu-title">{{ __('text.stock') }}</span>
            </a>
        </li>
        @endcan
        
        <li class="nav-item nav-category">Hệ thống</li>
        @can('index', App\Models\Setting::class)
        <li class="nav-item {{ $route_name == 'settings' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('settings') }}">
                <i class="fa-fw fa-solid fa-gear menu-icon"></i>
                <span class="menu-title">{{ __('text.txt_setting') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\User::class)
        <li class="nav-item {{ $route_name == 'users' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('users') }}">
                <i class="fa-fw fa-solid fa-user menu-icon"></i>
                <span class="menu-title">{{ __('text.user') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\UserGroup::class)
        <li class="nav-item {{ $route_name == 'usergroups' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('usergroups') }}">
                <i class="fa-fw fa-solid fa-users menu-icon"></i>
                <span class="menu-title">{{ __('text.usergroup') }}</span>
            </a>
        </li>
        @endcan
        @can('index', App\Models\Channel::class)
        <li class="nav-item {{ $route_name == 'channels' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('channels') }}">
                <i class="fa-fw fa-solid fa-bars-staggered menu-icon"></i>
                <span class="menu-title">{{ __('text.channel') }}</span>
            </a>
        </li>
        @endcan
        
        
        @can('index', App\Models\User::class)
        <li class="nav-item nav-category">UI Elements</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-floor-plan"></i>
                <span class="menu-title">UI Elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="pages/ui-features/buttons.html">Buttons</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="pages/ui-features/typography.html">Typography</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Forms and Datas</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Form elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic
                            Elements</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false"
                aria-controls="charts">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">Charts</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="pages/charts/chartjs.html">ChartJs</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false"
                aria-controls="tables">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Tables</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic
                            table</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false"
                aria-controls="icons">
                <i class="menu-icon mdi mdi-layers-outline"></i>
                <span class="menu-title">Icons</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">pages</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false"
                aria-controls="auth">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">help</li>
        <li class="nav-item">
            <a class="nav-link"
                href="http://bootstrapdash.com/demo/star-admin2-free/docs/documentation.html">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Documentation</span>
            </a>
        </li>
        @endcan
</nav>