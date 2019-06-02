<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
require_once './controllers/stage-controller.php';

?>
<!DOCTYPE html>
<html lang='en'>

<head>
  <title>Enter the Codegeon</title>
  <meta charset="utf-8">
</head>

<body>
  <div>
    <h1>Select Your Challenge!</h1>
    <form action="" method="POST">
      <?php
      // Iterate through all stage items.

      foreach ($allStages as $stage) {
        ?>
        <button type="submit" name="stageId" value="<?= $stage['_id']; ?>"> <?= $stage['stageName']; ?> </button>
      <?php
    }
    ?>
    </form>
    <?=
      $obs_coords;
    ?>


  </div>
</body>

</html>
