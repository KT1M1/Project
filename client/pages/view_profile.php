<?php
require_once("./server/profile.php"); 

$userID = isset($_GET['user_id']) ? $_GET['user_id'] : null;

$user = get_user_data($userID); // Fetch user data based on the user ID

if( $user != NULL ):


    $uploads = get_uploads($userID);
    $liked_recipes = get_liked_recipes($userID);
    $liked = get_liked($userID);


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
            <?php if(count($uploads) > 0): ?>
                <?php
                foreach($uploads as $upload) {
                    echo '
                    <div class="col-12 col-sm-6 col-lg-4">
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
            <?php else: ?>
    <div class="col-12">
        <p>Nincsenek feltöltött receptek.</p>
    </div>
    <?php endif; ?>
        </div>

        <div class="divider-container">
            <h2 class="divider-left">Kedvelt receptek</h2>
            <hr>
        </div>

        <div class="row">
        <?php
        foreach($liked_recipes as $recipe) {
            echo '
            <div class="col-12 col-sm-6 col-lg-4">
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

<?php
else:
    echo "No user found";
endif;
?>