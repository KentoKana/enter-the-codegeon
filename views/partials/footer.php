
    </div> <!-- end flex wrapper-->
  </div> <!-- end page wrapper-->
  <footer>
    <div class="wrapper">
      <div class="flex-wrapper">

      </div>
    </div>
  </footer>
  <?php
  if($page == "play" || $page == "stage-builder"):?>
  <script src="public/scripts/player.js" ></script>
  <script src="public/scripts/canvas.js" ></script>
    <?php if($page == "play"):?>
      <script src="public/scripts/maze.js" ></script>
      <script src="public/scripts/maze-main.js" ></script>
    <?php elseif($page == "stage-builder"): ?>
      <script src="public/scripts/maze-builder.js" ></script>
      <script src="public/scripts/maze-builder-main.js" ></script>
    <?php endif;?>
  <?php endif;?>
</body>
</html>
