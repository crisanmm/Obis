<?php 

    class App {

        protected $controller = 'HomeController';
        protected $method = 'index';
        protected $params = [];

        public function parseUrl() {
            if(isset($_GET['url'])) {
                $filteredUrl = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
                return $url = explode('/', $filteredUrl);
            }
        }
        
        public function __construct() {
            // process URL
            $url = $this->parseUrl();

            // if controller has been specified then set it
            if(isset($url[0])) {
                $controllerName = ucfirst($url[0]) . 'Controller';
                if(file_exists('app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . "$controllerName.php")) {
                    $this->controller = $controllerName;
                    unset($url[0]);
                }
            }
            $this->controller = new $this->controller;
            
            // if method has been specified then set it
            if(isset($url[1])) {
                if(method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }
            
            // set parameters
            $this->params = $url ? array_values($url) : [];
            // $this->controller->{$this->method}($this->params); 
            call_user_func_array([$this->controller, $this->method], $this->params);
        }
        
    }