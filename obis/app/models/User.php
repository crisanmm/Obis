<?php

    class User {

        private $firstname;
        private $lastname;
        private $username;
        private $hashedPassword;

        function __construct($firstname, $lastname, $username, $hashedPassword) {
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->username = $username;
            $this->hashedPassword = $hashedPassword;
        }
        
        public function setFirstName(string $firstname) {
            $this->firstname = $firstname;
        }
        
        public function getFirstName() : string {
            return $this->firstname;
        }
        
        public function setLastName(string $lastname) {
            $this->lastname = $lastname;
        }
        
        public function getLastName() : string {
            return $this->lastname;
        }
        
        public function setUsername(string $username) {
            $this->username = $username;
        }
        
        public function getUsername() {
            return $this->username;
        }
        
        public function getHashedPassword() : string {
            return $this->hashedPassword;
        }

    }
