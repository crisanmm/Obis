<?php

    session_start();
    // print_r($_SESSION);
    // session_destroy();

    require_once 'app' . DIRECTORY_SEPARATOR . 'init.php';
    
    new App;

    // phpinfo();
    // Database::getConnection();
    // (new Database)->getConnection();