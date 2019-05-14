<?php 

class User {
    private $collection;
    private $username;
    private $email;
    private $firstName;
    private $lastName;
    private $password;

    public function __construct($collection) 
    {
        $this->collection = $collection;
    }

    public function setFirstName($firstName) {
        if($firstName == '') {
            return false;
        } else {
            return $this->firstName = $firstName;
        }
    }
    public function getFirstName(){
        return $this->firstName;
    }
    
    public function setLastName($lastName) {
        if($lastName == '') {
            return false;
        } else {
            return $this->lastName = $lastName;
        }
    }
    public function getLastName(){
        return $this->lastName;
    }

    public function setUsername($username) {
        if($username == '') {
            return false;
        } else {
            return $this->username = $username;
        }
    }
    public function getUsername(){
        return $this->username;
    }

    public function setPassword($password) {
        if($password == '') {
            return false;
        } else {
            return $this->password = $password;
        }
    }
    public function getPassword(){
        return $this->password;
    }

    public function setEmail($email){
        if($email == '' || filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            return false;
        } else {
            return $this->email = $email;
        }
    }
    public function getEmail() {
        return $this->email;
    }

}

?>