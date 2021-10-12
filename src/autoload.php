<?php

/**
 * Paystack Autoloader
 * For use when library is being used without composer
 */

$weimob_autoloader = function ($class_name) {
    if (strpos($class_name, 'Kiduc\Weimob')===0) {
        $file = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $file .= str_replace([ 'Kiduc\\', '\\' ], ['', DIRECTORY_SEPARATOR ], $class_name) . '.php';
        include_once $file;
    }
};

spl_autoload_register($weimob_autoloader);

return $weimob_autoloader;
