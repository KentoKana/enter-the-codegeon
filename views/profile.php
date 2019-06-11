<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
if (!isset($_SESSION['userid'])) {
  header('location: index');
}
?>
<div class="profile">
  <div class="profile__info">
    <h1>Welcome, <?= (string)$user->firstName ?></h1>
    <!-- Test Image File -->
    <img src="<?= getUserImage($client->codegen->users, $_SESSION['userid']); ?>" alt="User Profile" width="200">
    <div class="profile__editProfile">
      <a href="user-edit" class="changepic-btn"><i class="fas fa-id-card"></i> Edit Your Information</a>
      <button type="button" id="changepic" class="changepic-btn" name="button"><i class="fas fa-id-badge"></i> Change Profile Picture</button>
    </div>
    <div class="left changepic">
      <form action="" method="POST" enctype="multipart/form-data">
        <div>
          <label for="user-immage">Change your profile picture: </label>
        </div>
        <div>
          <input type="file" class="flat-btn" name="image" id="user-image">
        </div>
        <div>
          <input type="submit" class="flat-btn upload" value="Upload Image">
        </div>
      </form>
    </div>
  </div>
  <div class="profile__playGame">
    <a href="./stage-picker" class="border-btn"><i class="fas fa-gamepad"></i>  Play Enter the Codegeon!</a>
    <a href="stage-builder" class="border-btn"><i class="fas fa-tools"></i>  Build a Challenge!</a>
  </div>
  <div class="profile__achievements">
    <h2>Achievements</h2>
    <?php
    $testArr = [
      'codegeon-newbie.png',
      'first-unsolved-puzzle.png',
      'quick-solver.png',
      'hot-streak.png',
    ];

    foreach ($testArr as $item) {
      echo "<div class='achievements__item'><img src='public/images/$item'></div>";
    }
    ?>
  </div>
  <div class="block">
    <form action="" method="POST">
      <button type="submit" name="deleteProfile" class="flat-btn delete"><i class="fas fa-exclamation-circle"></i> Delete Your Profile</button>
    </form>
  </div>
</div>

<?php
require_once 'partials/footer.php';
