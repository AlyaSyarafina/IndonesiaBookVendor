# Admin Panel

The infamous PNDevwork's Flagship Admin Panel.

## Installation
First you need to follow the GitLab's Guide to authenticate with this group's
Composer registry.

Ref:
- https://docs.gitlab.com/ee/user/packages/composer_repository/#install-a-composer-package
- https://getcomposer.org/doc/articles/authentication-for-private-packages.md#gitlab-token

Then you can install this package via Composer:

```shell
composer req pndevworks/admin-panel
```

Then add the configuration file on `Config/AdminPanel.php` and configure it as
needed.

<details>
    <summary>See sample file</summary>

```php
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
			]
		],
	];

	public $admin_groups = [];

	public $brandingOptions = [
        "site-title" => "Aprilia Admin",
        "logo" => "",
        "footer" => "",
        "navbarUseLogo" => false
    ];
}
```

</details>

Warning: This project contains migration, don't forget to run the migration with
`--all` option when you're executing the migration on terminal.

```shell
php spark migrate --all
```

That's it.

## Releasing New Version

Committing to the master branch will automatically generate a new version of
admin-panel composer package. Depending on the commit message (copied from
https://github.com/pantheon-systems/autotag#scheme-conventional-commits):

- A commit message footer containing `BREAKING CHANGE:` will bump the **major** version:

```
feat: allow provided config object to extend other configs

BREAKING CHANGE: `extends` key in config file is now used for extending other config files
```

- A commit message header containing a _type_ of `feat` will bump the **minor** version:

```
feat(lang): add polish language
```

- A commit message header containg a `!` after the _type_ is considered a breaking change and will
  bump the **major** version:

```
refactor!: drop support for Node 6
```

If no keywords are specified a **Patch** bump is applied.

## Frequently Asked Questions:

### How to add more columns to `users`?

Please follow the [Adding a Column to a Table] Guide from CI4 Manual.

### How to get currently logged in user?

Use the `UserModel::getcurrent()`. This will return currently logged in user as
a `UserEntity` that you can use for many things. We've added some annotations
for basic column on the built-in migration.

You can also use `UserEntity` to access your additional column/properties as
CI's Entity made with [Virtual Property]. For mor einformation, please consult
with CI's [Entity Manual].


### Is it possible to override the `UserModel`?

Yes, you have two possible way to do this:
- Create entirely new model that contains all the columns built-in with this
  package. \
  For the full complete list, please check the migration file(s).
- Extend `UserModel` from this package, override neccessary settings (e.g return
  type), then extend the `UserEntity` too if you plan to use the entity.

### How to add more functionality the admin panel?

You have two ways:
- Extend the `Admin` class from `Controller`, add your thing, and then update
  the routing.
- Follow the discussion on
  [#5](https://gil.dnartworks.co.id/PNDevworks/deps/admin-panel/-/issues/5).




[Virtual Property]: https://www.php.net/manual/en/language.oop5.overloading.php#object.get
[Entity Manual]: https://codeigniter4.github.io/userguide/models/entities.html
[Adding a Column to a Table]:
https://codeigniter4.github.io/userguide/dbmgmt/forge.html?highlight=add%20columns#adding-a-column-to-a-table
