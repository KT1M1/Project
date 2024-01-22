<?php
const MINIMUM_NAME_LENGTH = 4;
const MINIMUM_USER_NAME_LENGTH = 4;
const MINIMUM_PASSWORD_LENGTH = 8;

require_once(__DIR__ . "/db.php");


function validate_user_data ($full_name, $user_name, $password, $password_again, $email) {
    $error_msg = "";

    if (empty($full_name)) {
        $error_msg .= "A név megadása kötelező!\n";
    } elseif ( strlen( $full_name ) < MINIMUM_NAME_LENGTH ) {
        $error_msg .= "A név minimum " . MINIMUM_NAME_LENGTH . " karakter.\n";
    }

    if ( empty( $user_name ) ) {
        $error_msg .= "A felhasználónév megadása kötelező!\n";
    } elseif ( strlen( $user_name ) < MINIMUM_USER_NAME_LENGTH ) {
        $error_msg .= "A felhasználónév minimum " . MINIMUM_USER_NAME_LENGTH . " karakter.\n";
    }

    if ( empty( $email ) ) {
        $error_msg .= "Az email megadása kötelező!\n";
    } elseif ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        $error_msg .= "Helytelen email formátum!\n";
    }

    if ( empty( $password ) ) {
        $error_msg .= "A jeszó megadása kötelező!\n";
    } elseif ( strlen($password) < MINIMUM_PASSWORD_LENGTH ) {
        $error_msg .= "A jeszó minimu " . MINIMUM_PASSWORD_LENGTH . " karakter!\n";
    } elseif ( $password !== $password_again ) {
        $error_msg .= "A két jelszó nem egyezik!\n";
    }

    return $error_msg;
}


function registration($full_name, $user_name, $password, $password_again, $email) {
    $msg = validate_user_data($full_name, $user_name, $password, $password_again, $email);

    if( $msg != "" ) {
        return $msg;
    }

    if( get_user_by_user_name( $user_name ) !=  NULL ) {
        return "A felhasználónév fogllalt!";
    }

    if( get_user_by_email( $email ) !=  NULL ) {
        return "Az email fogllalt!";
    }

    global $db;
    
    try {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql="INSERT INTO `user`(`full_name`, `user_name`, `password`, `email`) VALUES (:full_name, :user_name, :password, :email)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        login_user($user_name, $password);

        return "Sikeres";
    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function get_user_by_user_name( $user_name ) {
    global $db;

    $stmt = $db->prepare('SELECT * FROM user WHERE user_name = :user_name;');
    $stmt->bindParam(':user_name', $user_name);
    $stmt->execute();
// Eredmények lekérdezése asszociatív tömbként
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_user_by_email($email) {
    global $db;

    $stmt = $db->prepare('SELECT * FROM user WHERE email = :email;');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function login_user($user_name, $password) {
    $user = get_user_by_user_name( $user_name );
    $user = ($user != NULL ? $user[ 0 ] : NULL);
    
    if($user == NULL || !password_verify($password, $user["password"])) {
        return "Hibás felhasználónév vagy jelszó!\n";
    }

    session_start();
    // Felhasználói információk tárolása munkameneti változókban
    $_SESSION['user'] = $user;

    // Átirányítás bejelentkezés után a főoldalra    
    header('Location: /');
    exit();
    
}

function logout_user() {
    session_destroy();
    header('Location: /login');
    exit();
}

function validate_user_session() {
    if ( session_status() !== PHP_SESSION_ACTIVE ) {
        session_start();
    }

    if ( !isset( $_SESSION['user'] )) {
        header('Location: /login');
        exit();
    }

    return TRUE;
}
?>