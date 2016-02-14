<?php

namespace src;

/**
 * Class User
 */
class User
{
    public $userId;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $salt;

    /**
     * User constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        foreach($options as $key => $value){
            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Validates properties
     * @return bool
     */
    public function isInputValid()
    {
        if(empty($this->firstName) || empty($this->lastName)
            || empty($this->password) || empty($this->email) || !filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * creates password hash
     */
    public function createPassword()
    {
        $this->salt = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,15);
        $this->password = sha1($this->password . $this->salt);
    }

    /**
     * verifies password
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password){
        return ($this->password === sha1($password . $this->salt));
    }
}