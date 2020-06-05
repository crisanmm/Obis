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
        if(isset($_POST['name']) &&
           isset($_POST['email']) &&
           isset($_POST['message'])) {
            $name = strip_tags($_POST['name']);
            $email = strip_tags($_POST['email']);
            $message = strip_tags($_POST['message']);
            (new ContactMessage())->storeMessage($name, $email, $message);
        }
        
        $this->view('home' . DIRECTORY_SEPARATOR . 'contact');
    }

}