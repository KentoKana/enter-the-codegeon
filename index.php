<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
$client = new MongoDB\Client(env('MONGO_URI'));
$googleLoginBtn = "";

if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
  // redirect to profile
  header('Location: profile.php');
} else {
  return $googleLoginBtn = '<a href="googleauth.php"><img src="images/btn_google_signin_light_normal_web.png" alt="login with google button"/></a>';
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
  <title>Enter the Codegeon</title>
  <meta charset="utf-8">
</head>

<body>
  <form action='' method='POST'>
    <input type='text'>
    <input type='password'>
    <button type="submit">Login</button>
    <?= $googleLoginBtn ?>
  </form>
</body>

</html>