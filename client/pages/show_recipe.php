<?php
require_once("./server/show.php");

$recipe_data = get_recipe_by_id($_GET['id'])[0];
$categories = get_categories_for_recipe($recipe_data['id']);
$allergens = get_allergens_for_recipe($recipe_data['id']);
$ingredients = get_ingredients_for_recipe($recipe_data['id']);
$steps = get_steps_for_recipe($recipe_data['id']);
$user = get_user_data($recipe_data['id']);
$likes = get_likes($recipe_data['id']);
?>

<script src="/client/assets/js/show.js"></script>

<link rel="stylesheet" href="/client/assets/css/show_recipe.css">

<div class="container recipe-body">

    <div class="row main-col">
        <div class="col-md-5 col-sm-12 description-container">
            <h2 class="recipe-name">
                <?php echo $recipe_data['name']; ?>
            </h2>
            <div class="category-container">
                <?php
                foreach($categories as $category) {
                    echo '<button class="category-btn">' . ucfirst($category['name']) . '</button>';
                }
                ?>
                <hr>
            </div>
            <div>
                <p>
                    <?php echo $recipe_data['description']; ?>
                </p>
            </div>
        </div>
        <div class="col-md-7 col-sm-12 img-col">
            <img class="img-fluid" src="/uploads/imgs/<?php echo $recipe_data['img_url']; ?>">
            <div class="small-detail-container">
                <div>
                    <p>
                        <?php echo ($user['user_name']); ?> -
                        <?php echo ($user['registration_date']); ?>
                    </p>
                </div>
                <div class="heart-container">
                    <img id="full-heart" class="heart-img" src="/client/assets/img/fullheart.png" alt="Like"
                        style="display:none;">
                    <img id="heart" class="heart-img" src="/client/assets/img/heart.png" alt="Unlike">
                    <p>
                        <?php echo $likes; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row details-row">
        <div class="col-md-6 col-sm-12 space">
            <p>Hozzávalók
                <?php echo $recipe_data['portion']; ?> adaghoz
            </p>
            <p>Elkészítési idő:
                <?php echo $recipe_data['time_min']; ?> perc
            </p>
        </div>
        <div class="col-md-6 col-sm-12 space allergen-container">
            <?php
                foreach($allergens as $allergen) {
                    echo ' <img class="allergen-img" src="/client/assets/img/allergen_icons/'. $allergen['icon'] .'">';
                }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-12 ingredient-container" id="ingredientList">
            <h1 class="h1-border">Hozzávalók:</h1>
            <?php
                $counter = 1; //Initialize a counter for unique checkbox IDs
                foreach($ingredients as $ingredient) {
                    echo 
                    '<div class="ing-item">
                        <input type="checkbox" id="ing' . $counter . '" class="ing-cb">
                        <label for="ing' . $counter . '" class="ing-lbl">'. $ingredient['ingredient'] . ' ' . $ingredient['quantity'] . ' ' . $ingredient['unit'] .'</label>
                    </div>';
                    $counter++;
                }
            ?>
        </div>

        <div class="col-lg-8 col-md-12 step-container">
            <h1 class="h1-border h1-step">Elkészítés:</h1>

            <?php
                $counter = 1; //Initialize a counter to number each step
                foreach($steps as $step) {
                    echo '
                    <div class="steps">
                        <h2 class="h2-step">' . $counter . '.</h2>
                        <p class="step-text">' . $step['description'] . '</p>
                    </div>';
                    $counter++;
                }
                ?>
        </div>

        <!--Similar Recipes-->
        <div>
            <div class="divider-container">
                <h2 class="divider-left">Hasonló receptek</h2>
                <hr>
            </div>
            <div>
                <p>Tekintsd meg az aktuális recept mellett elérhető további hasonló recepteket is! Fedezd fel ezeket az
                    alternatív változatokat, és kóstold meg őket, ha az aktuális recept tetszett.
                    A hasonló receptek új ízkombinációkkal és variációkkal szolgálnak, így garantáltan megtalálod a
                    saját
                    ízlésednek leginkább megfelelőt. Ne hagyd ki a lehetőséget, hogy kibővítsd a kulináris élményeidet,
                    és
                    élvezd az új gasztronómiai felfedezéseket!
                </p>
            </div>

            <div class="row popular">
                <!--First Column-->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card-div">
                        <div class="card-top">
                            <img class="card-pic" src="/client/assets/img/bolognese.jpg" alt="">
                        </div>
                        <div class="card-bottom">
                            <div class="card-text">
                                <p>Bolognai Spagetti</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Second Column-->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card-div">
                        <div class="card-top">
                            <img class="card-pic" src="/client/assets/img/bolognese.jpg" alt="">
                        </div>
                        <div class="card-bottom">
                            <div class="card-text">
                                <p>Bolognai Spagetti</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Third Column-->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card-div">
                        <div class="card-top">
                            <img class="card-pic" src="/client/assets/img/bolognese.jpg" alt="">
                        </div>
                        <div class="card-bottom">
                            <div class="card-text">
                                <p>Bolognai Spagetti</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>