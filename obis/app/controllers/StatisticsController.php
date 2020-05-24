<?php

    class StatisticsController extends Controller {

        public function index() {
            $this->view('statistics' . DIRECTORY_SEPARATOR . 'index');
        }
        
    }