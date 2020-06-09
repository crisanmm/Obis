<?php

use \Firebase\JWT\JWT;

class AccountController extends Controller {
    
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
        if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) &&
           $_POST['firstname'] !== "" && $_POST['lastname'] !== "" && $_POST['email'] !== "" && $_POST['password'] !== "") {
            if(!User::exists($_POST['email'])) {
                $user = new User($_POST['firstname'],
                                $_POST['lastname'],
                                $_POST['email'],
                                $_POST['password']);
                $user->create();

                $this->view('account' . DIRECTORY_SEPARATOR . 'login');
                exit();
            }
        }

        $this->view('account' . DIRECTORY_SEPARATOR . 'register', ["registerFailed" => true]);
    }
    
    /**
     * Render user page
     */
    public function user() {
        if(isset($_SESSION['firstname'])) {
            $formSent = false;
            $changeIsSuccessful = false;
            if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) &&
               $_POST['firstname'] !== "" && $_POST['lastname'] !== "" && $_POST['email'] !== "") {
                $formSent = true;
                if(User::updateData($_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['email'],
                                    $_POST['firstname'], $_POST['lastname'], $_POST['email'])) {
                    $changeIsSuccessful = true;
                }
            }
            $this->view('account' . DIRECTORY_SEPARATOR . 'adminpanel', ['formSent' => $formSent,
                                                                         'changeIsSuccessful' => $changeIsSuccessful]);
        } else {
            $this->view('account' . DIRECTORY_SEPARATOR . 'login');
        }
    }
    
    /**
     * Perform login action
     */
    public function login() {
        $user = User::login($_POST['email'],
                            $_POST['password']);

        if($user !== false) {
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['lastname'] = $user->getLastname();
            $_SESSION['email'] = $user->getEmail();
            
            $secret_key = "V98kn1KPjS939rPubLEuU32TQrN8CmL666saLeGA8vtX6BBh7qwlDu12Aa3n997P";
            $issuer_claim = "obis"; 
            $audience_claim = "obis_rest_api_users";
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
            // echo $jwt;
            $this->view('account' . DIRECTORY_SEPARATOR . 'adminpanel', ["jwt" => $jwt]);
            return;
        }
        
        $this->view('account' . DIRECTORY_SEPARATOR . 'login', ["loginFailed" => true]);
    }

}