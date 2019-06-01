<?php
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Stage Builder</title>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/more.css">
</head>
<body>
  <div class="page-wrapper">
    <h1>Welcome to Stage Builder</h1>
    <div id="message-area">Start building your stage!</div>
  </div>
  <div class="page-wrapper flex-container">
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
  </div>
  
  <script src="scripts/player.js" ></script>
  <script src="scripts/canvas.js" ></script>
  <script src="scripts/maze-builder.js" ></script>
  <script src="scripts/maze-builder-main.js" ></script>
</body>
</html>