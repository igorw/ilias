<?php

spl_autoload_register(function ($className) {
    $basePath = __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR;
    $classPrefix = 'Igorw\\Ilias';
    if (null === $classPrefix || 0 !== strpos($className, $classPrefix)) {
        return;
    }

    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    if (null !== $classPrefix) {
        $transformedClassPrefix = ('\\' === substr($classPrefix, -1)) ? $classPrefix : $classPrefix.'\\';
        $transformedClassPrefix = str_replace('\\', DIRECTORY_SEPARATOR, $transformedClassPrefix);
        if (0 === strpos($fileName, $transformedClassPrefix)) {
            $fileName = substr($fileName, strlen($transformedClassPrefix));
        }
    }

    require $basePath.$fileName;
});
