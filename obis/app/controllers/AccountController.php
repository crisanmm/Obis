<?php

    class AccountController extends Controller {

        public function index() {
            // user account view
            // or 
            // register view
            // based on state
            // $this->view('account/register', []);
        }
        
        public function register() {
            $this->view('account' . DIRECTORY_SEPARATOR . 'register', []);
        }
        
    }