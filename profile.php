<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
require_once './controllers/user-controller.php';
if(!isset($_SESSION['userid'])){
  header('location: index.php');
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
    <h1>Welcome, <?= (string)$user->firstName ?></h1>
    <form action="" method="POST">
      <button type="submit" name="logout">Log out</button>
    </form>
  </div>
</body>

</html>
