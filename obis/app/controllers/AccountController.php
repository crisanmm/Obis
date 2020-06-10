<?php

use \Firebase\JWT\JWT;

function getJWT($user) {
    $secret_key = "V98kn1KPjS939rPubLEuU32TQrN8CmL666saLeGA8vtX6BBh7qwlDu12Aa3n997P";
    $issuer_claim = "obis";
    $audience_claim = "obis_rest_api_users";
    $issuedat_claim = time();
    $notbefore_claim = $issuedat_claim;
    $expire_claim = $issuedat_claim + 600000000;

    $token = [
        "iss" => $issuer_claim,
        "aud" => $audience_claim,
        "iat" => $issuedat_claim,
        "nbf" => $notbefore_claim,
        "exp" => $expire_claim,
        "data" => ["firstname" => $user -> getFirstname(),
                    "lastname" => $user -> getLastname(),
                    "email" => $user -> getEmail()]];

    $jwt = JWT::encode($token, $secret_key);
    return $jwt;
}

class AccountController extends Controller {
    
    /**
     * Render register page
     */
    public function register() {
        $registerFailed = true;
        
        // if the form has been submitted 
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // and the input is not made up of empty strings
            if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password']) &&
               $_POST['firstname'] !== "" && $_POST['lastname'] !== "" && $_POST['email'] !== "" && $_POST['password'] !== "" && $_POST['confirm-password'] !== "") {
                // check if password & confirmpassword are the same
                if($_POST['password'] === $_POST['confirm-password']) {
                    // if user doesn't already exist then create new user
                    if(!User::exists($_POST['email'])) {
                        $user = new User($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['confirm-password']);
                        if($user->create()) {
                            // $this->view('account' . DIRECTORY_SEPARATOR . 'login');
                            header("Location: /obis/account/login");
                            exit();
                        }
                    }
                }
            }
        } else { // $_SERVER['REQUEST_METHOD'] != 'POST'
            $registerFailed = false;
        }
        $this->view('account' . DIRECTORY_SEPARATOR . 'register', ['registerFailed' => $registerFailed]);
    }

    /**
     * Render login page
     */
    public function login() {
        $loginFailed = true;

        // if the form has been submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // and the input is not made up of empty strings
            if(isset($_POST['email']) && isset($_POST['password']) && $_POST['email'] !== "" && $_POST['password'] !== "") {
                $user = User::login($_POST['email'], $_POST['password']);
                if($user !== false) {
                    $_SESSION['firstname'] = $user->getFirstname();
                    $_SESSION['lastname'] = $user->getLastname();
                    $_SESSION['email'] = $user->getEmail();
                    
                    $jwt = getJWT($user);
                    $this->panel($jwt);
                    return;
                }
            }
        } else {
            $loginFailed = false;
        }
        
        $this->view('account'. DIRECTORY_SEPARATOR . 'login', ['loginFailed' => $loginFailed]);
    }
    
    /**
     * Render panel page
     */
    public function panel($optionalJWT = null) {
        // if user is not logged in redirect to /obis/account/user
        if(!isset($_SESSION['firstname'])) {
            header("Location: /obis/account/user");
            exit();
        }
        $this->view('account' . DIRECTORY_SEPARATOR . 'panel', ['jwt' => $optionalJWT]);
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
            $this->view('account' . DIRECTORY_SEPARATOR . 'panel', ['formSent' => $formSent,
                                                                    'changeIsSuccessful' => $changeIsSuccessful]);
        } else {
            header("Location: /obis/account/login");
            exit();
        }
    }

    /**
     * Perform log out action
     */
    public function logout() {
        // check if session is really set
        if(isset($_SESSION['firstname'])) {
            unset($_SESSION);
            session_destroy();
        }
        header("Location: /obis/home/home");
        exit();
    }
    
}