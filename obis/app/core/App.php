<?php 

/**
 * The following structure is used:
 * obis/{controller}/{method}?{params}
 */
class App {

    /**
     * @var $controller The current controller
     */
    protected $controller = null;
    protected $method = null;
    protected $params = [];
    
    public function __construct() {
        // process URL
        $url = $this->parseUrl();

        // if controller has been specified then set it
        if(isset($url[0])) {
            $this->controller = ucfirst(strtolower($url[0])) . 'Controller';
            unset($url[0]);
            // $controllerName = ucfirst($url[0]) . 'Controller';
            // if(file_exists('app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . "$controllerName.php")) {
            //     $this->controller = $controllerName;
            //     unset($url[0]);
            // }
        }
        // $this->controller = new $this->controller;
        
        // if method has been specified then set it
        if(isset($url[1])) {
            $this->method = strtolower($url[1]);
            unset($url[1]);
            // if(method_exists($this->controller, $url[1])) {
            //     $this->method = $url[1];
            //     unset($url[1]);
            // }
        }
        
        // echo "<br>";
        // echo $this->controller;
        // echo "<br>";
        // echo $this->method;
        // echo "<br>";
        $this->processControllerMethod($this->controller, $this->method);
        
        // set parameters
        $this->params = $url ? array_values($url) : [];
        // $this->controller->{$this->method}($this->params); 
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    private function parseUrl() {
        if(isset($_GET['url'])) {
            $filteredUrl = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
            return $url = explode('/', $filteredUrl);
        }
    }
    
    private function processControllerMethod(&$controller, &$method) {
        if(file_exists('app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . "$controller.php")) {
            $controller = new $controller;
            if(method_exists($controller, $method))
                return;
        }
        $controller = new ErrorController();
        $method = "error";
    }
    
}