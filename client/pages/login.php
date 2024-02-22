<?php

require_once("../../server/user.php");

$message = "";

$fullname = "";
$user_name = "";
$email = "";

$login_checked = "checked";
$signin_checked = "";


if(isset( $_POST['signin'] ) && $_POST['signin'] == '1') {

    $message = login_user(
        $_POST['user_name'],
        $_POST['password']
    );

} else if(isset( $_POST['signup'] ) && $_POST['signup'] == '1') {
    $fullname = $_POST['fullname'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];

    $login_checked = "";
    $signin_checked = "checked";

    $message = registration(
        $_POST['fullname'],
        $_POST['user_name'],
        $_POST['password'],
        $_POST['password_again'],
        $_POST['email']
    );
}

/**
 * If the user already logged in redirect to main page.
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    header('Location: /');
    exit();
}

?>


<!DOCTYPE html>
<html lang="hu">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/client/assets/css/login.css" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="login-wrap">
        <div class="login-html">
            <a href="/"><h1 class="page-name">Flavora</h1></a>
            <input id="tab-1" type="radio" name="tab" class="sign-in" <?php echo $login_checked; ?>><label for="tab-1"
                class="tab">Bejelentkezés</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up" <?php echo $signin_checked; ?>><label for="tab-2"
                class="tab">Regisztráció</label>
                <div class="login-form">
            <form action="" method="post" class="sign-in-htm">
                <div class="group">
                    <label for="user" class="label">Felhasználónév</label>
                    <input id="user" name="user_name" type="text" class="input">
                </div>
                <div class="group">
                    <label for="pass" class="label">Jelszó</label>
                    <input id="pass" name="password" type="password" class="input" data-type="password">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Bejelentkezés">
                </div>
                <div class="hr"></div>
                <input type="hidden" name="signin" value="1">
            </form>

            <form action="" method="post" class="sign-up-htm">
                <div class="group">
                    <label for="fullname" class="label">Teljes név</label>
                    <input id="fullname" name="fullname" type="text" class="input" value="<?php echo $fullname; ?>">
                </div>
                <div class="group">
                    <label for="user" class="label">Felhasználónév</label>
                    <input id="user" name="user_name" type="text" class="input" value="<?php echo $user_name; ?>">
                </div>
                <div class="group">
                    <label for="password" class="label">Jelszó</label>
                    <input id="password" name="password" type="password" class="input" data-type="password">
                </div>
                <div class="group">
                    <label for="password_again" class="label">Jelszó ismét</label>
                    <input id="password_again" name="password_again" type="password" class="input" data-type="password">
                </div>
                <div class="group">
                    <label for="email" class="label">Email cím</label>
                    <input id="email" name="email" type="email" class="input" value="<?php echo $email; ?>">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Regisztráció">
                </div>
                <div class="hr"></div>
                <input type="hidden" name="signup" value="1">
            </form>
        </div>
        <div class="error" role="alert">
                <?php echo $message; ?>
            </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var registrationTab = document.getElementById('tab-2');
    var errorElements = document.querySelectorAll('.error');

    function adjustErrorStyling() {
        if(registrationTab.checked) {
            errorElements.forEach(function(errorElement) {
                errorElement.style.marginTop = '130px';
            });
        } else {
            errorElements.forEach(function(errorElement) {
                errorElement.style.marginTop = '';
            });
        }
    }
    registrationTab.addEventListener('change', adjustErrorStyling);

    adjustErrorStyling();
});
</script>


</body>

</html>