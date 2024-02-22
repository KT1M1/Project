<?php
$user=$_SESSION["user"];
require_once("./server/profile.php");
$uploads = get_uploads($user["id"]);
$liked_recipes = get_liked_recipes($user["id"]);
$liked = get_liked($user["id"]);
?>

<link rel="stylesheet" href="/client/assets/css/profile.css">

<div class="container">
    <div class="row">
        <div class="col-lg-4 sm-12 profile-col">
            <img class="img-fluid pfp" src="/client/assets/img/<?php echo $user["profile_pic"]; ?>" alt="Profile">
        </div>

        <div class="col-lg-4 sm-12 profile-col">
            <h1><?php echo $user["full_name"]; ?></h1>
            <p>@<?php echo $user["user_name"]; ?></p>
            <p>regisztrált: <?php echo $user["registration_date"]; ?></p>
        </div>
        

        <div class="col-lg-4 sm-12 profile-col">
            <p><span class="number"><?php echo count($uploads); ?></span> <br> feltöltött recept</p>
            <p><span class="number"><?php echo $liked; ?></span> <br> kedvelt recept</p>
        </div>
    </div>
    
    <div class="divider-container">
        <h2 class="divider-left">Feltöltött receptek</h2>
        <hr>
    </div>

    <div class="row">
        <?php
        foreach($uploads as $upload) {
            echo '
            <div class="card-col col-12 col-md-6">
                <a href="show_recipe/'.$upload['id'].'" class="card-div-link">
                    <div class="card-div">
                        <div class="card-top">
                            <img class="card-pic" src="/uploads/imgs/'.$upload['img_url'].'">
                        </div>
                        <div class="card-bottom">
                            <div class="card-text">
                                <p>'.$upload["name"].'</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            ';
        }
        ?>
    </div>

    <div class="divider-container">
        <h2 class="divider-left">Kedvelt receptek</h2>
        <hr>
    </div>

    <div class="row">
    <?php
    foreach($liked_recipes as $recipe) {
        echo '
        <div class="card-col col-12 col-md-6">
            <a href="show_recipe/'.$recipe['id'].'" class="card-div-link">
                <div class="card-div">
                    <div class="card-top">
                        <img class="card-pic" src="/uploads/imgs/'.$recipe['img_url'].'">
                    </div>
                    <div class="card-bottom">
                        <div class="card-text">
                            <p>'.$recipe["name"].'</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        ';
    }
    ?>
</div>

</div>