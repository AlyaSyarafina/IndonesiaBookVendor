# DNArtworks CodeIgniter 4

This template can be used for a bare CodeIgniter 4 project with database and
admin page, also with docker preset inside `docker/`. For projects where you
are sure that you will never use admin page, better to take the latest version
from the CodeIgniter website.

## Starting a project

The project should contain all it needs since all required files are versioned
(i.e., not `.gitignore`d). However, if you would like to try out the admin page
right away, you can (1) setup database (2) Copy `/env` to `/.env`,
(3) `sudo chown -R www-data:www-data writable/` in Linux, and
(4) run migrate by navigating to http://localhost/migrate or via terminal:

```sh
$ docker-compose run web php spark migrate --all
```

Tip: see the difference between this template and the bare CodeIgniter 4 project using [this GitLab comparison tool link](https://gl.dnartworks.co.id/PNDevworks/Templates/CodeIgniter4/-/compare/codeigniter4-original...master?from_project_id=26353500).

### Updating to latest version

To take the latest CodeIgniter and our admin page update, please follow these steps:

```sh
$ # Create GitLab personal token with api or read_api access (https://docs.gitlab.com/ee/user/profile/personal_access_tokens.html)
$ # Add it to composer (https://getcomposer.org/doc/articles/authentication-for-private-packages.md#gitlab-token)
$ composer update --no-dev
```

Please note if you wish to do that and push to repository, please do the same also for `codeigniter4-original` branch. This is to ensure the comparison always show only the core differences not composer library version differences.

### Adding Frontend Libraries

Here are some guidelines when adding frontend library:

1. Put library files under `public/assets/lib/{library-name}`
2. Put only distribution files of the library, **no uncompiled source code, please.**
3. Usually you can `npm install {library-name}` and get the `dist/` folder for that. Or you may also manually download from their website.

Whenever possible, use similar libraries to our other projects:

1. Bootstrap and jQuery
2. [slick](http://kenwheeler.github.io/slick/) for carousel
3. [Tempus Dominus](https://getdatepicker.com/5-4/) for date and/or time picker
4. [Font Awesome](https://fontawesome.com/) for various icons
5. [noUiSlider](https://refreshless.com/nouislider/) for sliders

---

# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds the distributable version of the framework.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the development repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
