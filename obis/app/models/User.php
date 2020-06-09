<?php

class User {

    /**
     * @var $firstname User's firstname
     */
    private $firstname;

    /**
     * @var $lastname User's lastname
     */
    private $lastname;

    /**
     * @var $email User's emails
     */
    private $email;

    /**
     * @var $password User's hashed password
     */
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
    
        $statement = Database::getConnection()->prepare($query);

        if($statement->execute(["firstname" => $this->firstname,
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
    public static function exists($email) {
        $query = "SELECT email
                  FROM users
                  WHERE email = :email";
    
        $statement = Database::getConnection()->prepare($query);
        $statement->execute(["email" => $email]);

        if($statement->rowCount() != 0)
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

        $statement = Database::getConnection()->prepare($query);
        $statement->execute(["email" => $email]);

        if($statement->rowCount() != 0) {
            $row = $statement->fetch();
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

    /**
     * Update a user's account data
     * 
     * @param string $oldFirstname Old email of the user
     * @param string $oldLastname Old email of the user
     * @param string $oldEmail Old email of the user
     * @param string $newFirstname The first name to change to
     * @param string $newLastname The last name to change to
     * @param string $newEmail The new email to change to
     * 
     * @return bool `False` if `$newEmail` already exists in the database,
     *              `True` otherwise
     */
    public static function updateData(&$oldFirstname, &$oldLastname, &$oldEmail, $newFirstname, $newLastname, $newEmail) {
        $newFirstname = strip_tags($newFirstname);
        $newLastname = strip_tags($newLastname);
        $newEmail = strip_tags($newEmail);
        
        $query = "UPDATE users
                  SET firstname = :newFirstname, lastname = :newLastname, email = :newEmail
                  WHERE email = :oldEmail";

        $statement = Database::getConnection()->prepare($query);
        if($statement->execute(['newFirstname' => $newFirstname,
                                    'newLastname' => $newLastname,
                                    'newEmail' => $newEmail,
                                    'oldEmail' => $oldEmail])) {
            $oldFirstname = $newFirstname;
            $oldLastname = $newLastname;
            $oldEmail = $newEmail;
            return true;
        } else {
            return false;
        }
    }

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