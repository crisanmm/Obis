<?php

    class User {

        private $firstname;
        private $lastname;
        private $email;
        private $password;

        /**
         * Constructor used for registering a user.
         * 
         * @param string $firstname User's first name.
         * @param string $lastname User's last name.
         * @param string $email User's email.
         * @param string $password User's password, will be hashed inside object.
         * 
         * @return object User object.
         */
        public function __construct($firstname, $lastname, $email, $password) {
            $this->setFirstName($firstname);
            $this->setLastName($lastname);
            $this->setEmail($email);
            $this->setPassword($password);
        }

        /**
         * Create user (add user to database) 
         */
        public function create() {
            $query = "INSERT INTO users(firstname, lastname, email, password)
                      VALUES(:firstname, :lastname, :email, :password)";
        
            $stmt = Database::getConnection()->prepare($query);

            if($stmt->execute(["firstname" => $this->firstname,
                               "lastname" => $this->lastname,
                               "email" => $this->email,
                               "password" => $this->password]))
                return true;
            else
                return false;
        }
        
        /**
         * Check if a user exists in the database or not
         */
        public function exists() {
            $query = "SELECT email
                      FROM users
                      WHERE email = :email";
        
            $stmt = Database::getConnection()->prepare($query);
            $stmt->execute(["email" => $this->email]);

            if($stmt->rowCount() != 0)
                return true;
            else
                return false;
        }
    
        /**
         * Login user.
         * 
         * @param string $email Email of the user.
         * @param string $password Cleartext representation of user's password.
         * 
         * @return object User object with all the information fetched from the database.
         * @return bool False is returned if the user couldn't be authenticated.
         */
        public static function login($email, $password) {
            // email uniquely identifies a user
            $query = "SELECT firstname, lastname, email, password
                      FROM users
                      WHERE email = :email";

            $stmt = Database::getConnection()->prepare($query);
            $stmt->execute(["email" => $email]);

            if($stmt->rowCount() != 0) {
                $row = $stmt->fetch();
                if(password_verify($password, $row['password']))
                    return new User($row['firstname'],
                                    $row['lastname'],
                                    $row['email'],
                                    $row['password']);
                else
                    return false; // failed password authentication
            } else {
                return false; // user with specified does not exist
            }
        }

        // update() method will be here

        public function setFirstname($firstname) {
            $this->firstname = strip_tags($firstname);
        }

        public function getFirstname() {
            return $this->firstname;
        }
        
        public function setLastname($lastname) {
            $this->lastname = strip_tags($lastname);
        }

        public function getLastname() {
            return $this->lastname;
        }

        public function setEmail($email) {
            $this->email = strip_tags($email);
        }
        
        public function getEmail() {
            return $this->email;
        }
        
        public function setPassword($password) {
            $this->password = password_hash(strip_tags($password), PASSWORD_DEFAULT);
        }
        
        public function getPassword() {
            return $this->password;
        }

    }