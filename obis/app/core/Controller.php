<?php

    abstract class Controller {
     
        public function model($model) {
            require_once 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "$model.php";
            return new $model;
        }
        
        public function view($view, $data = []) {

            // extract data into symbol table from associative array
            extract($data);
            // show view
            require_once 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . "$view.tpl";
            
        }
        
    }