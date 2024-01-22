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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/client/assets/css/style.css">
    <link rel="stylesheet" href="/client/assets/css/navbar.css">
    <link rel="stylesheet" href="/client/assets/css/popular.css">
    <link rel="stylesheet" href="/client/assets/css/return.css">
    <title>RecipesShare</title>
</head>
<body>

    <?php require_once(__DIR__ . "/client/inc/head.php"); ?>

    <?php 
        require_once(__DIR__ . "/client/pages/" . $load_page . ".php");
    ?>

    <?php require_once(__DIR__ . "/client/inc/footer.php"); ?>

    <script src="/client/assets/js/return.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>