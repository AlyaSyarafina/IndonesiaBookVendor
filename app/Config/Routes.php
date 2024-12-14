<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/ibv','HomeController::actionIndex');
$routes->get('/sitemap.xml', 'Sitemap::index');
$routes->get('/register','RegisterController::index');

// browse
$routes->get('/browse/subject','BrowseController::subjek');
$routes->get('/browse/author','BrowseController::author');
$routes->get('/browse/publisher','BrowseController::publisher');

// about
$routes->get('/page/about-us','PageController::about_us');
$routes->get('/page/sitemap','PageController::sitemap');
$routes->get('/page/contact','PageController::contact');
$routes->get('/page/faq','PageController::faq');

//register
$routes->get('/register/index','RegisterController::regis');

//login
$routes->get('/customer','test_LoginController::login');