<?php
require_once './Models/User.php';
$client = new MongoDB\Client(env('MONGO_URI'));

if (isset($_POST['submitRegister'])) {
    $u = new User($client->codegen->users);
    $u->setFirstName($_POST['firstName']);
    $u->setLastName($_POST['lastName']);
    $u->setUsername($_POST['username']);
    $u->setPassword($_POST['password'], $_POST['passwordConfirm']);
    $u->setEmail($_POST['email']);

    $fname = $u->getFirstName();
    $lname = $u->getLastName();
    $username = $u->getUsername();
    $password = $u->getPassword();
    $email = $u->getEmail();

    $userInfo = [
        $fname,
        $lname,
        $username,
        $password,
        $email
    ];

    if (array_search(false, $userInfo) == false) {
        $u->addUser();
        echo 'success!';
    }
}
