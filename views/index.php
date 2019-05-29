<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
if(isset($_SESSION['userid'])){
  header('location: profile');
}
?>
<header class="block">
    <h1 class="charcoal">Enter the Codegeon</h1>
</header>
<section class="block">
  <form action="" method="POST" class="login__form">
    <h2>Login</h2>
    <div class="form__block">
      <label for="form__username">Username/Email:</label>
    </div>
    <div class="form__block">
      <input type="text" name="username" id="form__username">
    </div>
    <div class="form__block">
      <label for="form__password">Password:</label>
    </div>
    <div class="form__block">
      <input name="password" type="password" id="form__password">
    </div>
    <div class="err">
      <?= $errorMsg; ?>
    </div>
    <div class="form__block">
      <button type="submit" name="submitLogin"> Login</button>
    </div>
    <div class="form__block">
      <a href="googleauth.php"><img src="public/images/btn_google_signin_light_normal_web.png" alt="login with google button"/></a>
    </div>
  </form>
</section>

<?php require_once 'partials/footer.php';
