<?php

namespace PNDevworks\AdminPanel\Helpers;

use CodeIgniter\Exceptions\ExceptionInterface;
use RuntimeException;
use Throwable;

if (!function_exists('isExceptionForwardable')) {
    /**
     * Decide if certain exception can be forwarded to Framework or not,
     * depending of environment, type, and settings.
     * 
     * Settings: {@see \PNDevworks\AdminPanel\Config\AdminPanel::$debugForwardExceptionToFramework}.
     *
     * @param Throwable $e Exception to be thrown
     * @return bool
     */
    function isExceptionForwardable(Throwable $e): bool
    {
        if (array_key_exists('CI_ENVIRONMENT', $_ENV) && $_ENV['CI_ENVIRONMENT'] !== 'development') {
            return false;
        }

        
        $allowForward = config('AdminPanel')->debugForwardExceptionToFramework;
        if (!$allowForward) {
            return false;
        }

        if($e instanceof ExceptionInterface) {
            // ExceptionInterface are from CodeIgniter, and are already
            // Framework-based interface. We should be able to just forward
            // this.
            return true;
        }

        if ($e instanceof RuntimeException) {
            return false;
        }

        return true;
    }
}

if (!function_exists('adminDebugAutoForwardException')) {
    /**
     * Helps throw the exception for debugging purposes.
     *
     * Details of which exception to be thrown can be checked on
     * {@see isExceptionForwardable}.
     *
     * @param Throwable $e Exception to be thrown
     * @return void
     */
    function adminDebugAutoForwardException(Throwable $e): void
    {
        if (isExceptionForwardable($e)) {
            throw $e;
        }
    }
}
