<?php
    session_start();
    require_once("./server/user.php");

    $load_page = "main";

    if(isset($_GET["page"])) {
        $load_page = $_GET["page"];
    }

    $NEED_LOGIN = array(
        "upload_recipe",
        "profile"
    );

    if( in_array($load_page, $NEED_LOGIN) ) {
        validate_user_session();
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Flavora</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Böngéssz gyorsan és egyszerűen mások által feltöltött recept között, vagy töltsd fel sajátod ezen a magyar receptfeltöltő oldalon.">
    <meta name="keywords" content="receptmegosztó, magyar receptek, recept feltöltés, online receptkönyv, receptkereső, konyhaművészet, egyszerű receptek, gasztronómia">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/client/assets/css/header.css">
    <link rel="stylesheet" href="/client/assets/css/footer.css">
    <link rel="stylesheet" href="/client/assets/css/style.css">
    <link rel="stylesheet" href="/client/assets/css/popular.css">
    <link rel="stylesheet" href="/client/assets/css/return.css">
    <link rel="icon" href="/client/assets/img/logocirc.png" type="image/x-icon">
</head>
<body>

    <?php require_once(__DIR__ . "/client/inc/header.php"); ?>

    <?php 
        require_once(__DIR__ . "/client/pages/" . $load_page . ".php");
    ?>

    <?php require_once(__DIR__ . "/client/inc/footer.php"); ?>

    <script src="/client/assets/js/return.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>