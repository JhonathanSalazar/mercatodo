<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="header">NAVEGACIÓN</li>
    <li class="treeview {{ request()->is('admin') ? 'class = active' : ''}}">
        <a href="{{ route('home') }}">
            <i class="fa fa-home"></i
            ><span>Inicio</span>
        </a>
    </li>
    <li class="treeview {{ request()->is('admin/users') ? 'class = active' : ''}}">
        <a href="{{ route('admin.users.index') }}">
            <i class="fa fa-users"></i>
            <span>Usuarios</span>
        </a>
    </li>
    @if( auth()->user()->hasPermissionTo(Permissions::VIEW_PRODUCTS) )
        <li class="treeview {{ request()->is('admin/products') ? 'class = active' : ''}}">
            <a href="{{ route('admin.products.index') }}">
                <i class="fa fa-barcode"></i>
                <span>Productos</span>
            </a>
        </li>
    @endif
    <li class="treeview {{ request()->is('admin/reports') ? 'class = active' : ''}}">
        <a href="{{ route('admin.reports.index') }}">
            <i class="fa fa-download"></i>
            <span>Reportes</span>
        </a>
    </li>
</ul>
