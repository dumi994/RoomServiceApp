<div class="sidebar">


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @php
                $currentRoute = request()->route()->getName(); // o request()->path()
            @endphp

            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>Ordini</p>
                </a>
            </li>
            <li class="nav-item has-treeview {{ request()->is('dashboard/services*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('dashboard/services*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>
                        Servizi
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/dashboard/services') }}"
                            class="nav-link {{ request()->is('dashboard/services') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Elenco Servizi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/dashboard/services/create') }}"
                            class="nav-link {{ request()->is('dashboard/services/create') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Nuovo Servizio</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview {{ request()->is('dashboard/menu*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('dashboard/menu*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-utensils"></i>
                    <p>
                        Menu
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/dashboard/menu') }}"
                            class="nav-link {{ request()->is('dashboard/menu') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Elenco Menu items</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/dashboard/menu/create') }}"
                            class="nav-link {{ request()->is('dashboard/menu/create') ? 'active' : '' }}">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Aggiungi Menu item</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/dashboard/site-content') }}"
                    class="nav-link {{ request()->is('dashboard/site-content') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-pager"></i>
                    <p>App Content</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
