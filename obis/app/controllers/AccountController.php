<?php

    use \Firebase\JWT\JWT;

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

            if($userIsLoggedIn) {
                $secret_key = "test_key";
                $issuer_claim = "obis"; 
                $audience_claim = "test_audience";
                $issuedat_claim = time(); 
                $notbefore_claim = $issuedat_claim + 10; 
                $expire_claim = $issuedat_claim + 600000000; 
                
                $token = array(
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "firstname" => $user -> getFirstname(),
                        "lastname" => $user -> getLastname(),
                        "email" => $user -> getEmail()
                ));

                $jwt = JWT::encode($token, $secret_key);
            }
            echo $jwt;
            
            $this->view('home' . DIRECTORY_SEPARATOR . 'index', ["user" => $user,
                                                                "userIsLoggedIn" => $userIsLoggedIn,
                                                                "jwt" => $jwt]);
        }

    }