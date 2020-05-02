<?php
    
    // autoloader
    spl_autoload_register('myAutoloader');
    
    function myAutoloader($className) {

        $appDir = 'app' . DIRECTORY_SEPARATOR;
        
        if(file_exists($appDir . 'controllers' . DIRECTORY_SEPARATOR . "$className.php")) {
            include_once $appDir . 'controllers' . DIRECTORY_SEPARATOR . "$className.php";
        } else if(file_exists($appDir . 'core' . DIRECTORY_SEPARATOR . "$className.php")) {
            include_once $appDir . 'core' . DIRECTORY_SEPARATOR . "$className.php";
        } else if(file_exists($appDir . 'models' . DIRECTORY_SEPARATOR . "$className.php")) {
            include_once $appDir . 'models' . DIRECTORY_SEPARATOR . "$className.php";
        }

    }
