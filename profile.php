<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
require_once './controllers/user-controller.php';
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
    <!-- Test Image File -->
    <img src="./images/user.png" alt="User Profile" width="100">
    <form action="" method="POST">
      <button type="submit" name="logout">Log out</button>
    </form>
    <div class="profile__playGame">
      <h2><a href="./stage-picker.php">Play Enter the Codegeon!</a></h2>

    </div>
    <div class="profile__achievements">
      <h2>Achievements</h2>
      <?php
        $testArr = [
          'Achievement1',
          'Achievement2',
          'Achievement3',
          'Achievement4',
          'Achievement5'
        ];

        foreach($testArr as $item) {
          echo "<div>$item</div>";
        }
      ?>

    </div>
  </div>
</body>

</html>