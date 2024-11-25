<?php

namespace PNDevworks\AdminPanel\Config;

use Config\Filters;
use PNDevworks\AdminPanel\Filters\Auth;

/**
 * @var Filters $filters
 */
$filters->aliases['pnd_auth'] = Auth::class;
