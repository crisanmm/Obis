<?php
    
    class HomeController extends Controller {

        /**
         * "Home" page
         */
        public function index() {
            // $user = $this->model('User');
            // $user->name = 'john';

            $this->view('home' . DIRECTORY_SEPARATOR . 'index', array('no' => 'yes'));
        }
        
        /**
         * "About us" page  
         */
        public function aboutus() {
            $this->view('home' . DIRECTORY_SEPARATOR . 'aboutus', []);
        }
        
        /**
         * "Contact" page
         */
        public function contact() {
            $this->view('home' . DIRECTORY_SEPARATOR . 'contact', []);
        }

    }