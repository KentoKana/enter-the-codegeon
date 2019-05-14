<?php
session_start();
require_once './vendor/autoload.php';
// connect to mongoDB
$client = new MongoDB\Client(env('MONGO_URI'));

// access the collection
$collection = $client->codegen->users;

if(isset($_GET['logout']))
{
  session_destroy();
  header('Location: index.php');
}

if(isset($_SESSION['userid']))
{
  $id = $_SESSION['userid'];
  // search the user
  $user = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId("$id")]);
  echo "Welcome, " . (string)$user->firstName;
  echo '<br><a href="profile.php?logout">Log out</a>';
}
else {
  header('Location: index.php');
}
