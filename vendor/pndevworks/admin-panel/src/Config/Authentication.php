<?php

namespace PNDevworks\AdminPanel\Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Admin Panel Authentication configuration.
 * 
 * This will helps limit and setting up the authentication parameters.
 */
class Authentication extends BaseConfig
{

    /**
     * Allow users with account on the site, resets their own password.
     * Currently this settings are unusable :) due to lacks of implementation.
     *
     * @var boolean
     */
    public $allowSelfResetPassword = false;

    /**
     * Sets the password hashing algorihm. Because we prefer one that are
     * provided from PHP, this settings are only set with supported password
     * hashing algoritm from the Predefined Password Constants.
     *
     * Default sets to PASSWORD_ARGON2ID, learn the details on issue
     * {@link https://gitlab.com/PNDevworks/deps/admin-panel/-/issues/18 PNDevworks/deps/admin-panel#18}
     *
     * @link https://www.php.net/manual/en/password.constants.php Predefined
     * Password Constants.
     * @link https://www.php.net/manual/en/function.password-hash.php
     * `password_hash` Documentation.
     *
     * @var String
     */
    public $passwordAlgorithm = PASSWORD_ARGON2ID;


    /**
     * Some password algorithm have some parameters that we can set and tune in
     * by our self. This variable are those parameters. This will be supplied to
     * the `password_hash` function.
     *
     * @link https://www.php.net/manual/en/function.password-hash.php
     * `password_hash` Documentation
     *
     * @var array
     */
    public $passwordAlgorithmParams = [];

    /**
     * Sets the X-Robot HTTP headers to "noindex, nofollow, noarchive" to
     * prevent search engine indexes the login page of our admin panel. This
     * measure will help reduce the login page discovery by just Googling the
     * page. Defaults to on, becase most cases, we want the admin panel to be
     * hidden from public view.
     *
     * @see \PNDevworks\AdminPanel\Controllers\User::get_login()
     *
     * @var boolean
     */
    public $discourageRobotIndexLoginPage = true;
}
