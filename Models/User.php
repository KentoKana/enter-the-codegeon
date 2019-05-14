<?php

class User
{
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

    // Setters and Getters
    public function setFirstName($firstName)
    {
        if ($firstName == '') {
            return false;
        } else {
            return $this->firstName = $firstName;
        }
    }
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        if ($lastName == '') {
            return false;
        } else {
            return $this->lastName = $lastName;
        }
    }
    public function getLastName()
    {
        return $this->lastName;
    }

    public function setUsername($username)
    {
        if ($username == '') {
            return false;
        } else {
            return $this->username = $username;
        }
    }
    public function getUsername()
    {
        return $this->username;
    }

    public function setRegisterPassword($password, $passConfirm)
    {
        if (
            $password == '' ||
            $passConfirm == '' ||
            $password != $passConfirm
        ) {
            return false;
        } else {
            return $this->password = $passConfirm;
        }
    }
    public function getRegisterPassword()
    {
        return $this->password;
    }

    public function setLoginPass($password)
    {
        if ($password == '') {
            return false;
        } else {
            return $this->password = $password;
        }
    }
    public function getLoginPass($password)
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        if ($email == '' || filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            return false;
        } else {
            return $this->email = $email;
        }
    }
    public function getEmail()
    {
        return $this->email;
    }

    // CRUD Methods
    public function addUser()
    {
        $record = $this->collection->insertOne([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($record->getInsertedCount() == 1) {
            // insert the userid into session
            return $record->getInsertedId();
        }
    }
}
