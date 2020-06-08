<?php

    session_start();

    require_once 'app' . DIRECTORY_SEPARATOR . 'init.php';
    
    new App;

    // phpinfo();
    // Database::getConnection();
    // (new Database)->getConnection();