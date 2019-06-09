<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
// if(!isset($_SESSION['userid'])){
//   header('location: index');
// }
?>
<header class="block">
  <h1 class="charcoal">Select Your Challenge!</h1>
</header>
<div class="block">
  <form id="stage-form" action="" method="POST">
    <?php
    // Iterate through all stage items.
    foreach ($allStages as $stage) {
      ?>

      <button class="stage-button" type="submit" name="playStage" value="<?= $stage['_id']; ?>">
        <!-- <canvas class="stage-preview"></canvas> -->
        <h3><?= $stage['stageName']; ?></h3>
      </button>
      <div>
        <table>
          <caption>
            <h3>High Score</h3>
          </caption>
          <tr>
            <th>Player</th>
            <th>Number of Moves to Complete This Stage</th>
          </tr>
          <tr>
            <?php foreach ($stage['userScores'] as $player => $score) { ?>
            <tr>
              <td><?= $u->getCurrentUser($player)['username']; ?></td>
              <td><?= $score ?></td>
            </tr>
          <?php } ?>
          </tr>
        </table>
      </div>


    <?php
  }
  // Once user chooses stage, send the stageId to play.php
  ?>
  </form>
</div>
<?php
require_once 'partials/footer.php';
