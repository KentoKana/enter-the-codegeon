<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
$client = new MongoDB\Client(env('MONGO_URI'));
$googleLoginLink = '';

if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
  // redirect to profile
  header('Location: profile.php');
} else {
  $googleLoginLink = '<a href="googleauth.php"><img src="images/btn_google_signin_light_normal_web.png" alt="login with google button"/></a>';
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
  <title>Enter the Codegeon</title>
  <meta charset="utf-8">
</head>

<body>
  <div>
    <h1>Enter the Codegeon</h1>
    <form action="" method="POST">
      <h2>Login</h2>
      <div>
        <label for="form__username">Username/Email:</label>
        <input type="text" name="username" id="form__username">
      </div>
      <div>
        <label for="form__password">Password:</label>
        <input name="password" type="password" id="form__password">
      </div>
      <button type="submit" name="submitLogin"> Login</button>
      <?= $googleLoginLink ?>
    </form>
  </div>
</body>

</html>