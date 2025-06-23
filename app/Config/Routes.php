<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home Routes
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/shop', 'Home::shop');
$routes->get('/contact', 'Home::contact');
$routes->get('/product/(:num)', 'Home::productDetail/$1');

// Auth Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');
    $routes->get('logout', 'Auth::logout');
});

// Customer Routes
$routes->group('customer', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Customer::dashboard');
    $routes->get('profile', 'Customer::profile');
    $routes->post('profile/update', 'Customer::updateProfile');
    $routes->get('orders', 'Customer::orders');
    $routes->get('orders/(:num)', 'Customer::orderDetail/$1');
});

// Cart Routes
$routes->group('cart', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Cart::index');
    $routes->post('add', 'Cart::add');
    $routes->post('update', 'Cart::update');
    $routes->post('remove', 'Cart::remove');
    $routes->get('checkout', 'Cart::checkout');
    $routes->post('process', 'Cart::processCheckout');
});

// Quick Checkout Routes
$routes->group('checkout', ['filter' => 'auth'], function($routes) {
    $routes->post('quick', 'Checkout::quick');
    $routes->get('product/(:num)', 'Checkout::productCheckout/$1');
    $routes->post('product/process', 'Checkout::processProductCheckout');
});

// Payment Routes
$routes->group('payment', function($routes) {
    $routes->post('notification', 'Payment::notification');
    $routes->get('success/(:segment)', 'Payment::success/$1');
    $routes->get('pending/(:segment)', 'Payment::pending/$1');
    $routes->get('error/(:segment)', 'Payment::error/$1');
});

// Admin Routes
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'Admin::dashboard');
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Product Management
    $routes->get('products', 'Admin::products');
    $routes->get('products/create', 'Admin::createProduct');
    $routes->post('products/store', 'Admin::storeProduct');
    $routes->get('products/edit/(:num)', 'Admin::editProduct/$1');
    $routes->post('products/update/(:num)', 'Admin::updateProduct/$1');
    $routes->post('products/delete/(:num)', 'Admin::deleteProduct/$1');
    
    // Category Management
    $routes->get('categories', 'Admin::categories');
    $routes->post('categories/store', 'Admin::storeCategory');
    $routes->post('categories/update/(:num)', 'Admin::updateCategory/$1');
    $routes->post('categories/delete/(:num)', 'Admin::deleteCategory/$1');
    
    // Order Management
    $routes->get('orders', 'Admin::orders');
    $routes->get('orders/(:num)', 'Admin::orderDetail/$1');
    $routes->post('orders/update-status/(:num)', 'Admin::updateOrderStatus/$1');
    $routes->get('orders/receipt/(:num)', 'Admin::orderReceipt/$1');
    
    // User Management
    $routes->get('users', 'Admin::users');
    $routes->post('users/store', 'Admin::storeUser');
    $routes->post('users/update/(:num)', 'Admin::updateUser/$1');
    $routes->post('users/toggle-status/(:num)', 'Admin::toggleUserStatus/$1');
    $routes->get('users/orders/(:num)', 'Admin::userOrders/$1');
});
