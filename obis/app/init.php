<?php

    $librariesDir = 'app' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR;
    include_once $librariesDir . 'JWT' . DIRECTORY_SEPARATOR . 'BeforeValidException.php';
    include_once $librariesDir . 'JWT' . DIRECTORY_SEPARATOR . 'ExpiredException.php';
    include_once $librariesDir . 'JWT' . DIRECTORY_SEPARATOR . 'JWK.php';
    include_once $librariesDir . 'JWT' . DIRECTORY_SEPARATOR . 'JWT.php';
    include_once $librariesDir . 'JWT' . DIRECTORY_SEPARATOR . 'SignatureInvalidException.php';

    // autoloading
    spl_autoload_register('myAutoloader');

    function myAutoloader($className) {

        $appDir = 'app' . DIRECTORY_SEPARATOR;
        $controllersDir = 'controllers' . DIRECTORY_SEPARATOR;
        $coreDir = 'core' . DIRECTORY_SEPARATOR;
        $modelsDir = 'models' . DIRECTORY_SEPARATOR;
        
        if(file_exists($appDir . $controllersDir . "$className.php")) {
            include_once $appDir . $controllersDir . "$className.php";
        } else if(file_exists($appDir . $coreDir . "$className.php")) {
            include_once $appDir . $coreDir . "$className.php";
        } else if(file_exists($appDir . $modelsDir . "$className.php")) {
            include_once $appDir . $modelsDir . "$className.php";
        }

    }
