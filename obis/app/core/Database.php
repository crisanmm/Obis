<?php

    /**
     * Database singleton
     */
    class Database {
    
        private static $host = "localhost";
        private static $db_name = "obis";
        private static $username = "root";
        private static $password = "";
        
        private static $conn = null;
    
        /**
         * Get database PDO connection
         */
        public static function getConnection() {
            if(Database::$conn == null) {
                try {
                    Database::$conn = new PDO("mysql:host=" . Database::$host . ";dbname=" . Database::$db_name,
                                         Database::$username, Database::$password);
                } catch(PDOException $exception) {
                    echo "Connection error: " . $exception->getMessage();
                }
            }

            return Database::$conn;
        }
    }