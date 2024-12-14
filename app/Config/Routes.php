<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/ibv','HomeController::actionIndex');
$routes->get('/sitemap.xml', 'Sitemap::index');
$routes->get('/register','RegisterController::index');
