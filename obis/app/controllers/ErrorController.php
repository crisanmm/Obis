<?php

class ErrorController extends Controller {

    /**
     * Render error page
     */
    public function error() {
        http_response_code(404);
        $this->view('error' . DIRECTORY_SEPARATOR . 'error');
    }

}