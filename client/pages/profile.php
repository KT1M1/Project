<?php
$user=$_SESSION["user"];
require_once("./server/profile.php");

// Delete Recipe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_recipe') {
    if (isset($_POST['food_id'])) {
        $food_id = $_POST['food_id'];
        $result = delete_recipe($food_id, $user["id"]);
    }
}

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
            <h1>
                <?php echo $user["full_name"]; ?>
            </h1>
            <p>@
                <?php echo $user["user_name"]; ?>
            </p>
            <p>regisztrált:
                <?php echo $user["registration_date"]; ?>
            </p>
        </div>


        <div class="col-lg-4 sm-12 profile-col">
            <p><span class="number">
                    <?php echo count($uploads); ?>
                </span> <br> feltöltött recept</p>
            <p><span class="number">
                    <?php echo $liked; ?>
                </span> <br> kedvelt recept</p>
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
                        <form action="?page=profile" method="POST">
                            <input type="hidden" name="action" value="delete_recipe">
                            <input type="hidden" name="food_id" value="'.$upload['id'].'">
                            <button type="submit" class="delete-cube">
                                <img class="img-fluid" src="/client/assets/img/trash.png" alt="Delete">
                            </button>
                        </form>
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