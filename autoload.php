<?php

spl_autoload_register(function($className) {
    $prefix = 'Igorw\\Ilias\\';
    if (strncmp($prefix, $className, strlen($prefix)) !== 0) {
        return;
    }
    $file = __DIR__.'/src/'.str_replace('\\', '/', substr($className, strlen($prefix))).'.php';
    require $file;
});
