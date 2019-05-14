<?php
require_once './Models/User.php';
$client = new MongoDB\Client(env('MONGO_URI'));
$collection = $client->codegen->users;

// If userid session is set, redirect to profile.php.
if (isset($_SESSION['userid'])) {
    header('location: ./profile.php');
}

if (isset($_POST['submitRegister'])) {

    // Set User Info
    $u = new User($collection);
    $u->setFirstName($_POST['firstName']);
    $u->setLastName($_POST['lastName']);
    $u->setUsername($_POST['username']);
    $u->setRegisterPassword($_POST['password'], $_POST['passwordConfirm']);
    $u->setEmail($_POST['email']);

    // Get User Info
    $fname = $u->getFirstName();
    $lname = $u->getLastName();
    $username = $u->getUsername();
    $password = $u->getRegisterPassword();
    $email = $u->getEmail();

    //User Info Array
    $userInfo = [
        $fname,
        $lname,
        $username,
        $password,
        $email
    ];

    $registeringUser = $collection->findOne(['username' => $u->getUsername()]);
    $registeringUserEmail = $collection->findOne(['email' => $u->getEmail()]);
    // var_dump($registeringUser);
    $errorMsg = '';
    if ($registeringUser || $registeringUserEmail) {
        if ($registeringUser) {
            $errorMsg .= 'User Already Exists. <br>';
        }
        if ($registeringUserEmail) {
            $errorMsg .= 'Email Already Registered. <br>';
        }
        echo $errorMsg;
    } else {
        if (array_search(false, $userInfo) === false) {
            // var_dump(array_search(false, $userInfo));

            $addedUserId = $u->addUser();
            $_SESSION['userid'] = $addedUserId;
        } else {
            echo 'failed';
        }
    }
}
