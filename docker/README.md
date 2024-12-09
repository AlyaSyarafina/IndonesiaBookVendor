# Docker Add On Guide

## Table of Contents

[[_TOC_]]

## Prerequisites

Please make sure that these tools installed and working:

1. Docker. \
   https://docs.docker.com/install/

2. Docker Compose. \
   https://docs.docker.com/compose/install/ \
   Docker Compose is installed by default if you install Docker Desktop, but if
   you install only the Docker Engine, you might need to manually check if
   Docker Compose is installed or not. To check, you can run `docker compose
   version`.

## Running

If your project have the `docker/` directory in it, you can just run them.

1. Inside `docker/`, run `docker compose build` to build the image (run it
   once).

2. Run `docker compose up` **or** `docker compose up -d` if you don't want to
   see the log.

   ```shell
   $ docker compose up
   ```

   Docker will pull some required files automatically and will start the server
   for you.

3. Do all required stuffs, for example database migration
   (`http://localhost/migrate`) or copying `uploads_initial/` to
   `httpdocs/asset/upload/`, etc.

Notes:

* phpMyAdmin is accessible on port 8000, i.e. `http://localhost:8000`

* **⚠⚠ WARNING! :** Make sure that the MariaDB is ready first before you do the
  migration. MariaDB took 10s-2 minutes on first time start.

### Selecting PHP Version

There are a build argument that you can use to configure the PHP Version being
used in this project: `PHPVER`.

By default, we use PHP version 8.2 to support the [current] latest PHP version,
but you can actually change it to any other version (or image tags) that ended
with `-apache`.

After changing the PHP version, you will need to run `docker compose build` or
`docker compose up --build` again.

## Attaching to Project

If your project is not docker-enabled yet (`docker/` dir is not there), follow
these steps:

1. Copy `docker/` directory from
   https://gl.dnartworks.co.id/PNDevworks/Templates/DockerAddOn to your project.

2. Modify your configuration files (recommended to do both the ignored and
   git-tracked ones):
    * `config.php` or `config.example.php`:
        - `$config['base_url']` set to `'http://localhost/'`
    * **Database has been configured for CodeIgniter 4 by default**, you
      should't need to do this, unless it doesn't work, or the project doesn't
      use CodeIgniter 4. \
      `database.php` or `database.example.php`, database configuration:
        - `'hostname'` set to `'db'`
        - `'username'` set to `'root'`
        - `'password'` set to `''` (empty)
        - `'database'` set to `'pndevworks_project'`

3. Try [running it](#running), and if you're satisfied, `git add`, `git commit`
   and `git push` so we can skip these steps next time.

## Uninstall

If you wish to remove docker support from the project, simply remove the
`docker/` directory, and restore the config of the files, i.e. predefined config
files.

## Known Limitations & Problems

### Unable to Rename Table in MariaDB on Windows

If you're experiencing this, please switch to MySQL, or simply fetch DB dump
from stagging.

## Extras

### Customizing your own instance

Copy the `docker-compose.yml` and edit the port section of the selected services
and run it with

```shell
$ docker compose -f your-own-docker-compose-file.yml up
```

Also make sure that that docker file is ignored upon committing the changes.

### Using your own MySQL/MariaDB Instance

Just in case you want to use your own existing DB Instance.

Go to `database.php`, and match to your server setting.

```php
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'host.docker.internal', // This is important, or you can use any other IP
	'username' => 'root',
	'password' => '',
	'database' => 'pndevworks_project',
	'dbdriver' => 'mysqli',
    /* ... */
);
```

Because we use Docker, the host instance are reachable on `host.docker.internal`
([ref](https://stackoverflow.com/a/45002996/4721245)). Anything else, you can
use your own configuration.

### Development & Production Environment (switching ENV)

CodeIgniter Supports `development` and `production` mode switch via Environment
variables. You can quickly disable verbose logging (to prevent database
credentials leaking) or any `development`-env-only routine and tools.

First, you need to append this snippets to `.htaccess` file on public folder or
at project root folder, near `index.php`:

```htaccess
<IfModule mod_env.c>
    SetEnv CI_ENV production
    PassEnv CI_ENV
    SetEnv CI_ENVIRONMENT production
    PassEnv CI_ENVIRONMENT
</IfModule>
```

By adding this configuration to `.htaccess`, you'll set the default environment
of this project to `production` (line 2), and if we have `CI_ENV`on our system
(in this case, via Docker Environment Variable, `.env.development`), it values
will be used instead.

If you want to switch the docker's env, you can do that on the file instead.

**WARN:** `.htaccess` should be left untouched IF it's on Git watch.

If you're on Windows and wanted to use the XAMPP, you can also do that by
editing your Environment Table (Refs:
[Superuser](https://superuser.com/a/949577), [Windows Dev
Center](https://docs.microsoft.com/en-us/windows/win32/procthread/environment-variables),
[Microsoft
Support](https://support.microsoft.com/en-us/help/310519/how-to-manage-environment-variables-in-windows-xp)).

On production server, you should always export `CI_ENV` as `production`.

### Container Image Specification

This section is intended to give more information with our PHP & Apache stacks.
Hopefully this will give non-docker users more information on "Why on x machine
it works, but not on mine?" and *vice-versa*.

The Docker Image are made to mainly accommodate the CodeIgniter 3 and 4 needs.
As our techstack matures, we'll maintain the container image so that we can ship
software much faster and less painful.

In this section there's two main specification: Apache and PHP. Apache is our
main web server for now, where most Web Hosting (and several of our fleet) uses
Apache.

Additionally, we add extra information that don't actually fit to other category
but actually very critical to not be documented.

#### Apache

Apache Mods used:
- `rewrite` \
  Required by CodeIgniter 3 & 4, and most web frameworks. CodeIgniter 3 and 4 do
  actually support `rewrite`less mod, but the url will look something like
  `/index.php/welcome`. \
  **Mandatory**.

- `headers` \
  Used to add headers to HTTP Header. The main usecase is to add `Cache-control`
  headers when accessing `/assets/` folder. To see more information on this,
  please see following discussions:

  - [PNDevworks/Templates/DockerAddOn#2](https://gl.dnartworks.co.id/PNDevworks/Templates/DockerAddOn/-/issues/2)
  - [PNDevworks/Templates/CodeIgniter4#2](https://gl.dnartworks.co.id/PNDevworks/Templates/CodeIgniter4/-/issues/2)
  - [PNDevworks/NewVespa#333](https://gl.dnartworks.co.id/PNDevworks/NewVespa/-/issues/333)

#### PHP

PHP Plugins, Mods and Settings included:

We use PHP that are not dead (did not reach EOL), but are
[configurable](#selecting-php-version).

- `pdo`, `pdo_mysql`, `mysqli` \
  Used to connect with Database. Most frameworks uses `pdo` and
  `pbo_[db-driver-name-here]`. \
  **Mandatory.**

- `zip` \
  Required by Composer, especially if you want to use Composer inside the image.
  If not, then you can ignore this.

- `intl` \
  Required by CodeIgniter 4. \
  **Mandatory.**

- `gd` \
  Required by AdminPanel's auto-resize feature. See
  [PNDevworks/deps/admin-panel#10](https://gl.dnartworks.co.id/PNDevworks/deps/admin-panel/-/issues/10). \
  If you don't use this feature, you can opt-out to include this on the image.
  We're adding this to be main image to make the feature works out-of-the-box.

#### Stack Configuration

For CodeIgniter 4, our `APACHE_DOCUMENT_ROOT` should be set to `public` folder
of the project. This will prevent access to `vendor` folder on the top, lowering
the attach surface. This is the default behavior.

#### Users

In the image, we create extra user to prevent running things in `root` mode,
even in docker image. This will increase the security of the image. The
installed user supports sudo, but will run in normal permission by default.
