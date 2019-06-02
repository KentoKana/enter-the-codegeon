<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
// if(!isset($_SESSION['userid'])){
//   header('location: index');
// }
 ?>
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
  <div id="move-list" class="block">Move List: </div>
</div>
<?php
require_once 'partials/footer.php';
