<?php

class AnswerGateway {

    /**
     * Validate resource to be added to /answers collection.
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
    
    public function getAllBmi() {
        $query ="SELECT id, year_value, locationabbr, sample_size, data_value_percentage, confidence_limit_low, confidence_limit_high, response_id, break_out_id, break_out_category_id 
                 FROM bmi";

        try {
            $statement = Database::getConnection()->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function insertBmi(Array $input) {
        $query = "INSERT INTO bmi(year_value, locationabbr, sample_size, data_value_percentage, confidence_limit_low, confidence_limit_high, response_id, break_out_id, break_out_category_id)
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

    public function getLastBmi() {
        $query = "SELECT *
                  FROM bmi
                  ORDER BY id DESC
                  LIMIT 1";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return isset($result[0]) ? $result[0] : (object)null;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function getBmiWithID($id) {
        $query = "SELECT *
                  FROM bmi
                  WHERE id = :id";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(["id" => $id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return isset($result[0]) ? $result[0] : (object)null;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }     
    }

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


    public function deleteBmi($id) {
        $query = "DELETE FROM bmi
                  WHERE id = :id;";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function getBmiWithLocation($locationabbr) {
        $query ="SELECT id, year_value, locationabbr, sample_size, data_value_percentage, response_id, break_out_id, break_out_category_id 
                     FROM bmi
                     WHERE locationabbr = :locationabbr";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['locationabbr' => $locationabbr]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     

    }

    public function getBmiWithYear($year_value) {
        $query ="SELECT id, year_value, locationabbr, sample_size, data_value_percentage, response_id, break_out_id, break_out_category_id 
                 FROM bmi
                 WHERE year_value = :year_value";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['year_value' => $year_value]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    public function getBmiWithYearLocation($year, $location) {
        $query ="SELECT id, year_value, locationabbr, sample_size, data_value_percentage, response_id, break_out_id, break_out_category_id 
                 FROM bmi
                 WHERE year_value = :year AND locationabbr = :location";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['year' => (int)$year,
                                 'location' => $location]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    public function getAllLocations() {
        $query ="SELECT *
                 FROM locations;";

        try {
            $statement = Database::getConnection()->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Validate resource to be added to /locations collection.
     */
    public function isValidInputLocation($input) {
        if(!isset($input["locationabbr"]) ||
           !isset($input["location_name"]))
            return false;
        return true;
    }

    public function insertLocation($input) {
        $query = "INSERT INTO locations(locationabbr, location_name)
                  VALUES (:locationabbr, :location_name)";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['locationabbr' =>  $input['locationabbr'],
                                 'location_name' =>  $input['location_name']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

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

    public function deleteLocation($locationabbr) {
        $query = "DELETE FROM locations
                  WHERE locationabbr = :locationabbr;";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['locationabbr' => $locationabbr]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Validate resource to be added to /breakouts collection.
     */
    public function isValidInputBreakout($input) {
        if(!isset($input["break_out_id"]) ||
           !isset($input["break_out"]))
            return false;
        return true;
    }
    
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
    }

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
     * Validate resource to be added to /breakouts collection.
     */
    public function isValidInputBreakoutsCat($input)
    {
        if(! isset($input["break_out_category_id"]))
            return false;
        if(! isset($input["break_out_category"]))
            return false;
        return true;
    }
    
    public function getAllBreakoutsCat() {
        $query ="SELECT *
                 FROM break_outs_category;";

        try {
            $statement = Database::getConnection()->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insertBreakoutsCat($input) {
        $query = "INSERT INTO break_outs_category
                  VALUES (:break_out_category_id, :break_out_category)";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['break_out_category_id' =>  $input['break_out_category_id'],
                                 'break_out_category' =>  $input['break_out_category']]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function getBreakoutWithIDCat($break_out_category_id) {
        $query ="SELECT *
                 FROM break_outs_category
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

    public function updateBreakoutCat($id,$input) {
        $query = "UPDATE break_outs_category
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

    public function deleteBreakoutCat($break_out_category_id) {
        $query = "DELETE FROM break_outs_category 
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