<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class='sidebar-brand' href='<?= current_url(); ?>'>
            <span class="align-middle fw-bold">
                <?= getSetting('site_title'); ?> Dashboard
            </span>
        </a>

        <?php

        $uri = service('uri');

        $segment = $uri->getSegment(2);

        $class = [
            'dashboard'     => ($segment === 'dashboard') ? 'active' : '',
            'users'         => ($segment === 'users') ? 'active' : '',
            'categories'    => ($segment === 'categories') ? 'active' : '',
            'brands'        => ($segment === 'brands') ? 'active' : '',
            'attributes'    => ($segment === 'attributes') ? 'active' : '',
            'products'      => ($segment === 'products') ? 'active' : '',
            'sales'         => ($segment === 'sales') ? 'active' : '',
            'inventory'     => ($segment === 'inventory') ? 'active' : '',
            'settings'      => ($segment === 'settings') ? 'active' : '',
        ];

        ?>

        <ul class="sidebar-nav">

            <li class="sidebar-header">
                Dashboard
            </li>

            <li class="sidebar-item <?= $class['dashboard']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.dashboard'); ?>'>
                    <i class="ri-dashboard-3-line align-middle fs-3"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">Inventory Options</li>

            <li class="sidebar-item <?= $class['users']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.users'); ?>'>
                    <i class="ri-group-line align-middle fs-3"></i>
                    <span class="align-middle">Users</span>
                </a>
            </li>

            <li class="sidebar-item <?= $class['categories']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.categories'); ?>'>
                    <i class="ri-list-indefinite align-middle fs-3"></i>
                    <span class="align-middle">Categories</span>
                </a>
            </li>

            <li class="sidebar-item <?= $class['brands']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.brands'); ?>'>
                    <i class="ri-apps-line align-middle fs-3"></i>
                    <span class="align-middle">Brands</span>
                </a>
            </li>

            <li class="sidebar-item <?= $class['attributes']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.attributes'); ?>'>
                    <i class="ri-pie-chart-2-line align-middle fs-3"></i>
                    <span class="align-middle">Attributes</span>
                </a>
            </li>

            <li class="sidebar-item <?= $class['products']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.products'); ?>'>
                    <i class="ri-box-3-line align-middle fs-3"></i>
                    <span class="align-middle">Products</span>
                </a>
            </li>

            <li class="sidebar-item <?= $class['sales']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.sales'); ?>'>
                    <i class="ri-money-dollar-box-line align-middle fs-3"></i>
                    <span class="align-middle">Sales</span>
                </a>
            </li>

            <li class="sidebar-header">Settings</li>

            <li class="sidebar-item <?= $class['settings']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.settings'); ?>'>
                    <i class="ri-settings-2-line align-middle fs-3"></i>
                    <span class="align-middle">Settings</span>
                </a>
            </li>

            <li class="sidebar-header">Logout</li>

            <li class="sidebar-item">
                <a class='sidebar-link' href='<?= route_to('route.logout'); ?>'>
                    <i class="ri-logout-box-line align-middle fs-3"></i> <span class="align-middle">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>