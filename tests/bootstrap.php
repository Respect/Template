<?php
set_error_handler(function () {
  echo file_get_contents(dirname(__DIR__).'/INSTALL');
  exit(1);
}, E_ALL);

require_once dirname(__DIR__) . '/vendor/autoload.php';

restore_error_handler();

/* Timezone */
date_default_timezone_set('UTC');

/**
 * Autoloader that implements the PSR-0 spec for interoperability between
 * PHP software.
 */
if (!@include __DIR__ . '/../vendor/autoload.php') {

    /* Include path */
    set_include_path(implode(PATH_SEPARATOR, array(
        __DIR__ . '/../src',
        get_include_path(),
    )));

    /* PEAR autoloader */
    spl_autoload_register(
        function($className) {
            $filename = strtr($className, '\\', DIRECTORY_SEPARATOR) . '.php';
            foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
                $path .= DIRECTORY_SEPARATOR . $filename;
                if (is_file($path)) {
                    require_once $path;
                    return true;
                }
            }
            return false;
        }
    );
}