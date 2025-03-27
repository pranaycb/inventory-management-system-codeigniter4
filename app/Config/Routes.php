<?php


/**
 * Public pages
 */
$routes->get('/', 'Public\Home::index', ['as' => 'route.home']);


/**
 * User routes
 */
$routes->group('user', ['namespace' => 'App\Controllers\User'], function ($routes) {

    /**
     * Login routes
     */
    $routes->group('login', function ($routes) {

        $routes->get('', 'Login::index', ['as' => 'route.user.login']);

        $routes->post('validate', 'Login::validateSubmitData', ['as' => 'route.user.login.validate']);
    });

    /**
     * Register routes
     */
    $routes->group('register', function ($routes) {

        $routes->get('', 'Register::index', ['as' => 'route.user.register']);

        $routes->post('validate', 'Register::validateSubmitData', ['as' => 'route.user.register.validate']);
    });

    /**
     * Dashboard routes
     */
    $routes->group('', ['filter' => ['user-filter']],  function ($routes) {

        //Dashboard route
        $routes->get('dashboard', 'Dashboard::index', [
            'as' => 'route.users.dashboard'
        ]);

        //Orders routes
        $routes->group("orders", function ($routes) {

            $routes->get('', 'Sale::index', [
                'as' => 'route.users.sales',
            ]);

            $routes->post('fetch', 'Sale::fetch', [
                'as' => 'route.users.sales.fetch',
            ]);
        });

        //Account routes
        $routes->group("account", function ($routes) {

            $routes->get('', 'Account::index', [
                'as' => 'route.users.account',
            ]);

            $routes->post('update/profile', 'Account::updateProfile', [
                'as' => 'route.users.account.profile.update',
            ]);

            $routes->post('update/password', 'Account::updatePassword', [
                'as' => 'route.users.account.password.update',
            ]);
        });

        //logout route
        $routes->get('logout', 'Logout::index', [
            'as' => 'route.users.logout',
        ]);
    });
});


/**
 * Admin routes
 */
$routes->group('admin', ['namespace' => 'App\Controllers\Dashboard'], function ($routes) {

    /**
     * Login routes
     */
    $routes->group('login', function ($routes) {

        $routes->get('', 'Login::index', ['as' => 'route.admin.login']);

        $routes->post('validate', 'Login::validateSubmitData', ['as' => 'route.admin.login.validate']);
    });

    /**
     * Dashboard routes
     */

    $routes->group('', ['filter' => ['admin-filter']],  function ($routes) {


        //Dashboard route
        $routes->get('dashboard', 'Dashboard::index', [
            'as' => 'route.dashboard'
        ]);

        //User routes
        $routes->group("users", function ($routes) {

            $routes->get('', 'User::index', [
                'as' => 'route.users',
            ]);

            $routes->post('fetch', 'User::fetch', [
                'as' => 'route.users.fetch',
            ]);

            $routes->get('new', 'User::new', [
                'as' => 'route.users.new',
            ]);

            $routes->post('create', 'User::create', [
                'as' => 'route.users.create',
            ]);

            $routes->get('edit/(:num)', 'User::edit/$1', [
                'as' => 'route.users.edit',
            ]);

            $routes->post('update/profile/(:num)', 'User::updateProfile/$1', [
                'as' => 'route.users.profile.update',
            ]);

            $routes->post('update/password/(:num)', 'User::updatePassword/$1', [
                'as' => 'route.users.password.update',
            ]);

            $routes->delete('delete', 'User::delete', [
                'as' => 'route.users.delete',
            ]);
        });

        //Category routes
        $routes->group("categories", function ($routes) {

            $routes->get('', 'Category::index', [
                'as' => 'route.categories',
            ]);

            $routes->post('fetch', 'Category::fetch', [
                'as' => 'route.categories.fetch',
            ]);

            $routes->get('new', 'Category::new', [
                'as' => 'route.categories.new',
            ]);

            $routes->post('create', 'Category::create', [
                'as' => 'route.categories.create',
            ]);

            $routes->get('edit/(:num)', 'Category::edit/$1', [
                'as' => 'route.categories.edit',
            ]);

            $routes->post('update/(:num)', 'Category::update/$1', [
                'as' => 'route.categories.update',
            ]);

            $routes->delete('delete', 'Category::delete', [
                'as' => 'route.categories.delete',
            ]);
        });

        //Brand routes
        $routes->group("brands", function ($routes) {

            $routes->get('', 'Brand::index', [
                'as' => 'route.brands',
            ]);

            $routes->post('fetch', 'Brand::fetch', [
                'as' => 'route.brands.fetch',
            ]);

            $routes->get('new', 'Brand::new', [
                'as' => 'route.brands.new',
            ]);

            $routes->post('create', 'Brand::create', [
                'as' => 'route.brands.create',
            ]);

            $routes->get('edit/(:num)', 'Brand::edit/$1', [
                'as' => 'route.brands.edit',
            ]);

            $routes->post('update/(:num)', 'Brand::update/$1', [
                'as' => 'route.brands.update',
            ]);

            $routes->delete('delete', 'Brand::delete', [
                'as' => 'route.brands.delete',
            ]);
        });

        //Attribute routes
        $routes->group("attributes", function ($routes) {

            $routes->get('', 'Attribute::index', [
                'as' => 'route.attributes',
            ]);

            $routes->post('fetch', 'Attribute::fetch', [
                'as' => 'route.attributes.fetch',
            ]);

            $routes->get('new', 'Attribute::new', [
                'as' => 'route.attributes.new',
            ]);

            $routes->post('create', 'Attribute::create', [
                'as' => 'route.attributes.create',
            ]);

            $routes->get('edit/(:num)', 'Attribute::edit/$1', [
                'as' => 'route.attributes.edit',
            ]);

            $routes->post('update/(:num)', 'Attribute::update/$1', [
                'as' => 'route.attributes.update',
            ]);

            $routes->delete('delete', 'Attribute::delete', [
                'as' => 'route.attributes.delete',
            ]);
        });

        //Product routes
        $routes->group("products", function ($routes) {

            $routes->get('', 'Product::index', [
                'as' => 'route.products',
            ]);

            $routes->post('fetch', 'Product::fetch', [
                'as' => 'route.products.fetch',
            ]);

            $routes->get('new', 'Product::new', [
                'as' => 'route.products.new',
            ]);

            $routes->post('create', 'Product::create', [
                'as' => 'route.products.create',
            ]);

            $routes->get('edit/(:num)', 'Product::edit/$1', [
                'as' => 'route.products.edit',
            ]);

            $routes->post('update/(:num)', 'Product::update/$1', [
                'as' => 'route.products.update',
            ]);

            $routes->delete('delete', 'Product::delete', [
                'as' => 'route.products.delete',
            ]);
        });

        //Sales routes
        $routes->group("sales", function ($routes) {

            $routes->get('', 'Sale::index', [
                'as' => 'route.sales',
            ]);

            $routes->post('fetch', 'Sale::fetch', [
                'as' => 'route.sales.fetch',
            ]);

            $routes->get('new', 'Sale::new', [
                'as' => 'route.sales.new',
            ]);

            $routes->post('create', 'Sale::create', [
                'as' => 'route.sales.create',
            ]);

            $routes->get('edit/(:num)', 'Sale::edit/$1', [
                'as' => 'route.sales.edit',
            ]);

            $routes->post('update/(:num)', 'Sale::update/$1', [
                'as' => 'route.sales.update',
            ]);

            $routes->delete('delete', 'Sale::delete', [
                'as' => 'route.sales.delete',
            ]);
        });

        //Settings routes
        $routes->group("settings", function ($routes) {

            $routes->get('', 'Settings::index', [
                'as' => 'route.settings',
            ]);

            $routes->post('app/update', 'Settings::updateApp', [
                'as' => 'route.settings.app.update',
            ]);

            $routes->post('auth/update', 'Settings::updateAuth', [
                'as' => 'route.settings.auth.update',
            ]);
        });

        //logout route
        $routes->get('logout', 'Logout::index', [
            'as' => 'route.logout',
        ]);
    });
});
