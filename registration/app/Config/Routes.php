<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/tradev', 'Tradev::index');
$routes->get('/tradev/form', 'Tradev::create');
$routes->post('/tradev/form', 'Register::create');
$routes->get('/tradev/edit/(:num)', 'Tradev::edit/$1');
$routes->post('/tradev/edit/(:num)', 'Tradev::edit/$1');
$routes->get('/tradev/delete/(:num)', 'Tradev::delete/$1');