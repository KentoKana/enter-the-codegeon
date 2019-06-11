<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
if(!isset($_SESSION['userid'])){
  header('location: index');
}
?>
<style media="screen">
  .stage-button {max-width: 100%; width: 100%;flex: 1 100%;}
  .stage {
    flex: 1 0 0;
    display: flex;
    align-items: flex-start;
    max-width: 50%;
  }

  .stage-link,
  .stage-description {
    flex: 1 50%;
    padding: 20px;
  }

  .stage-description td {word-break: break-word;}

  #challenge-canvas {width: 100%;}

  .stage-description table{ margin: auto;}

  #stage-form .flex-wrapper {
    align-items: flex-start;
    justify-content: flex-start;
    flex: 1 100%;
    margin: 20px auto;
  }
</style>
<header class="block">
  <h1 class="charcoal">Select Your Challenge!</h1>
</header>
<div class="block">
  <form id="stage-form" action="" method="POST">
    <?php
    // Iterate through all stage items.
    // I used an array chunk to add a div every 4 items
    $arr = $allStages->toArray();
    foreach(array_chunk($arr, 2) as $stages) {
      echo '<div class="flex-wrapper">';
      foreach ($stages as $stage) { ?>
        <div class="stage">
          <div class="stage-link">
            <button class="stage-button" type="submit" name="playStage" value="<?= $stage['_id']; ?>">
              <h3><?= $stage['stageName']; ?></h3>
            </button>
          </div>
          <div class="stage-description">
            <table>
              <caption>
                <h3>High Score</h3>
              </caption>
              <tr>
                <th></th>
                <th>Player</th>
                <th>Moves</th>
              </tr>
              <tr>
                <?php foreach ($stage['userScores'] as $player => $score ) { ?>
                    <tr>
                      <td><img src="<?= getUserImage($client->codegen->users, $player) ?>" alt="User Profile" width="50"></td>
                      <td><?= $u->getCurrentUser($player)['username']; ?></td>
                      <td><?= $score ?></td>
                    </tr>
                <?php } ?>
              </tr>
            </table>
          </div>
        </div>

      <?php
    }
    echo '</div>';
    }
  // Once user chooses stage, send the stageId to play.php
  ?>
  </form>
</div>
<?php
require_once 'partials/footer.php';
