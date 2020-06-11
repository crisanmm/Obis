<?php

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

$error = "";

function isValidJWT() {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    global $error;
    if(isset($authHeader) && $authHeader !== "") {
        $arr = explode(" ", $authHeader);
        $jwt = $arr[1];
        $secret_key = "V98kn1KPjS939rPubLEuU32TQrN8CmL666saLeGA8vtX6BBh7qwlDu12Aa3n997P";
        
        if(isset($jwt)) {
            try {
                JWT::decode($jwt, $secret_key, ['HS256']);
                return true;
            } catch(UnexpectedValueException $e) {
                $error = "Provided JWT was invalid. " . $e->getMessage();
            } catch(SignatureInvalidException $e) {
                $error = "Provided JWT was invalid because the signature verification failed. " . $e->getMessage();
            } catch(BeforeValidException $e) {
                $error = "Provided JWT is trying to be used before it's eligible as defined by 'nbf'. " . $e->getMessage();
            } catch(ExpiredException $e) {
                $error = "Provided JWT has since expired, as defined by the 'exp' claim. " . $e->getMessage();
            } catch(Exception $e) {
                $error = $e->getMessage();
            }
        }
    } else {
        $error = "No authorization header provided.";
        return false;
    }
}

/**
 * REST API controller.
 */
class ApiController extends Controller {

    private static $answerGateway = null;

    public function __construct() {
        if(self::$answerGateway === null)
            self::$answerGateway = new AnswerGateway();
    }

    /**
     * Handles the following endpoints:
     * /answers/
     * /answers/{id}
     * /answers/location/{location}
     * /answers/year/{year}
     * /answers/location/{location}/year/{year}
     */
    public function answers($first = NULL, $second = NULL, $third = NULL, $fourth = NULL) {
        if(isValidJWT() === true) {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->notFoundResponse();
            
            if($first === NULL) {
                // requested resource is /answers
                switch($requestMethod) {
                    case "GET":
                        $params = $_GET;
                        $params_string = $this->prepareParams($params);
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getAllBmi($params_string));
                    break;
                    
                    case "POST":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->IsValidInputBmi($input)) {
                            self::$answerGateway->insertBmi($input);
                            http_response_code(201);
                            $response = json_encode(self::$answerGateway->getLastBmi());
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;
                    
                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, POST");
                }
            } else if($second === NULL and is_numeric($first)) { 
                // requested resource is /answers/{id}
                // $first is {id}
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $params = $_GET;
                        $params_string = $this->prepareParams($params);
                        $response = json_encode(self::$answerGateway->getBmiWithID($first, $params_string));
                    break;
                    
                    case "PUT":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->IsValidInputBmi($input)) {
                            self::$answerGateway->updateBmi($first, $input);
                            $response = $this->updatedResponse();
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;
                    
                    case "PATCH":
                        // to do?
                    break;
                    
                    case "DELETE":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getBmiWithID($first, NULL));
                        self::$answerGateway->deleteBmi($first);
                    break;

                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, PUT, PATCH, DELETE");
                }
            } else if($third === NULL) {
                // requested resource is 
                // /answers/locations/{location}
                // or
                // /answers/year/{year}
                switch($requestMethod) {
                    case "GET":
                        switch(strtolower($first)) {
                            case "location":
                                // requested resource is /answers/location/{location}
                                // $first is "location"
                                // $second is {location}
                                $params = $_GET;
                                $params_string = $this->prepareParams($params);
                                http_response_code(200);
                                if(isset($second)) 
                                    $response = json_encode(self::$answerGateway->getBmiWithLocation($second, $params_string));
                                else
                                    $response = $this->badRequestResponse("Resource not specified.");
                            break;
                            
                            case "year":
                                // requested resource is /answers/year/{year}
                                // $first is "year"
                                // $second is {year}
                                http_response_code(200);
                                if(isset($second)){
                                    $params = $_GET;
                                    $params_string = $this->prepareParams($params);
                                    $response = json_encode(self::$answerGateway->getBmiWithYear($second, $params_string));
                                }
                                else
                                    $response = $this->badRequestResponse("Resource not specified.");
                            break;
                                
                            default:
                                $response = $this->notFoundResponse();
                        }
                    break;

                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET");
                }
            } else if($first == "location" and $third == "year") {
                // requested resource is /answers/location/{location}/year/{year}
                // $first is "location"
                // $second is {location}
                // $third is "year"
                // $fourth is {year}
                switch($requestMethod) {
                    case "GET":
                        $params = $_GET;
                        $params_string = $this->prepareParams($params);
                        http_response_code(200);
                        if(!isset($second) || !isset($fourth))
                            $response = $this->badRequestResponse("Resources not specified.");
                        else
                            $response = json_encode($result = self::$answerGateway->getBmiWithYearLocation($fourth, $second, $params_string));
                    break;

                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET");
                }
            }

            // header($response['status_code_header']);
            // echo $response['body'];
        } else {
            $response = $this->failedAuthResponse();
        }
        
        $this->view('api' . DIRECTORY_SEPARATOR . 'index', ["response" => $response]);
    }

    /**
     * Handles the following endpoints:
     * /api/locations
     * /api/locations/{location}
     * 
     * @param string $first `NULL`, if queried endpoint is /api/locations.
     * 
     *                      {location}, if queried endpoint is /api/locations/{location}
     */
    public function locations($first = NULL) {
        if(isValidJWT()) {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->notFoundResponse();
    
            if($first == NULL) {
                // requested resource is /locations
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getAllLocations());
                    break;

                    case "POST":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->isValidInputLocation($input)) {
                            self::$answerGateway->insertLocation($input);
                            http_response_code(201);
                            $response = file_get_contents('php://input');
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;
                    
                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, POST");
                }
            } else {
                // requested resource is /locations/{location}
                // $first is {location}
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getLocationWithID($first));
                    break;

                    case "PUT":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->isValidInputLocation($input)) {
                            self::$answerGateway->updateLocation($first, $input);
                            $response = $this->updatedResponse();
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;

                    case "PATCH":
                        // to do?
                    break;

                    case "DELETE":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getLocationWithID($first));
                        self::$answerGateway->deleteLocation($first);
                    break;

                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, PUT, PATCH, DELETE");
                }
            }
        } else {
            $response = $this->failedAuthResponse();
        }

        $this->view('api' . DIRECTORY_SEPARATOR . 'index', ["response" => $response]);
    }

    /**
     * Handles the following endpoints:
     * /api/responses
     * /api/responses/{response}
     * 
     * @param string $first NULL, if queried endpoint is /api/responses
     *                      {response}, if queried endpoint is /api/responses/{response}
     */
    public function responses($first = NULL) {
        if(isValidJWT()) {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->notFoundResponse();
    
            if($first == NULL) {
                // requested resource is /responses
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getAllResponses());
                    break;

                    case "POST":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->isValidInputResponse($input)) {
                            self::$answerGateway->insertResponse($input);
                            http_response_code(201);
                            $response = file_get_contents('php://input');
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;
                    
                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, POST");
                }
            } else {
                // requested resource is /responses/{response}
                // $first is {response}
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getResponseWithID($first));
                    break;

                    case "PUT":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->isValidInputResponse($input)) {
                            self::$answerGateway->updateResponse($first, $input);
                            $response = $this->updatedResponse();
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;

                    case "PATCH":
                        // to do?
                    break;

                    case "DELETE":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getResponseWithID($first));
                        self::$answerGateway->deleteResponse($first);
                    break;

                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, PUT, PATCH, DELETE");
                }
            }
        } else {
            $response = $this->failedAuthResponse();
        }

        $this->view('api' . DIRECTORY_SEPARATOR . 'index', ["response" => $response]);
    }

    /**
     * Handles the following endpoints:
     * /api/breakouts
     * /api/breakouts/{breakout}
     * 
     * @param string $first NULL, if queried endpoint is /api/breakouts
     *                      {breakout}, if queried endpoint is /api/breakouts/{breakout}
     */
    public function breakouts($first = NULL) {
        if(isValidJWT()) {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->notFoundResponse();
    
            if($first == NULL) {
                // requested resource is /breakouts
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getAllBreakouts());
                    break;

                    case "POST":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->isValidInputBreakout($input)) {
                            self::$answerGateway->insertBreakout($input);
                            http_response_code(201);
                            $response = file_get_contents('php://input');
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;

                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, POST");
                }
            } else {
                // requested resource is /breakouts/{breakout}
                // $first is {breakout}
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getBreakoutWithID($first));
                    break;

                    case "PUT":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->isValidInputBreakout($input)) {
                            self::$answerGateway->updateBreakout($first,$input);
                            $response = $this->updatedResponse();
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;

                    case "PATCH":
                        // to do?
                    break;
                    
                    case "DELETE":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getBreakoutWithID($first));
                        self::$answerGateway->deleteBreakout($first);
                    break;

                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, PUT, PATCH, DELETE");
                }
            }
        }

        $this->view('api' . DIRECTORY_SEPARATOR . 'index', ["response" => $response]);
    }

    /**
     * Handles the following endpoints:
     * /api/breakout_categories
     * /api/breakout_categories/{category}
     * 
     * @param string $first NULL, if queried endpoint is /api/breakout_categories
     *                      {breakout}, if queried endpoint is /api/breakout_categories/{category}
     */
    public function breakout_categories($first = NULL) {
        if(isValidJWT()) {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $response = $this->notFoundResponse();
    
            if($first == NULL) {
                // requested resource is /breakout_categories
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getAllBreakoutsCat());
                    break;

                    case "POST":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->isValidInputBreakoutsCat($input)) {
                            self::$answerGateway->insertBreakoutsCat($input);
                            http_response_code(201);
                            $response = file_get_contents('php://input');
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;

                    default:
                       $response = $this->notAllowedMethodResponse($requestMethod, "GET, POST");
                }
            } else {
                // requested resource is /breakout-categories/{category}
                // $first is {category}
                switch($requestMethod) {
                    case "GET":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getBreakoutWithIDCat($first));
                    break;

                    case "PUT":
                        $input = json_decode(file_get_contents('php://input'), true);
                        if(self::$answerGateway->isValidInputBreakoutsCat($input)) {
                            self::$answerGateway->updateBreakoutCat($first, $input);
                            $response = $this->updatedResponse();
                        } else {
                            $response = $this->badRequestResponse("Request body is malformed.");
                        }
                    break;

                    case "PATCH":
                        // to do?
                    break;
                    
                    case "DELETE":
                        http_response_code(200);
                        $response = json_encode(self::$answerGateway->getBreakoutWithIDCat($first));
                        self::$answerGateway->deleteBreakoutCat($first);
                    break;

                    default:
                        $response = $this->notAllowedMethodResponse($requestMethod, "GET, PUT, PATCH, DELETE");
                }
            }
        }

        $this->view('api' . DIRECTORY_SEPARATOR . 'index', ["response" => $response]);
    }
    
    /**
     * Returns empty body, according to 204 no content status code.
     */
    private function updatedResponse() {
        http_response_code(204);
        return "";
    }
    
    /**
     * Returns JSON response prompting user to see documentations.
     */
    private function notFoundResponse() {
        http_response_code(404);
        return json_encode(["message" => "Please see API documentation.",
                            "error" => "Resource not found."]);
    }

    /**
     * Returns JSON response with more detailed error message;
     */
    private function badRequestResponse($error) {
        http_response_code(400);
        return json_encode(["message" => "Bad request.",
                            "error" => $error]);
    }

    /**
     * Returns JSON response with more detailed error message;
     */
    private function failedAuthResponse() {
        http_response_code(401);
        return json_encode(["message" => "Access denied. Failed authorization.",
                            "error" => $GLOBALS["error"]]);
    }

    /**
     * Returns JSON response indicating allowed methods.
     * 
     * @param string $requestedMethod The method that was requested.
     * @param string $allowedMethods Allowed methods, comma separated.
     * 
     * @return string JSON response.
     */
    private function notAllowedMethodResponse($requestedMethod, $allowedMethods) {
        http_response_code(405);
        header("Allow: " . $allowedMethods);
        return json_encode(["message" => "Method not allowed.",
                            "error" => "$requestedMethod not allowed on this resource."]);    
    }

    private function prepareParams($params) {
        $params = array_slice($params, 1);
        $newParams = [];

        foreach($params as $key => $value)
            array_push($newParams, $key . " = \"" . $value . '"');

        return implode(" AND ",$newParams);
    }

}