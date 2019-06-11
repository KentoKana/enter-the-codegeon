<?php
require_once 'partials/header.php';
require_once 'partials/navigation.php';
if(!isset($_SESSION['userid'])){
  header('location: index');
}
?>
<header class="block">
    <h1 class="charcoal">Edit You Information</h1>
    <p><span class="field__required">*</span> are required fields.</p>
</header>
<div class="block">
    <form action="" method="POST" class="registration__form">
        <!-- General Error Message -->
        <p><?= $errorMsg; ?></p>

        <div class="form__block">
            <label for="register__firstName"><span class="field__required">*</span>First Name:</label>
        </div>
        <div class="form__block">
            <?= validationMsg('fname', 'first name'); ?>
            <input type="text" name="firstName" id="register__firstName" value="<?= (!$_POST?$user['firstName']:$_POST['firstName']) ?>">
        </div>
        <div class="form__block">
            <label for="register__lastName"><span class="field__required">*</span>Last Name:</label>
        </div>
        <div class="form__block">
            <?= validationMsg('lname', 'last name'); ?>
            <input type="text" name="lastName" id="register__lastName" value="<?= (!$_POST?$user['lastName']:$_POST['lastName']) ?>">
        </div>
        <div class="form__block">
            <label for="register__username"><span class="field__required">*</span>Username:</label>
        </div>
        <div class="form__block">
            <?= validationMsg('username', 'username'); ?>
            <input type="text" name="username" id="register__username" value="<?=(!$_POST?$user['username']:$_POST['username']) ?>">
        </div>
        <div class="form__block">
            <label for="register__email"><span class="field__required">*</span>Email:</label>
        </div>
        <div class="form__block">
            <?= validationMsg('email', 'e-mail'); ?>
            <input type="text" name="email" id="register__email" value="<?= (!$_POST?$user['email']:$_POST['email']) ?>">
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
            <button type="submit" name="submitUserEdit"> Edit!</button>
            <div>
                <a href="profile">Cancel</a>
            </div>
        </div>
    </form>
</div>
<?php
require_once 'partials/footer.php';
