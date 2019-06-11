<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
if(!isset($_SESSION['userid'])){
  header('location: index');
}
 ?>
<header class="block">
  <h1 class="charcoal">Welcome to Stage Builder</h1>
  <div id="message-area">Start building your stage!</div>
</header>
<div id="playing-area"></div>
<div id="coding-area">
  <h2>Options</h2>
  <div id="builder-options">
    <div class="option-row">
      <label for="stage-name">Stage Name: </label>
      <input type="text" id="stage-name" placeholder="Enter a stage name">
    </div>

    <div class="option-row">
      <input type="radio" id="player-option" name="builder_options" value="0">
      <span>Goal</span>
    </div>
    <div class="option-row">
      <input type="radio" id="goal-option" name="builder_options" value="1">
      <span>Player</span>
    </div>
    <div class="option-row">
      <input type="radio" id="obstacle-option" name="builder_options" value="2">
      <span>Obstacles</span>
    </div>
    <div class="option-row">
      <input type="radio" id="obstacle-option" name="builder_options" value="3">
      <span>Remove</span>
    </div>

    <button id="check-solution">Check for Solution</button>
    <button id="submit-stage" disabled>Build Stage!</button>
  </div>
</div>
<?php
require_once 'partials/footer.php';
