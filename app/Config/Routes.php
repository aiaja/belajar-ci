<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login', ['filter' => 'redirect']);
$routes->get('logout', 'AuthController::logout');

$routes->get('contact', 'ContactController::index', ['as' => 'contact', 'filter' => 'auth']);

$routes->get('produk', 'ProdukController::index', ['filter' => 'auth']);
$routes->get('faq', 'FaqController::index', ['filter' => 'auth']);
$routes->get('contact', 'ContactController::index', ['filter' => 'auth']);
$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);
