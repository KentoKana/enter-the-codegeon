<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
if (!isset($_SESSION['userid'])) {
  header('location: index');
}
?>
<div class="profile__info">
  <h1>Welcome, <?= (string)$user->firstName ?></h1>
  <!-- Test Image File -->
  <img src="<?=$userImgSrc?>" alt="User Profile" width="200">
  <div>
    <form action="" method="POST" enctype="multipart/form-data">
      <div>
        <label for="user-immage">Change your profile picture: </label>
      </div>
      <div>
        <input type="file" name="image" id="user-image">
      </div>
      <div>
        <input type="submit" value="Upload Image">
      </div>
    </form>

  </div>
</div>
<div class="profile__playGame">
  <h2><a href="./stage-picker">Play Enter the Codegeon!</a></h2>
</div>
<div class="profile__editProfile">
  <h3><a href="user-edit">Edit Your Information</a></h3>
</div>
<div class="profile__editProfile">
  <h3><a href="stage-builder">Build a Challenge!</a></h3>
</div>
<div class="profile__achievements">
  <h2>Achievements</h2>
  <?php
  $testArr = [
    'Achievement1',
    'Achievement2',
    'Achievement3',
    'Achievement4',
    'Achievement5'
  ];

  foreach ($testArr as $item) {
    echo "<div class='achievements__item'>$item</div>";
  }
  ?>

</div>
<?php
require_once 'partials/footer.php';
