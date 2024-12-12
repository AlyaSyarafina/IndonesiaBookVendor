<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes = Services::routes();
 
 $routes->setDefaultNamespace('App\Controllers');
 $routes->setDefaultController('Home');
 $routes->setDefaultMethod('index');
 $routes->setTranslateURIDashes(false);
 $routes->set404Override();
 $routes->setAutoRoute(false);

 $routes->get('/', 'Home::index');
 $routes->get('/register', 'RegisterController::index');
 $routes->post('/register', 'RegisterController::index'); // This line is optional if you want to handle POST requests to the same URL
?>