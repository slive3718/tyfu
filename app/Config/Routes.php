<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//$routes->get('login', 'Auth\LoginController::login');
$routes->get('admin', 'Admin::index');
$routes->get('admin/login', 'Admin::login');