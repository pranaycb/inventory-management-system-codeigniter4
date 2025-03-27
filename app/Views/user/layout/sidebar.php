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
            'orders'        => ($segment === 'orders') ? 'active' : '',
            'account'        => ($segment === 'account') ? 'active' : '',
        ];

        ?>

        <ul class="sidebar-nav">

            <li class="sidebar-header">
                Dashboard
            </li>

            <li class="sidebar-item <?= $class['dashboard']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.users.dashboard'); ?>'>
                    <i class="ri-dashboard-3-line align-middle fs-3"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item <?= $class['orders']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.users.sales'); ?>'>
                    <i class="ri-money-dollar-box-line align-middle fs-3"></i>
                    <span class="align-middle">Orders</span>
                </a>
            </li>

            <li class="sidebar-item <?= $class['account']; ?>">
                <a class='sidebar-link' href='<?= route_to('route.users.account'); ?>'>
                    <i class="ri-user-2-line align-middle fs-3"></i>
                    <span class="align-middle">My Account</span>
                </a>
            </li>


            <li class="sidebar-header">Logout</li>

            <li class="sidebar-item">
                <a class='sidebar-link' href='<?= route_to('route.users.logout'); ?>'>
                    <i class="ri-logout-box-line align-middle fs-3"></i> <span class="align-middle">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>