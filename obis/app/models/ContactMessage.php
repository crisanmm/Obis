<?php

class ContactMessage {

    /**
     * Stores a contact message in the database
     * 
     * @param string $name The name of the sender
     * @param string $email The email of the sender
     * @param string $message The message of the sender
     * 
     */
    public function storeMessage($name, $email, $message) {
        $query = "INSERT INTO contactmessages (name, email, message)
                  VALUES (:name, :email, :message)";

        try {
            $statement = Database::getConnection()->prepare($query);
            $statement->execute(['name' =>  $name,
                                 'email' =>  $email,
                                 'message' =>  $message]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    
}