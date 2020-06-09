<?php

class StatisticsModel {

    /**
     * Get array of all year entries. Used for filling `<option>` inside `<select>`
     * 
     * @return array
     */
     public function getYearsArray() {
         $query = "SELECT DISTINCT year_value
         FROM bmi
         ORDER BY year_value";
         
         try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            for($i = 0; $i < count($result); $i++)
                $result[$i] = $result[$i]['year_value'];
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Get array of all state entries. Used for filling `<option>` inside `<select>`
     * 
     * @return array
     */
    public function getStatesArray() {
        $query = "SELECT locationabbr, location_name
                  FROM locations
                  ORDER BY locationabbr";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            for($i = 0; $i < count($result); $i++) {
                $result[$result[$i]['locationabbr']] = $result[$i]['location_name'];
                unset($result[$i]);
            }
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    
}