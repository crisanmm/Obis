<?php
class AnswerGateway{
  
    // database connection and table name
    private $conn;

    // constructor with $db as database connection
    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function getAllBmi()
    {
        $statement ="
        SELECT id,year_value,locationabbr,sample_size,data_value_percentage,response_id,break_out_id,break_out_category_id 
        FROM bmi;";

        try
        {
            $statement = $this->conn->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
            catch(\PDOException $e)
            {
                exit($e->getMessage());
            }
    }

    public function validateInputBmi($input)
    {
        if(! isset($input["year_value"]))
            return false;
        if(! isset($input["locationabbr"]))
            return false;
        if(! isset($input["sample_size"]))
            return false;
        if(! isset($input["data_value_percentage"]))
            return false;
        if(! isset($input["confidence_limit_low"]))
            return false;
        if(! isset($input["confidence_limit_high"]))
            return false;
        if(! isset($input["response_id"]))
            return false;
        if(! isset($input["break_out_id"]))
            return false;
        if(! isset($input["break_out_category_id"]))
            return false;
        return true;
    }
    
    public function insertBmi(Array $input)
    {
        $statement = "
        INSERT INTO bmi
            (year_value,locationabbr,sample_size,data_value_percentage,confidence_limit_low,confidence_limit_high,response_id,break_out_id,break_out_category_id)
        VALUES 
            (:year_value,:locationabbr,:sample_size,:data_value_percentage,:confidence_limit_low,:confidence_limit_high,:response_id,:break_out_id,:break_out_category_id);
        ";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
            'year_value' => $input['year_value'],
            'locationabbr' => $input['locationabbr'],
            'sample_size' => $input['sample_size'],
            'data_value_percentage' => $input['data_value_percentage'],
            'confidence_limit_high' => $input['confidence_limit_high'],
            'confidence_limit_low' => $input['confidence_limit_low'],
            'response_id' => $input['response_id'],
            'break_out_id' => $input['break_out_id'],
            'break_out_category_id' => $input['break_out_category_id'],
            ));
        }catch (\PDOException $e) 
        {
            exit($e->getMessage());
        }    
    }

    public function getBmiWithID($id)
    {
        $statement = "
            SELECT id,year_value,locationabbr,sample_size,data_value_percentage,response_id,break_out_id,break_out_category_id 
            FROM bmi
            WHERE id = ?;";
        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    public function updateBmi($id, Array $input)
    {
        $statement = "
        UPDATE bmi
        SET 
            year_value = :year_value
            locationabbr = :locationabbr
            sample_size = :sample_size
            data_value_percentage = :data_value_percentage
            confidence_limit_high = :confidence_limit_high
            confidence_limit_low = :confidence_limit_low
            response_id = :response_id
            break_out_id = :break_out_id
            break_out_category_id = :break_out_category_id
        WHERE id = :id;
        ";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
            'id' => (int) $id,
            'year_value' => $input['year_value'],
            'locationabbr' => $input['locationabbr'],
            'sample_size' => $input['sample_size'],
            'data_value_percentage' => $input['data_value_percentage'],
            'confidence_limit_high' => $input['confidence_limit_high'],
            'confidence_limit_low' => $input['confidence_limit_low'],
            'response_id' => $input['response_id'],
            'break_out_id' => $input['break_out_id'],
            'break_out_category_id' => $input['break_out_category_id'],
            ));
        }catch (\PDOException $e) 
        {
            exit($e->getMessage());
        }    
    }


    public function deleteBmi($id)
    {
        $statement = "
        DELETE FROM bmi
        WHERE id = :id;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function getBmiWithLocation($location)
    {
        $statement ="
        SELECT id,year_value,locationabbr,sample_size,data_value_percentage,response_id,break_out_id,break_out_category_id 
        FROM bmi
        WHERE locationabbr = ?;";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($location));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     

    }

    public function getBmiWithYear($year)
    {
        $statement ="
        SELECT id,year_value,locationabbr,sample_size,data_value_percentage,response_id,break_out_id,break_out_category_id 
        FROM bmi
        WHERE year_value = ?;";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array((int)$year));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    public function getBmiWithYearLocation($year, $location)
    {
        $statement ="
        SELECT id,year_value,locationabbr,sample_size,data_value_percentage,response_id,break_out_id,break_out_category_id 
        FROM bmi
        WHERE year_value = :year and locationabbr = :location;";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'year' => (int)$year,
                'location' => $location,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }     
    }

    public function getAllLocations()
    {
        $statement ="
        SELECT * FROM locations;";

        try
        {
            $statement = $this->conn->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
            catch(\PDOException $e)
            {
                exit($e->getMessage());
            }
    }

    public function validateInputLocations($input)
    {
        if(! isset($input["locationabbr"]))
            return false;
        if(! isset($input["location_name"]))
            return false;
        return true;
    }

    public function insertLocations($input)
    {
        $statement = "
        INSERT INTO locations
        (locationabbr, location_name)
        VALUES(:locationabbr, :location_name);
        ";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
            'locationabbr' =>  $input['locationabbr'],
            'location_name' =>  $input['location_name']
            ));
        }catch (\PDOException $e) 
        {
            exit($e->getMessage());
        }    
    }

    public function getLocationWithID($id)
    {
        $statement ="SELECT * FROM locations WHERE locationabbr = ?;";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
            catch(\PDOException $e)
            {
                exit($e->getMessage());
            }
    }

    public function updateLocations($id,$input)
    {
        $statement = "
        UPDATE locations
        SET 
            location_name = :location_name
        WHERE locationabbr = :locationabbr;
        ";
        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
            'locationabbr' => $id,
            'location_name' => $input['location_name'],
            ));
        }catch (\PDOException $e) 
        {
            exit($e->getMessage());
        }    
    }

    public function deleteLocation($id)
    {
        $statement = "
        DELETE FROM locations
        WHERE id = :id;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array('id' => $id));


            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function getAllBreakouts()
    {
        $statement ="
        SELECT * FROM break_outs;";

        try
        {
            $statement = $this->conn->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
            catch(\PDOException $e)
            {
                exit($e->getMessage());
            }
    }

    public function validateInputBreakouts($input)
    {
        if(! isset($input["break_out_id"]))
            return false;
        if(! isset($input["break_out"]))
            return false;
        return true;
    }

    public function insertBreakouts($input)
    {
        $statement = "
        INSERT INTO break_outs
        (break_out_id, break_out)
        VALUES(:break_out_id, :break_out);
        ";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
            'break_out' =>  $input['break_out'],
            'break_out_id' =>  $input['break_out_id']
            ));
        }catch (\PDOException $e) 
        {
            exit($e->getMessage());
        }    
    }

    public function getBreakoutWithID($id)
    {
        $statement ="SELECT * FROM break_outs WHERE break_out_id = ?;";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
            catch(\PDOException $e)
            {
                exit($e->getMessage());
            }
    }

    public function updateBreakout($id,$input)
    {
        $statement = "
        UPDATE break_outs
        SET 
            break_out = :break_out
        WHERE break_out_id = :break_out_id;
        ";
        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
            'break_out_id' => $id,
            'break_out' => $input['break_out'],
            ));
        }catch (\PDOException $e) 
        {
            exit($e->getMessage());
        }    
    }

    public function deleteBreakout($id)
    {
        $statement = "
        DELETE FROM break_outs
        WHERE break_out_id = ?;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($id));
            // echo $statement->errorCode();

            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function getAllBreakoutsCat()
    {
        $statement ="
        SELECT * FROM break_outs_category;";

        try
        {
            $statement = $this->conn->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
            catch(\PDOException $e)
            {
                exit($e->getMessage());
            }
    }

    public function validateInputBreakoutsCat($input)
    {
        if(! isset($input["break_out_category_id"]))
            return false;
        if(! isset($input["break_out_category"]))
            return false;
        return true;
    }

    public function insertBreakoutsCat($input)
    {
        $statement = "
        INSERT INTO break_outs_category
        (break_out_category_id, break_out_category)
        VALUES(:break_out_category_id, :break_out_category);
        ";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
            'break_out_category' =>  $input['break_out_category'],
            'break_out_category_id' =>  $input['break_out_category_id']
            ));
            //echo $statement->errorCode();
        }catch (\PDOException $e) 
        {
            exit($e->getMessage());
        }    
    }

    public function getBreakoutWithIDCat($id)
    {
        $statement ="SELECT * FROM break_outs_category WHERE break_out_category_id = ?;";

        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
            catch(\PDOException $e)
            {
                exit($e->getMessage());
            }
    }

    public function updateBreakoutCat($id,$input)
    {
        $statement = "
        UPDATE break_outs_category
        SET 
            break_out_category = :break_out_category
        WHERE break_out_category_id = :break_out_category_id;
        ";
        try
        {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
            'break_out_category_id' => $id,
            'break_out_category' => $input['break_out_category'],
            ));
        }catch (\PDOException $e) 
        {
            exit($e->getMessage());
        }    
    }

    public function deleteBreakoutCat($id)
    {
        $statement = "
        DELETE FROM break_outs_category
        WHERE break_out_category_id = ?;";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($id));
            // echo $statement->errorCode();

            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}

?>