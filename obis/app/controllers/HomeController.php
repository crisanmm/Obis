<?php
    
    class HomeController extends Controller {

        /**
         * Render default page
         */
        public function index() {
            // $user = $this->model('User');
            // $user->name = 'john';
            $this->view('home' . DIRECTORY_SEPARATOR . 'index', array('no' => 'yes'));
        }
        
        /**
         * Render about us page  
         */
        public function aboutus() {
            $this->view('home' . DIRECTORY_SEPARATOR . 'aboutus');
        }
        
        /**
         * Render contact page
         */
        public function contact() {
            $this->view('home' . DIRECTORY_SEPARATOR . 'contact');
        }

    }