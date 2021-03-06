<?php

class User
{
    private $collection;
    private $username;
    private $email;
    private $firstName;
    private $lastName;
    private $password;
    private $currentUser;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    // Setters and Getters
    public function setFirstName($firstName)
    {
        if ($firstName == '' || empty($firstName)) {
            $this->firstName = false;
        } else {
            $this->firstName = $firstName;
        }
    }
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        if ($lastName == '') {
            $this->lastName = false;
        } else {
            $this->lastName = $lastName;
        }
    }
    public function getLastName()
    {
        return $this->lastName;
    }

    public function setUsername($username)
    {
        if ($username == '') {
            $this->username = false;
        } else {
            $this->username = $username;
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
            $this->password = false;
        } else {
            $hashedPass = password_hash($passConfirm, PASSWORD_DEFAULT);
            $this->password = $hashedPass;
        }
    }
    public function getRegisterPassword()
    {
        return $this->password;
    }

    public function setEditPassword($password, $passConfirm)
    {
        if (
            $password == '' ||
            $passConfirm == '' ||
            $password != $passConfirm
        ) {
            return false;
        } else {
            $hashedPass = password_hash($passConfirm, PASSWORD_DEFAULT);
            return $this->password = $hashedPass;
        }
    }

    public function setLoginPass($password)
    {
        if ($password == '') {
            $this->password = false;
        } else {
            return $this->password = $password;
        }
    }
    public function getLoginPass()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        if ($email == '' || filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $this->email = false;
        } else {
            $this->email = $email;
        }
    }
    public function getEmail()
    {
        return $this->email;
    }

    // CRUD Methods
    public function getCurrentUser($id)
    {
        return $this->currentUser = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);
    }

    public function getUserById($id)
    {
        return $this->collection->find(['_id' => new MongoDB\BSON\ObjectID($id)]);
    }

    public function addUser()
    {
        $record = $this->collection->insertOne([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'image' => '',
            'completedStages' => new StdClass
        ]);

        if ($record->getInsertedCount() == 1) {
            // insert the userid into session
            return $record->getInsertedId();
        }
    }

    public function addUserImage($file)
    {
        $this->collection->updateOne(
            ['_id' => $this->currentUser['_id']],
            ['$set' => [
                'image' => $file,
            ]]
        );
    }

    public function editUser()
    {
        $this->collection->updateOne(
            ['_id' => $this->currentUser['_id']],
            ['$set' => [
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'username' => $this->username,
                'email' => $this->email,
            ]]
        );

        // If Password field is set, then
        if ($this->password) {
            $this->collection->updateOne(
                ['_id' => $this->currentUser['_id']],
                ['$set' => [
                    'password' => $this->password,
                ]]
            );
        } else {
            $this->collection->updateOne(
                ['_id' => $this->currentUser['_id']],
                ['$set' => [
                    'password' => $this->currentUser['password'],
                ]]
            );
        }
    }

    public function deleteUser($id)
    {
        $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($id)]);
    }

    public function addStageCompleted($stageId, $stars)
    {
        $completedStages = $this->getCompletedStages();

        if (isset($completedStages[$stageId])) {
            if ($completedStages[$stageId] < $stars) {
                $completedStages[$stageId] = $stars;
                $this->collection->updateOne(
                    ['_id' => $this->currentUser['_id']],
                    ['$set' => [
                        'completedStages' => $completedStages,
                    ]]
                );
            }
        } else {
            $completedStages[$stageId] = $stars;
            $this->collection->updateOne(
                ['_id' => $this->currentUser['_id']],
                ['$set' => [
                    'completedStages' => $completedStages,
                ]]
            );
        }
    }

    public function getCompletedStages()
    {
        $completedStages = $this->collection->findOne(
            ['_id' => new MongoDB\BSON\ObjectID($this->currentUser['_id'])]
        )->completedStages;

        return $completedStages;
    }
}
