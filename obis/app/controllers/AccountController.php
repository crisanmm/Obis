<?php

    class AccountController extends Controller {

        /**
         * Render default page
         */
        public function index() {
            // user account view
            // or 
            // register view
            // based on state
            $this->view('account' . DIRECTORY_SEPARATOR . 'login');
        }
        
        /**
         * Render register page
         */
        public function register() {
            $this->view('account' . DIRECTORY_SEPARATOR . 'register');
        }

        /**
         * Perform register action
         */
        public function registerAction() {
            $user = new User($_POST['firstname'],
                             $_POST['lastname'],
                             $_POST['email'],
                             $_POST['password']);

            $userExists = $user->exists();

            if(!$userExists)
                $user->create();

            $this->view('account' . DIRECTORY_SEPARATOR . 'register', ["userExists" => $userExists]);
        }
        
        /**
         * Render login page
         */
        public function login() {
            $this->view('account' . DIRECTORY_SEPARATOR . 'login');
        }
        
        /**
         * Perform login action
         */
        public function loginAction() {
            $user = User::login($_POST['email'],
                                $_POST['password']);

            $userIsLoggedIn = true;
            if($user === false)
                $userIsLoggedIn = false;

            $this->view('account' . DIRECTORY_SEPARATOR . 'login', ["user" => $user,
                                                                    "userIsLoggedIn" => $userIsLoggedIn]);
        }

    }