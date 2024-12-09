<?php

namespace PNDevworks\AdminPanel\Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

$routes->group('admin', ['namespace' => 'PNDevworks\AdminPanel\Controllers'], function ($routes) {
	// Authentication service
	$routes->get("auth/login", "User::get_login", ['as' => 'pnd_login']);
	$routes->post("auth/login", "User::post_login");
	$routes->post("auth/logout", "User::post_logout", ['filter' => 'pnd_auth', 'as' => 'pnd_logout']);

	$routes->get("assets/(.+)", "AdminAssetServe::get_serve/$1", ['as' => 'pnd_admin_asset']);

	// Redir root to inner group of this grouping
	$routes->addRedirect('/', '/admin/panel');

	// Admin panels
	$routes->group("panel", ['namespace' => 'PNDevworks\AdminPanel\Controllers', 'filter' => 'pnd_auth'], function ($routes) {
		$routes->get("", "Admin::index", ["as" => "pnd_admin"]);
		$routes->get("index/(:segment)/(:segment)", "Admin::index/$1/$2", ["as" => "pnd_admin_index"]);
		$routes->get("update/(:segment)/(:segment)", "Admin::update/$1/$2", ["as" => "pnd_admin_update"]);
		$routes->post("update/(:segment)/(:segment)", "Admin::update/$1/$2");
		$routes->post("delete/(:segment)/(:segment)", "Admin::delete/$1/$2", ["as" => "pnd_admin_delete"]);
		$routes->get("create/(:segment)", "Admin::create/$1", ["as" => "pnd_admin_create"]);
		$routes->post("create/(:segment)", "Admin::create/$1");
		$routes->get("csv/(:segment)", "Admin::csv/$1", ["as" => "pnd_admin_csv"]);
		$routes->post("uploadmanipulate/(:segment)/(:segment)", "Admin::uploadmanipulate/$1/$2", ["as" => "pnd_admin_uploadmanipulate"]);
		$routes->post("upload/(:segment)/(:segment)", "Admin::upload/$1/$2", ["as" => "pnd_admin_upload"]);
	});
});
