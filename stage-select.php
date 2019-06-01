<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
// require_once './controllers/user-controller.php';
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
        <input type="hidden" value="<?= $stage['_id']; ?>" name="stageId" />
        <button type="submit" name="chooseChallenge"> <?= $stage['stageName']; ?> </button>
      <?php
    }
    ?>
    </form>
    <?php if (isset($_POST['chooseChallenge'])) { ?>
      <div>
        <?php
        // Loop through array of obstacle coords
        // Display coords as strings
        // Each "cell" is separated by semicolons (;)
        // X and Y separated by commas.
        //i.e. x1,y1;x2,y2;x3,y3;
        $obs_coords = '';

        // THIS IS NULL FOR WHATEVER REASON.
        $pickedStage = $collection->findOne(['_id' => $_POST['stageId']]);
        
        foreach ($pickedStage['obstacles'] as $obstacle) {
          for ($i = 0; $i < count($obstacle); $i++) {
            if ($i % 2 !== 0) {
              $obs_coords .= $obstacle[$i] . ';';
            } else {
              $obs_coords .= $obstacle[$i] . ',';
            }
          }
        }
        echo $obs_coords;
        ?>
      </div>
    <?php } ?>


  </div>
</body>

</html>