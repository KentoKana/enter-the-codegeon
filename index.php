<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
$client = new MongoDB\Client(env('MONGO_URI'));

if(isset($_SESSION['userid']) && !empty($_SESSION['userid']))
{
  // redirect to profile
  header('Location: profile.php');
}
else
{
  echo '<a href="googleauth.php"><img src="images/btn_google_signin_light_normal_web.png" alt="login with google button"/></a>';
}
?>
