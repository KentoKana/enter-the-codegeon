<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
echo 'hello';

?>
<!-- <!DOCTYPE html>
<html lang='en'>

<head>
  <title>Enter the Codegeon</title>
  <meta charset="utf-8">
</head>

<body>
    <h1>Hello</h1>
  <div>
    <form action="" method="POST">
      <h2>Register</h2>
      <div>
        <label for="form__username">Username/Email:</label>
        <input type="text" name="username" id="form__username">
      </div>
      <div>
        <label for="form__password">Password:</label>
        <input name="password" type="password" id="form__password">
      </div>
      <button type="submit" name="submitLogin"> Login</button>
    </form>
  </div>
</body>

</html> -->