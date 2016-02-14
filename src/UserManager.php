<?php

namespace src;

use util\Mail;
use src\User;

class UserManager
{
    private $db;
    private $email;
    private $config;

    /**
     * UserManager constructor.
     * @param $email
     * @param \PDO $db
     * @param $config
     */
    public function __construct($email, \PDO $db, $config)
    {
        $this->email = $email;
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * Sends activation email
     * @param \src\User $user
     */
    public function sendActivationEmail(User $user)
    {
        $this->email->setEmailFrom($this->config->email);
        $this->email->setEmailTo($user->email);
        $this->email->setTitle('Your account has been activated');
        $this->email->setBody("Dear {$user->firstName} \n
                               Your account has been activated\n
                               Please visit {$this->config->site_url}\n
                               Thank you");
        $this->email->send();
    }

    /**
     * Stores user in the database
     * @param \src\User $user
     * @return bool
     * @throws \Exception
     */
    public function createUser(User $user)
    {
        if(!$user->isInputValid()){
            throw new \InvalidArgumentException('Invalid user data');
        }
        $user->createPassword();
        $sql = "INSERT INTO users (firstname, lastname, email, password, salt) VALUES (:firstname, :lastname, :email, :password, :salt)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':firstname',$user->firstName);
        $statement->bindParam(':lastname',$user->lastName);
        $statement->bindParam(':email',$user->email);
        $statement->bindParam(':password',$user->password);
        $statement->bindParam(':salt',$user->salt);
        if($statement->execute()){
            $user->userId = $this->db->lastInsertId();
            $this->sendActivationEmail($user);
            return true;
        }else{
            throw new \Exception('User wasn\'t saved:' . implode(':',$statement->errorInfo()));
        }
        return false;

    }
}