<?php
session_start();
require_once './Models/User.php';
$client = new MongoDB\Client(env('MONGO_URI'));
$collection = $client->codegen->users;
$errorMsg = '';
$userInfo = [
    'fname' => '',
    'lname' => '',
    'username' => '',
    'initialPass' => '',
    'password' => '',
    'email' => '',
];

// Functions
function validationMsg($input, $fieldName)
{
    global $userInfo;
    $msg = "<br> Please enter a valid $fieldName";
    //Should be checking for False, but variables return NULL instead for first name:/ 
    //Apologies - I'll try to fix it when the validation works at minimum level.
    if ($userInfo[$input] === NULL || $userInfo[$input] === false) {
        return $msg;
    }
}

if (isset($_SESSION['userid'])) {
    $u = new User($collection);
    $user = $u->getCurrentUser($_SESSION['userid']);

    //Get Image Extension and Base64 Image 
    $userImage = $user['image'];
    $userImage = explode(';', $userImage);
    // userImage[0] is image extension
    // userImage[1] is base64 encoded string
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

    if ($_POST['password'] === '') {
        $userInfo['initialPass'] = false;
    } else {
        $userInfo['initialPass'] = $_POST['password'];
    }

    // Get User Info
    $userInfo['fname'] = $u->getFirstName();
    $userInfo['lname'] = $u->getLastName();
    $userInfo['username'] = $u->getUsername();
    $userInfo['password'] = $u->getRegisterPassword();
    $userInfo['email'] = $u->getEmail();

    //Check if user who is about to register already exists in the DB.
    $registeringUser = $collection->findOne(['username' => $userInfo['username']]);
    $registeringUserEmail = $collection->findOne(['email' => $userInfo['email']]);

    if ($registeringUser || $registeringUserEmail) {
        if ($registeringUser) {
            $errorMsg .= 'User Already Exists. <br>';
        }
        if ($registeringUserEmail) {
            $errorMsg .= 'Email Already Registered. <br>';
        }
    } else {
        // If no userInfo items return false, write to the database.
        if (array_search(false, $userInfo) === false) {
            $addedUserId = $u->addUser();
            $_SESSION['userid'] = $addedUserId;
        } else {
            var_dump($_POST['password']);
            $errorMsg .= 'Please review the form and try again.<br>';
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

    // Login Validation Control.
    if (empty($username) && empty($password)) {
        $errorMsg = "Please enter your username and password.";
    } elseif (empty($username)) {
        $errorMsg = "Please enter your username.";
    } elseif (empty($password)) {
        $errorMsg = "Please enter your password.";
    } elseif (password_verify($password, $loggingInUserEmail['password'])) {
        $_SESSION['userid'] = $loggingInUserEmail['_id'];
    } elseif (password_verify($password, $loggingInUser['password'])) {
        $_SESSION['userid'] = $loggingInUser['_id'];
        header('location: ./profile.php');
    } else {
        $errorMsg = 'Username/E-mail and password does not match.';
    }

    if (isset($_SESSION['userid'])) {
        header('location: ./profile.php');
    }
}

// If userid session is set, redirect to profile.php.
if (isset($_SESSION['userid'])) {
    $u = new User($collection);
    $id = $_SESSION['userid'];
    // search the user
    $user = $u->getCurrentUser($id);

    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: /');
    }
}

// User Edit Controller
if (isset($_POST['submitUserEdit'])) {
    $u = new User($collection);
    $id = $_SESSION['userid'];
    // search the user
    $user = $u->getCurrentUser($id);

    $u->setFirstName($_POST['firstName']);
    $u->setLastName($_POST['lastName']);
    $u->setEmail($_POST['email']);
    $u->setUsername($_POST['username']);
    $u->setEditPassword($_POST['password'], $_POST['passwordConfirm']);

    $userInfo['fname'] = $u->getFirstName();
    $userInfo['lname'] = $u->getLastName();
    $userInfo['username'] = $u->getUsername();
    $userInfo['email'] = $u->getEmail();

    // Need to add logic to disallow the user to change their username/email
    // to something that already exist in another user's profile.
    #Logic:
    #Check if the entered username/email is not the same as the currently registered username/email for the current user.
    #If not, check if the newly entered username/email exists in the database already for any other users.
    #If both these conditions return false, then allow the edit.

    // Manipulate userInfo array - get rid of password edit.
    // At the moment, if password field is left blank, 
    // User's previous password is kept. 
    unset($userInfo['password']);
    unset($userInfo['initialPass']);

    if (array_search(false, $userInfo) === false) {
        $u->editUser();
    } else {
        return $errorMsg = 'Please review the form and try again';
    }

    header('Location: profile');
}

// Image uploading
if (isset($_FILES['image'])) {
    $u = new User($collection);
    $id = $_SESSION['userid'];
    // search the user
    $user = $u->getCurrentUser($id);
    $ext = '';
    if ($_FILES['image']['error'] == 0) {
        $name = $_FILES["image"]["name"];
        $explodedStr = explode(".", $name);
        // get file extension of image being uploaded
        $ext = end($explodedStr);
        $file = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    } else {
        $file = '';
    }

    // Get ext and base64 as one string separated by ;
    $file = $ext . " ; " . $file;
    
    // Add Base64 image to MongoDB
    $u->addUserImage($file);

    // Prevent multiple image submission
    header('Location: profile');
}
