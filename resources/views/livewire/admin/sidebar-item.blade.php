<li
    class="nav-item {{ request()->routeIS($keyword.'.index') || request()->routeIS($keyword.'.create') ? 'menu-open' : null }}">
    <a
        class="nav-link {{ request()->routeIS($keyword.'.index') || request()->routeIS($keyword.'.create') ? 'active' : null }}">
        <i class="{{ $icon }}"></i>
        <p>
            {{ trans('origin.'.$keyword) }}
            @can('index', $model)
                <i class="right fas fa-angle-left"></i>
            @else
                <i class="right fas fa-lock permission"></i>
            @endcan
        </p>
    </a>
    @can('index', $model)
        <ul class="nav nav-treeview">
            <li class="nav-item {{ request()->routeIS($keyword.'.index') ? 'item-active' : null }}">
                <a href="{{ route($keyword.'.index') }}" class="nav-link">
                    <i class="fas fa-list-ul nav-icon"></i>
                    <p>Danh sách</p>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIS($keyword.'.create') ? 'item-active' : null }}">
                <a href="{{ route($keyword.'.create') }}" class="nav-link">
                    <i class="fas fa-folder-plus nav-icon"></i>
                    <p>{{ trans('origin.create_new') }}</p>
                </a>
            </li>
        </ul>
    @endcan
</li>
