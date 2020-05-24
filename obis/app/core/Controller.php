<?php

abstract class Controller {

    public function model($model) {
        require_once 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "$model.php";
        return new $model;
    }
    
    /**
     * Render view
     * 
     * @param string view The name of the view to render.
     * @param array data An associative array used for passing values to the view,
     *                   the values will be extracted into the symbol table.
     */
    public function view($view, $data = []) {
        // extract data into symbol table from associative array
        extract($data);
        // show view
        require_once 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . "$view.phtml";
    }
    
}   