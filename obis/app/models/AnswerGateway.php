<?php

/**
 * This class that is used for database API manipulation.
 */
class AnswerGateway {

    /**
     * Cached version of the `responses` table.
     * @var $responses Associative array, keys are `response_id`,
     *                                    values are `response`
     */
    private static $responses;

    /**
     * Cached version of the `break_outs` table.
     * @var $break_outs Associative array, keys are `break_out_id`,
     *                                     values are `break_out`
     */
    private static $break_outs;

    /**
     * Cached version of the `break_out_categories` table.
     * @var $break_out_categories Associative array, keys are `break_out_category_id`,
     *                                               values are `break_out_category`
     */
    private static $break_out_categories;
    
    /**
     * Represents the base URL for creating references inside resources.
     * @var $baseAPIURL Could look like: `http://localhost:8080/obis/api`
     */
    private static $baseAPIURL;

    public function __construct() {
        self::$baseAPIURL = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/obis/api";
        $this->cacheData();
    }

    /**
     * Caches responses, break_outs and break_out_categories.
     */
    private function cacheData() {
        $responses = $this->getAllResponses();
        for($i = 0; $i < count($responses); $i++) {
            $response_id = $responses[$i]['response_id'];
            $response_value = $responses[$i]['response'];
            self::$responses[$response_id] = $response_value;
        }

        $break_outs = $this->getAllBreakouts();
        for($i = 0; $i < count($break_outs); $i++) {
            $break_out_id = $break_outs[$i]['break_out_id'];
            $break_out_value = $break_outs[$i]['break_out'];
            self::$break_outs[$break_out_id] = $break_out_value;
        }

        $break_out_categories = $this->getAllBreakoutsCat();
        for($i = 0; $i < count($break_out_categories); $i++) {
            $break_out_category_id = $break_out_categories[$i]['break_out_category_id'];
            $break_out_category_value = $break_out_categories[$i]['break_out_category'];
            self::$break_out_categories[$break_out_category_id] = $break_out_category_value;
        }
    }

    /**
     * Change `response`, `break_out`, `break_out_category` from:
     * 
     * `
     * "response_id": "RESP040"
     * `
     * 
     * to:
     * 
     * `
     * "response": {
     *      "response_id": "RESP040",
     *      "response": "Overweight (BMI 25.0-29.9)",
     *      "href": "http://localhost:8080/obis/api/responses/RESP040"
     *  }
     * `
     */
    private function modifyAnswer(&$answer) {
        $response['response_id'] = $answer['response_id'];
        $response['response'] = self::$responses[$answer['response_id']];
        $response['href'] = self::$baseAPIURL . '/responses/' . $answer['response_id'];
        unset($answer['response_id']);
        $answer['response'] = $response;

        $break_out['break_out_id'] = $answer['break_out_id'];
        $break_out['break_out'] = self::$break_outs[$answer['break_out_id']];
        $break_out['href'] = self::$baseAPIURL . '/breakouts/' . $answer['break_out_id'];
        unset($answer['break_out_id']);
        $answer['break_out'] = $break_out;
        
        $break_out_category['break_out_category_id'] = $answer['break_out_category_id'];
        $break_out_category['break_out_category'] = self::$break_out_categories[$answer['break_out_category_id']];
        $break_out_category['href'] = self::$baseAPIURL . '/breakout_categories/' . $answer['break_out_category_id'];
        unset($answer['break_out_category_id']);
        $answer['break_out_category'] = $break_out_category;
    }
    
    /**
     * Validate resource to be added to the `bmi` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return boolean 
     */
    public function IsValidInputBmi($input) {
        if(!isset($input["year_value"]) || 
           !isset($input["locationabbr"]) ||
           !isset($input["sample_size"]) ||
           !isset($input["data_value_percentage"]) ||
           !isset($input["confidence_limit_low"]) ||
           !isset($input["confidence_limit_high"]) ||
           !isset($input["response_id"]) ||
           !isset($input["break_out_id"]) ||
           !isset($input["break_out_category_id"]))
            return false;
        return true;
    }
    
    /**
     * Returns the rows in the `bmi` table.
     * 
     * @return array
     */
    public function getAllBmi($params) {
        $query = "SELECT *
                  FROM bmi";

        if ($params)
            $query = $query . " WHERE " . $params;

        try {
            $statement = Database::getConnection()->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            
            foreach($result as &$res)
                $this->modifyAnswer($res);
            
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    /**
     * Inserts a new row in the `bmi` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return void
     */
    public function insertBmi($input) {
        $query = "INSERT INTO bmi (year_value, locationabbr, sample_size, data_value_percentage, confidence_limit_low, confidence_limit_high, response_id, break_out_id, break_out_category_id)
                  VALUES (:year_value, :locationabbr, :sample_size, :data_value_percentage, :confidence_limit_low, :confidence_limit_high, :response_id, :break_out_id, :break_out_category_id)";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['year_value' => $input['year_value'],
                                 'locationabbr' => $input['locationabbr'],
                                 'sample_size' => $input['sample_size'],
                                 'data_value_percentage' => $input['data_value_percentage'],
                                 'confidence_limit_high' => $input['confidence_limit_high'],
                                 'confidence_limit_low' => $input['confidence_limit_low'],
                                 'response_id' => $input['response_id'],
                                 'break_out_id' => $input['break_out_id'],
                                 'break_out_category_id' => $input['break_out_category_id']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }  
    }

    /**
     * Returns the last added resource in the `bmi` table. Used for returning the resource just added using HTTP `POST` method.
     * 
     * @return array Associative array where the keys are the column names
     */
    public function getLastBmi() {
        $query = "SELECT *
                  FROM bmi
                  ORDER BY id DESC
                  LIMIT 1";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            if(isset($result[0])) {
                $this->modifyAnswer($result[0]);
                return $result[0];
            } else {
                return (object)null;
            }
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    /**
     * Returns the resource in the `bmi` table with the specified `id`.
     * 
     * @param int $id The id of the desired resource
     * @param string $params Query parameters
     * 
     * @return array Associative array where the keys are the column names
     */
    public function getBmiWithID($id, $params) {
        $query = "SELECT *
                  FROM bmi
                  WHERE id = :id";

        if($params)
            $query = $query . " AND " . $params;

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(["id" => $id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            if(isset($result[0])) {
                $this->modifyAnswer($result[0]);
                return $result[0];
            } else {
                return (object)null;
            }
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    /**
     * Updates the row with the specified `id` in the table `bmi`.
     * 
     * @param int $id The id of the desired row to be updated
     * @param array $input Associative array corresponding to the new resource
     * 
     * @return void
     */
    public function updateBmi($id, $input) {
        $query = "UPDATE bmi
                  SET year_value = :year_value,
                      locationabbr = :locationabbr,
                      sample_size = :sample_size,
                      data_value_percentage = :data_value_percentage,
                      confidence_limit_low = :confidence_limit_low,
                      confidence_limit_high = :confidence_limit_high,
                      response_id = :response_id,
                      break_out_id = :break_out_id,
                      break_out_category_id = :break_out_category_id
                  WHERE id = :id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['id' => $id,
                                 'year_value' => $input['year_value'],
                                 'locationabbr' => $input['locationabbr'],
                                 'sample_size' => $input['sample_size'],
                                 'data_value_percentage' => $input['data_value_percentage'],
                                 'confidence_limit_high' => $input['confidence_limit_high'],
                                 'confidence_limit_low' => $input['confidence_limit_low'],
                                 'response_id' => $input['response_id'],
                                 'break_out_id' => $input['break_out_id'],
                                 'break_out_category_id' => $input['break_out_category_id']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Delete row with specified `id` in the table `bmi`.
     * 
     * @param int $id The id of the resource to be deleted
     * 
     * @return void
     */
    public function deleteBmi($id) {
        $query = "DELETE FROM bmi
                  WHERE id = :id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['id' => $id]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Returns the rows with the specified state abbreviation.
     * 
     * @param string $locationabbr The state abbreviation
     * @param string $params Query parameters
     * 
     * @return array
     */
    public function getBmiWithLocation($locationabbr, $params) {
        $query ="SELECT *
                 FROM bmi
                 WHERE locationabbr = :locationabbr";
                 
        if($params)
            $query = $query . " AND " .$params;

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['locationabbr' => $locationabbr]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as &$res)
                $this->modifyAnswer($res);

            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    /**
     * Returns the rows with the specified year.
     * 
     * @param int $year_value The year
     * @param string $params Query parameters
     * 
     * @return array
     */
    public function getBmiWithYear($year_value, $params) {
        $query ="SELECT *
                 FROM bmi
                 WHERE year_value = :year_value";
                 
        if($params)
            $query = $query . " AND " . $params;

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['year_value' => $year_value]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as &$res)
                $this->modifyAnswer($res);
            
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    /**
     * Returns the rows with the specified year and state
     * 
     * @param int $year_value The year
     * @param string $locationabbr The state abbreviation
     * @param string $params Query parameters
     * 
     * @return array
     */
    public function getBmiWithYearLocation($year_value, $locationabbr, $params) {
        $query ="SELECT *
                 FROM bmi
                 WHERE year_value = :year_value AND locationabbr = :locationabbr";

        if($params)
            $query = $query . " AND " . $params;

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['year_value' => $year_value,
                                 'locationabbr' => $locationabbr]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as &$res)
                $this->modifyAnswer($res);

            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    /**
     * Validate resource to be added to `locations` table.
     */
    public function isValidInputLocation($input) {
        if(!isset($input["locationabbr"]) ||
           !isset($input["location_name"]))
            return false;
        return true;
    }

    /**
     * Returns the rows in the `locations` table.
     * 
     * @return array
     */
    public function getAllLocations() {
        $query ="SELECT *
                 FROM locations";

        try {
            $statement = Database::getConnection()->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Inserts a new row in the `locations` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return void
     */
    public function insertLocation($input) {
        $query = "INSERT INTO locations
                  VALUES (:locationabbr, :location_name)";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['locationabbr' =>  $input['locationabbr'],
                                 'location_name' =>  $input['location_name']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    

        $this->cacheData();
    }

    /**
     * Returns the resource in the `location` table with the specified state abbreviation.
     * 
     * @param string $locationabbr The state abbreviation
     * 
     * @return array
     */
    public function getLocationWithID($locationabbr) {
        $query = "SELECT *
                  FROM locations
                  WHERE locationabbr = :locationabbr";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(["locationabbr" => $locationabbr]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return isset($result[0]) ? $result[0] : (object)null;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Updates the row with the specified state abbreviation in the table `locations`.
     * 
     * @param int $locationabbr The state abbreviation of the desired row to be updated
     * @param array $input Associative array corresponding to the new resource
     * 
     * @return void
     */
    public function updateLocation($locationabbr, $input) {
        $query = "UPDATE locations
                  SET location_name = :location_name
                  WHERE locationabbr = :locationabbr";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['locationabbr' => $locationabbr,
                                 'location_name' => $input['location_name']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Delete row with specified state abbreviation in the table `locations`.
     * 
     * @param int $locationabbr The state abbreviation of the desired row to be deleted
     * 
     * @return void
     */
    public function deleteLocation($locationabbr) {
        $query = "DELETE FROM locations
                  WHERE locationabbr = :locationabbr";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['locationabbr' => $locationabbr]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Validate resource to be added to `responses` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return boolean
     */
    public function isValidInputResponse($input) {
        if(!isset($input["response_id"]) ||
           !isset($input["response"]))
            return false;
        return true;
    }

    /**
     * Returns the rows in the `responses` table.
     * 
     * @return array
     */
    public function getAllResponses() {
        $query ="SELECT *
                 FROM responses";

        try {
            $statement = Database::getConnection()->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Inserts a new row in the `responses` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return void
     */
    public function insertResponse($input) {
        $query = "INSERT INTO responses
                  VALUES (:response_id, :response)";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['response_id' =>  $input['response_id'],
                                 'response' =>  $input['response']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    

        $this->cacheData();
    }

    /**
     * Returns the resource in the `responses` table with the specified response id.
     * 
     * @param string $response_id The response id of the resource to be updated
     * 
     * @return array
     */
    public function getResponseWithID($response_id) {
        $query = "SELECT *
                  FROM responses
                  WHERE response_id = :response_id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(["response_id" => $response_id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return isset($result[0]) ? $result[0] : (object)null;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Updates the row with the specified response id in the table `responses`.
     * 
     * @param int $response_id The response id of the resource to be updated
     * @param array $input Associative array corresponding to the new resource
     * 
     * @return void
     */
    public function updateResponse($response_id, $input) {
        $query = "UPDATE responses
                  SET response = :response
                  WHERE response_id = :response_id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['response_id' => $response_id,
                                 'response' => $input['response']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Delete row with specified response id in the table `responses`.
     * 
     * @param int $response_id The response id of the resource to be updated
     * 
     * @return void
     */
    public function deleteResponse($response_id) {
        $query = "DELETE FROM responses
                  WHERE response_id = :response_id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['response_id' => $response_id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Validate resource to be added to `breakouts` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return boolean
     */
    public function isValidInputBreakout($input) {
        if(!isset($input["break_out_id"]) ||
           !isset($input["break_out"]))
            return false;
        return true;
    }
    
    /**
     * Returns the rows in the `break_outs` table.
     * 
     * @return array
     */
    public function getAllBreakouts() {
        $query ="SELECT *
                 FROM break_outs";

        try {
            $statement = Database::getConnection()->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Inserts a new row in the `break_outs` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return void
     */
    public function insertBreakout($input) {
        $query = "INSERT INTO break_outs
                  VALUES (:break_out_id, :break_out)";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_id' => $input['break_out_id'],
                                 'break_out' =>  $input['break_out']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    

        $this->cacheData();
    }

    /**
     * Returns the resource in the `break_out` table with the specified break_out_id.
     * 
     * @param string $break_out_id The break out id
     * 
     * @return array
     */
    public function getBreakoutWithID($break_out_id) {
        $query ="SELECT *
                 FROM break_outs
                 WHERE break_out_id = :break_out_id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_id' => $break_out_id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return isset($result[0]) ? $result[0] : (object)null;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Updates the row with the specified break out id in the table `break_out`.
     * 
     * @param int $break_out_id The break out id
     * @param array $input Associative array corresponding to the new resource
     * 
     * @return void
     */
    public function updateBreakout($break_out_id, $input) {
        $query = "UPDATE break_outs
                  SET break_out = :break_out
                  WHERE break_out_id = :break_out_id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_id' => $break_out_id,
                                 'break_out' => $input['break_out']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Delete row with specified break out id in the table `break_out`.
     * 
     * @param int $break_out The break out id of the response to be deleted
     * 
     * @return void
     */
    public function deleteBreakout($break_out_id) {
        $query = "DELETE FROM break_outs
                  WHERE break_out_id = :break_out_id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_id' => $break_out_id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Validate resource to be added to the `break_out_categories` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return boolean 
     */
    public function isValidInputBreakoutsCat($input) {
        if(!isset($input["break_out_category_id"]) ||
           !isset($input["break_out_category"]))
            return false;
        return true;
    }
    
    /**
     * Returns the rows in the `break_outs_categories` table.
     * 
     * @return array
     */
    public function getAllBreakoutsCat() {
        $query ="SELECT *
                 FROM break_out_categories";

        try {
            $statement = Database::getConnection()->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Inserts a new row in the `break_out_categories` table.
     * 
     * @param array $input An associative array containing the new resource to be added
     * 
     * @return void
     */
    public function insertBreakoutsCat($input) {
        $query = "INSERT INTO break_out_categories
                  VALUES (:break_out_category_id, :break_out_category)";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_category_id' =>  $input['break_out_category_id'],
                                 'break_out_category' =>  $input['break_out_category']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }  
        
        $this->cacheData();
    }

    /**
     * Returns the resource in the `break_out_category` table with the specified break_out_category_id.
     * 
     * @param string $break_out_id The break out category id
     * 
     * @return array
     */
    public function getBreakoutWithIDCat($break_out_category_id) {
        $query ="SELECT *
                 FROM break_out_categories
                 WHERE break_out_category_id = :break_out_category_id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_category_id' => $break_out_category_id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return isset($result[0]) ? $result[0] : (object)null;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Updates the row with the specified break out category id in the table `break_out_categories`.
     * 
     * @param int $break_out_id The break out category id
     * @param array $input Associative array corresponding to the new resource
     * 
     * @return void
     */
    public function updateBreakoutCat($id,$input) {
        $query = "UPDATE break_out_categories
                  SET break_out_category = :break_out_category
                  WHERE break_out_category_id = :break_out_category_id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_category_id' => $id,
                                 'break_out_category' => $input['break_out_category']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Delete row with specified break out category id in the table `break_out_categories`.
     * 
     * @param int $break_out The break out category id of the response to be deleted
     * 
     * @return void
     */
    public function deleteBreakoutCat($break_out_category_id) {
        $query = "DELETE FROM break_out_categories 
                  WHERE break_out_category_id = :break_out_category_id";
        
        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_category_id' => $break_out_category_id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
    
}