<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
if(!isset($_SESSION['userid'])){
  header('location: index');
}
?>
<!-- Retrieve Coordinates to generate challenge -->
<input type="hidden" id="stageId" class="stage-info" value="<?=$_SESSION['stageId']?>">
<input type="hidden" id="startCoord" class="stage-info" value="<?=$_SESSION['startCoord']?>">
<input type="hidden" id="goalCoord" class="stage-info" value="<?=$_SESSION['goalCoord']?>">
<input type="hidden" id="obsCoords" class="stage-info" value="<?=$_SESSION['obsCoords']?>">
<input type="hidden" id="solution" class="stage-info" value="<?=$_SESSION['solution']?>">

<header class="block">
  <h1 id="score"><?=$_SESSION['stageName']?></h1>
</header>
<div id="playing-area"></div>
<div id="coding-area">
  <div class="btn__block">
    <button id="turn-left" value="0" class="movement-buttons">Turn Left</button>
    <button id="move-forward" value="1" class="movement-buttons">Move Forward</button>
    <button id="turn-right" value="2" class="movement-buttons">Turn Right</button>
  </div>
  <div class="btn__block">
    <button id="undo-button" class="action-buttons">Undo Move</button>
    <button id="start-button" class="action-buttons">Run</button>
    <button id="quit-button" class="action-buttons">Quit Game</button>
  </div>
  <div id="play">
    <header>
      <h2 class="charcoal">Actions</h2>
    </header>
    <div id="move-list"></div>
  </div>
</div>

<div id="result-modal">
  <div class="flex-wrapper">
    <div id="result-score" class="block"></div>
    <div class="block">
      <button id="retry-button" class="end-buttons flat-btn"><i class="fas fa-redo"></i>  Retry</button>
      <button id="return-button" class="end-buttons flat-btn"><i class="fas fa-sign-out-alt"></i>  Back to Stage Select</button>
    </div>
  </div>
</div>
<?php
require_once 'partials/footer.php';
