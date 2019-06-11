
    </div> <!-- end flex wrapper-->
  </div> <!-- end page wrapper-->
  <footer>
    <div class="wrapper">
      <div class="flex-wrapper">

      </div>
    </div>
  </footer>
  <?php
  if($page == "play" || $page == "stage-picker" || $page == "stage-builder"):?>
  <script src="public/scripts/player.js" ></script>
  <script src="public/scripts/canvas.js" ></script>
    <?php if($page == "play"):?>
      <script src="public/scripts/maze.js" ></script>
      <script src="public/scripts/maze-main.js" ></script>
    <?php elseif($page == "stage-picker"): ?>
      <script src="public/scripts/maze.js" ></script>
      <script src="public/scripts/stage-picker-main.js" ></script>
    <?php elseif($page == "stage-builder"): ?>
      <script src="public/scripts/maze-builder.js" ></script>
      <script src="public/scripts/maze-builder-main.js" ></script>
    <?php endif;?>
  <?php endif;?>
  <?php if($page == "profile"):?>
    <!-- <script src="public/scripts/profile.js"></script> -->
    <script>
    const changepic_form = document.querySelector('.changepic');
    const changepic = document.querySelector("#changepic");

      changepic.addEventListener('click', () => {
        if(changepic_form.classList.contains('left')) {
          changepic_form.classList.remove('left');
        } else {
          changepic_form.classList.add('left');
        }
      });
    </script>
  <?php endif;?>
</body>
</html>
