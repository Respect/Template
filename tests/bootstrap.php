<?php
define('PS', PATH_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);

date_default_timezone_set('UTC');
set_include_path('../library' . PS . __DIR__ . PS . get_include_path());
error_reporting(-1);

/**
 * Autoloader that implements the PSR-0 spec for interoperability between
 * PHP software.
 */
spl_autoload_register(
    function($className) {
        $fileParts = explode('\\', ltrim($className, '\\'));

        if (false !== strpos(end($fileParts), '_'))
            array_splice($fileParts, -1, 1, explode('_', current($fileParts)));

        $file = implode(DS, $fileParts) . '.php';

        foreach (explode(PS, get_include_path()) as $path) {
            if (file_exists($path = $path . DS . $file))
                return require $path;
        }
    }
);
