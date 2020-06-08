<?php

class HomeController extends Controller {

    /**
     * Render home page
     */
    public function home() {
        $this->view('home' . DIRECTORY_SEPARATOR . 'home');
    }
    
    /**
     * Render statistics page
     */
    public function statistics() {
        $model = new StatisticsModel();
        $yearsArray = $model->getYearsArray();
        $statesArray = $model->getStatesArray();

        $this->view('home' . DIRECTORY_SEPARATOR . 'statistics', ["yearsArray" => $yearsArray,
                                                                  "statesArray" => $statesArray]);
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