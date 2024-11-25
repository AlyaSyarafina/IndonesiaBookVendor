<?php

namespace Config;

use PNDevworks\AdminPanel\Config\AdminPanel as ConfigAdminPanel;

class AdminPanel extends ConfigAdminPanel
{
	public $admin_tables = [
		'users' => [
			'label' => 'Users',
			'allow' => ['create', 'update', 'delete'],
			'index' => [
				'cols' => ['id', 'email', 'first_name'],
				'order_by' => ['email', 'ASC']
			],
			'create' => [
				'first_name' => ['type' => 'text'],
				'last_name' => ['type' => 'text'],
				'email' => ['type' => 'email'],
				'password' => ['type' => 'password'],
			],
			'update' => [
				'first_name' => ['type' => 'text'],
				'last_name' => ['type' => 'text'],
				'email' => ['type' => 'email'],
				'password' => ['type' => 'password', 'scope' => 'all'],
				'admin_extras' => [
					'message' => 'Perform update before uploading image, if you have unsaved changes',
					'images' => [
						'allowed_types' => 'jpg',
						'target_extension' => 'jpg',
						'autoconvert' => [
							'enable' => true,
							'sizes' => ['1920w', '1024w', '500w'],
							"formats" => [IMAGETYPE_JPEG, IMAGETYPE_WEBP]
						]
					]
				]
			]
		]
	];

	public $admin_groups = [];

	public $brandingOptions = [
		"site-title" => "(Your Project Name) Admin",
		"logo" => "",
		"footer" => "",
		"navbarUseLogo" => false
	];
}
