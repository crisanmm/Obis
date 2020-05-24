<?php 

use \Firebase\JWT\JWT;

class ApiController extends Controller{

    private $answerGateway;

    public function __construct()
    {
        $this->answerGateway = new AnswerGateway();
        
    }

    public function checkJWT()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        $arr = explode(" ", $authHeader);
        $jwt = $arr[1];
        $secret_key = "test_key";

        if($jwt)
        {
            try {
                $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
                return true;
            }catch (Exception $e){

            http_response_code(401);
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
            }

        }
    }

    public function answers($first = NULL,$second = NULL, $third = NULL, $fourth = NULL)
    {

        if($this->checkJWT())
        {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->badRequest();

            if($first == NULL)
            {
                if($requestMethod == "GET")
                {
                    $result = $this->answerGateway->getAllBmi();
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                }

                if($requestMethod == "POST")
                {
                    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                    
                    if($this->answerGateway->validateInputBmi($input))
                    {
                        $this->answerGateway->insertBmi($input);

                        $response['status_code_header'] = 'HTTP/1.1 201 Created';
                        $response['body'] = file_get_contents('php://input');
                    }
                    else
                    {
                        $response = $this->unprocessableEntityResponse();
                    }
                }
            }else
            if($second == NULL and is_numeric($first))
            {
                if($requestMethod == "GET")
                {
                    $result = $this->answerGateway->getBmiWithID($first);
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                }

                if($requestMethod == "PUT")
                {
                    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                    
                    if($this->answerGateway->validateInputBmi($input))
                    {
                        $this->answerGateway->updateBmi($first,$input);

                        $response['status_code_header'] = 'HTTP/1.1 200 OK';
                        $response['body'] = file_get_contents('php://input');
                    }
                    else
                    {
                        $response = $this->unprocessableEntityResponse();
                    }
                }

                if($requestMethod == "DELETE")
                {
                    $this->answerGateway->deleteBmi($first);
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = null;
                }
            }else
            if($third == NULL)
            {
                if($requestMethod == "GET")
                {
                    if($first == "location")
                    {
                        $result = $this->answerGateway->getBmiWithLocation($second);

                        $response['status_code_header'] = 'HTTP/1.1 200 OK';
                        $response['body'] = json_encode($result);
                    }     
                    if($first == "year")
                    {
                        $result = $this->answerGateway->getBmiWithYear($second);

                        $response['status_code_header'] = 'HTTP/1.1 200 OK';
                        $response['body'] = json_encode($result);
                    }                   
                }
            }else
            if($first == "location" and $third == "year")
            {
                $result = $this->answerGateway->getBmiWithYearLocation($fourth,$second);

                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['body'] = json_encode($result);
            }

            header($response['status_code_header']);
            echo $response['body'];
        }

        $this->view('api' . DIRECTORY_SEPARATOR . 'index');        
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    private function badRequest()
    {
        $response['status_code_header'] = 'HTTP/1.1 405 Method Not Allowed';
        $response['body'] = null;
        return $response;
    }

    public function locations($first = NULL)
    {
        if($this->checkJWT())
        {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->badRequest();
    
            if($first == NULL)
            {
                if($requestMethod == "GET")
                {
                    $result = $this->answerGateway->getAllLocations();
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                }

                if($requestMethod == "POST")
                {
                    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                    
                    if($this->answerGateway->validateInputLocations($input))
                    {
                        $this->answerGateway->insertLocations($input);

                        $response['status_code_header'] = 'HTTP/1.1 201 Created';
                        $response['body'] = file_get_contents('php://input');
                    }
                    else
                    {
                        $response = $this->unprocessableEntityResponse();
                    }
                }

            }else
            {
                if($requestMethod == "GET")
                {
                    $result = $this->answerGateway->getLocationWithID($first);
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                }

                if($requestMethod == "PUT")
                {
                    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                    
                    if($this->answerGateway->validateInputLocations($input))
                    {
                        $this->answerGateway->updateLocations($first,$input);

                        $response['status_code_header'] = 'HTTP/1.1 200 OK';
                        $response['body'] = file_get_contents('php://input');
                    }
                    else
                    {
                        $response = $this->unprocessableEntityResponse();
                    }
                }
                if($requestMethod == "DELETE")
                {
                    $this->answerGateway->deleteLocation($first);
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = null;
                }
            }

            header($response['status_code_header']);
            echo $response['body'];
        }

        $this->view('api' . DIRECTORY_SEPARATOR . 'index');
    }

    public function breakouts($first = NULL)
    {
        if($this->checkJWT())
        {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->badRequest();
    
            if($first == NULL)
            {
                if($requestMethod == "GET")
                {
                    $result = $this->answerGateway->getAllBreakouts();
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                }

                if($requestMethod == "POST")
                {
                    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                    
                    if($this->answerGateway->validateInputBreakouts($input))
                    {
                        $this->answerGateway->insertBreakouts($input);

                        $response['status_code_header'] = 'HTTP/1.1 201 Created';
                        $response['body'] = file_get_contents('php://input');
                    }
                    else
                    {
                        $response = $this->unprocessableEntityResponse();
                    }
                }

            }else
            {
                if($requestMethod == "GET")
                {
                    $result = $this->answerGateway->getBreakoutWithID($first);
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                }

                if($requestMethod == "PUT")
                {
                    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                    
                    if($this->answerGateway->validateInputBreakouts($input))
                    {
                        $this->answerGateway->updateBreakout($first,$input);

                        $response['status_code_header'] = 'HTTP/1.1 200 OK';
                        $response['body'] = file_get_contents('php://input');
                    }
                    else
                    {
                        $response = $this->unprocessableEntityResponse();
                    }
                }
                if($requestMethod == "DELETE")
                {
                    $this->answerGateway->deleteBreakout($first);
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = null;
                }
            }

            header($response['status_code_header']);
            echo $response['body'];
        }

        $this->view('api' . DIRECTORY_SEPARATOR . 'index');
    }

    public function breakout_categories($first = NULL)
    {
        if($this->checkJWT())
        {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->badRequest();
    
            if($first == NULL)
            {
                if($requestMethod == "GET")
                {
                    $result = $this->answerGateway->getAllBreakoutsCat();
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                }

                if($requestMethod == "POST")
                {
                    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                    
                    if($this->answerGateway->validateInputBreakoutsCat($input))
                    {
                        $this->answerGateway->insertBreakoutsCat($input);

                        $response['status_code_header'] = 'HTTP/1.1 201 Created';
                        $response['body'] = file_get_contents('php://input');
                    }
                    else
                    {
                        $response = $this->unprocessableEntityResponse();
                    }
                }

            }else
            {
                if($requestMethod == "GET")
                {
                    $result = $this->answerGateway->getBreakoutWithIDCat($first);
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                }

                if($requestMethod == "PUT")
                {
                    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                    
                    if($this->answerGateway->validateInputBreakoutsCat($input))
                    {
                        $this->answerGateway->updateBreakoutCat($first,$input);

                        $response['status_code_header'] = 'HTTP/1.1 200 OK';
                        $response['body'] = file_get_contents('php://input');
                    }
                    else
                    {
                        $response = $this->unprocessableEntityResponse();
                    }
                }
                if($requestMethod == "DELETE")
                {
                    $this->answerGateway->deleteBreakoutCat($first);
                    
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = null;
                }
            }

            header($response['status_code_header']);
            echo $response['body'];
        }

        $this->view('api' . DIRECTORY_SEPARATOR . 'index');
    }
}