<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// The default route will now point to the login page
$routes->get('/', 'Login::index');

// Publicly accessible login/logout routes
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');

// The dashboard is accessible to all logged-in users
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Routes for the Authentication system itself
$routes->get('/users', 'User::index', ['filter' => 'auth:1']); // Only Admin (role_id 1) can view users
$routes->get('/users/add', 'User::create', ['filter' => 'auth:1']);
$routes->post('/users/save', 'User::save', ['filter' => 'auth:1']);
$routes->get('/users/edit/(:num)', 'User::edit/$1', ['filter' => 'auth:1']);
$routes->post('/users/update/(:num)', 'User::update/$1', ['filter' => 'auth:1']);
$routes->post('/users/delete/(:num)', 'User::delete/$1', ['filter' => 'auth:1']);

// Inventory routes - Admin and Warehouse Staff can manage
$routes->group('inventory', ['filter' => 'auth:1,2'], function ($routes) {
    $routes->get('/', 'Inventory::index');
    $routes->get('add', 'Inventory::create');
    $routes->post('save', 'Inventory::save');
    $routes->get('details/(:num)', 'Inventory::details/$1');
    $routes->get('edit/(:num)', 'Inventory::edit/$1');
    $routes->post('update/(:num)', 'Inventory::update/$1');
    $routes->post('delete/(:num)', 'Inventory::delete/$1');
});

// Order routes - Admin and Warehouse Staff can manage
$routes->group('order', ['filter' => 'auth:1,2'], function ($routes) {
    $routes->get('/', 'Order::index');
    $routes->get('add', 'Order::create');
    $routes->post('save', 'Order::save');
    $routes->get('details/(:num)', 'Order::details/$1');
    $routes->post('process/(:num)', 'Order::process/$1');
});

// Report routes - All roles can view reports
$routes->group('report', ['filter' => 'auth:1,2,3'], function ($routes) {
    $routes->get('/', 'Report::index');
    $routes->get('low-stock', 'Report::low_stock');
    $routes->get('export-inventory-csv', 'Report::export_inventory_csv');
});

// Warehouse Layout routes - Only Admin can manage
$routes->group('warehouse-layout', ['filter' => 'auth:1'], function ($routes) {
    $routes->get('/', 'WarehouseLayout::index');
    $routes->get('add', 'WarehouseLayout::create');
    $routes->post('save', 'WarehouseLayout::save');
    $routes->get('edit/(:num)', 'WarehouseLayout::edit/$1');
    $routes->post('update/(:num)', 'WarehouseLayout::update/$1');
    $routes->post('delete/(:num)', 'WarehouseLayout::delete/$1');
});

// Barcode Scanning routes - Admin and Warehouse Staff can scan
$routes->get('/scan', 'Inventory::barcode_scanner', ['filter' => 'auth:1,2']);
$routes->get('/inventory/get-by-sku/(:any)', 'Inventory::get_by_sku/$1');