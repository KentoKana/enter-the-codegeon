<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './vendor/autoload.php';
require_once './controllers/user-controller.php';
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Enter the Codegeon</title>
    <meta charset="utf-8">
</head>

<body>
    <h1>Register</h1>
    <p><span class="field__required">*</span> are required fields.</p>
    <div>
        <form action="" method="POST">
            <div>
                <div>
                    <label for="register__firstName"><span class="field__required">*</span>First Name:</label>
                </div>
                <div>
                    <input type="text" name="firstName" id="register__firstName">
                </div>
            </div>
            <div>
                <div>
                    <label for="register__lastName"><span class="field__required">*</span>Last Name:</label>
                </div>
                <div>
                    <input type="text" name="lastName" id="register__lastName">
                </div>
            </div>
            <div>
                <div>
                    <label for="register__username"><span class="field__required">*</span>Username:</label>
                </div>
                <div>
                    <input type="text" name="username" id="register__username">
                </div>
            </div>
            <div>
                <div>
                    <label for="register__email"><span class="field__required">*</span>Email:</label>
                </div>
                <div>
                    <input type="text" name="email" id="register__email">
                </div>
            </div>
            <div>
                <div>
                    <label for="register__password"><span class="field__required">*</span>Password:</label>
                </div>
                <div>
                    <input type="password" name="password" id="register__password">
                </div>
            </div>
            <div>
                <div>
                    <label for="register__password_confirm"><span class="field__required">*</span>Confirm Your Password:</label>
                </div>
                <div>
                    <input name="passwordConfirm" type="password" id="register__password_confirm">
                </div>
            </div>
            <button type="submit" name="submitRegister"> Register</button>
        </form>
    </div>
</body>

</html>