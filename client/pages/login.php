<?php

require_once("../../server/user.php");

$message = "";

$fullname = "";
$user_name = "";
$email = "";

$login_checked = "checked";
$signin_checked = "";


if( isset( $_POST['signin'] ) && $_POST['signin'] == '1' ) {

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
if ( session_status() !== PHP_SESSION_ACTIVE ) {
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
  <link rel="stylesheet" href="/client/assets/css/login.css"/>
  <title>Form</title>
  <meta charset="utf-8">
</head>
<body>
  <div class="login-wrap">
    <div class="login-html">
      <input id="tab-1" type="radio" name="tab" class="sign-in" <?php echo $login_checked; ?>><label for="tab-1" class="tab">Bejelentkezés</label>
      <input id="tab-2" type="radio" name="tab" class="sign-up"  <?php echo $signin_checked; ?>><label for="tab-2" class="tab">Regisztráció</label>
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
            <input id="check" name="stay_signed" type="checkbox" class="check" checked>
            <label for="check"><span class="icon"></span> Maradjak bejelentkezve</label>
          </div>
          <div class="group">
            <input type="submit" class="button" value="Bejelentkezés">
          </div>
          <div class="hr"></div>
          <div class="foot-lnk">
            <a href="#forgot">Elfelejtette jelszavát?</a>
          </div>
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
          <div class="foot-lnk">
            <label for="tab-1">Már regisztrált?</a>
          </div>
          <input type="hidden" name="signup" value="1">
        </form>
        <div style="
            position: absolute;
            right: 0;
        ">
            <?php
                echo $message;
            ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>