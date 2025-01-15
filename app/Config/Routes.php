<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Tasks::index');
$routes->get('tasks', 'Tasks::index');
$routes->get('tasks/new', 'Tasks::new');
$routes->post('tasks/create', 'Tasks::create');
$routes->get('tasks/edit/(:num)', 'Tasks::edit/$1');
$routes->put('tasks/update/(:num)', 'Tasks::update/$1');
$routes->delete('tasks/delete/(:num)', 'Tasks::delete/$1');