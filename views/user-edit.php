<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
// if(!isset($_SESSION['userid'])){
//   header('location: index');
// }
echo $_SESSION['userId'];
 ?>
<header class="block">
  <h1 class="charcoal">Edit You Information</h1>
  <p><span class="field__required">*</span> are required fields.</p>
</header>
<div class="block">
  <form action="" method="POST" class="registration__form">
    <div class="form__block">
        <label for="register__firstName"><span class="field__required">*</span>First Name:</label>
    </div>
    <div class="form__block">
        <input type="text" name="firstName" id="register__firstName">
    </div>
    <div class="form__block">
        <label for="register__lastName"><span class="field__required">*</span>Last Name:</label>
    </div>
    <div class="form__block">
        <input type="text" name="lastName" id="register__lastName">
    </div>
    <div class="form__block">
        <label for="register__username"><span class="field__required">*</span>Username:</label>
    </div>
    <div class="form__block">
        <input type="text" name="username" id="register__username">
    </div>
    <div class="form__block">
        <label for="register__email"><span class="field__required">*</span>Email:</label>
    </div>
    <div class="form__block">
        <input type="text" name="email" id="register__email">
    </div>
    <div class="form__block">
        <label for="register__password"><span class="field__required">*</span>Password:</label>
    </div>
    <div class="form__block">
        <input type="password" name="password" id="register__password">
    </div>
    <div class="form__block">
        <label for="register__password_confirm"><span class="field__required">*</span>Confirm Your Password:</label>
    </div>
    <div class="form__block">
        <input name="passwordConfirm" type="password" id="register__password_confirm">
    </div>
    <div class="form__block">
        <button type="submit" name="submitRegister"> Register</button>
    </div>
  </form>
</div>
<?php
require_once 'partials/footer.php';
