<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
if(!isset($_SESSION['userid'])){
  header('location: index');
}
 ?>
 <div class="profile__info">
   <h1>Welcome, <?= (string)$user->firstName ?></h1>
   <!-- Test Image File -->
   <img src="public/images/user.png" alt="User Profile" width="100">
   <form action="./" method="POST">
     <button type="submit" name="logout">Log out</button>
   </form>
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

     foreach($testArr as $item) {
       echo "<div class='achievements__item'>$item</div>";
     }
   ?>

 </div>
<?php
require_once 'partials/footer.php';
