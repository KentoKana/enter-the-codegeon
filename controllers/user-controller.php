<?php
require_once './Models/User.php';
$client = new MongoDB\Client(env('MONGO_URI'));
$collection = $client->codegen->users;

// If userid session is set, redirect to profile.php.
if (isset($_SESSION['userid'])) {
    header('location: ./profile.php');
}



//Registration Controller 
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

    $errorMsg = '';

    //Check if user who is about to register already exists in the DB.
    $registeringUser = $collection->findOne(['username' => $username]);
    $registeringUserEmail = $collection->findOne(['email' => $email]);

    if ($registeringUser || $registeringUserEmail) {
        if ($registeringUser) {
            $errorMsg .= 'User Already Exists. <br>';
        }
        if ($registeringUserEmail) {
            $errorMsg .= 'Email Already Registered. <br>';
        }
        echo $errorMsg;
    } else {
        // If no userInfo items return false, write to the database.
        if (array_search(false, $userInfo) === false) {
            $addedUserId = $u->addUser();
            $_SESSION['userid'] = $addedUserId;
            // echo $_POST['password'];
        } else {
            echo 'failed';
        }
    }
}

//Login System Controller
if (isset($_POST['submitLogin'])) {
    // Set User Info
    $u = new User($collection);
    $u->setUsername($_POST['username']);
    $u->setLoginPass($_POST['password']);

    // Get User Info
    $username = $u->getUsername($_POST['username']);
    $password = $u->getLoginPass($_POST['password']);

    //Retrieve User Document from DB
    $loggingInUser = $collection->findOne(['username' => $username]);
    $loggingInUserEmail = $collection->findOne(['email' => $username]);

    if (
        password_verify($password, $loggingInUserEmail['password']) 
    ) {
        echo 'Login Successful!';
        $_SESSION['userid'] = $loggingInUserEmail['_id'];
        
    } elseif( password_verify($password, $loggingInUser['password'])){
        echo 'Login Successful!';
        $_SESSION['userid'] = $loggingInUser['_id'];
    } else {
        echo 'no match';
    }
}
