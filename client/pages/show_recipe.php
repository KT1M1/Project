<?php
require_once("./server/show.php");

$recipe_data = get_recipe_by_id($_GET['id'])[0];
// Get informations associated with the recipe
$categories = get_categories_for_recipe($recipe_data['id']);
$allergens = get_allergens_for_recipe($recipe_data['id']);
$ingredients = get_ingredients_for_recipe($recipe_data['id']);
$steps = get_steps_for_recipe($recipe_data['id']);
$user = get_user_data($recipe_data['id']);
$likes = get_likes($recipe_data['id']);

$is_user_liked = false;
?>

<script>
    let food_id = <?php echo $_GET['id']; ?>;

    <?php
        // Check if a user is logged in
        if( isset($_SESSION["user"]) ) {
             // Pass the user ID from PHP session to JavaScript
            echo "let user_id = " . $_SESSION["user"]["id"] . ";";

            // Check if the currently logged-in user has liked the recipe
            $is_user_liked = is_liked($_GET['id'], $_SESSION["user"]["id"]);
        }
    ?>
</script>
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
                    <a href="/page/view_profile&user_id=<?php echo $user['id']; ?>">
                        <p>
                            <?php echo ($user['user_name']); ?> -
                            <?php echo ($recipe_data['upload_date']); ?>
                        </p>
                    </a>
                </div>

                <?php
                // If a user is not logged in, wrap the like feature in a link to prompt login
                    if( !isset($_SESSION["user"]) ) {
                        echo '<a href="/login">';
                    }
                ?>
                    <div class="heart-container">
                        <img id="full-heart" class="heart-img" src="/client/assets/img/fullheart.png" alt="Like"
                            <?php if( !$is_user_liked ) echo 'style="display:none;"'; ?> >
                        <img id="heart" class="heart-img" src="/client/assets/img/heart.png" alt="Unlike"
                            <?php if( $is_user_liked ) echo 'style="display:none;"'; ?> >
                        <p>
                            <?php echo $likes; ?>
                        </p>
                    </div>
                <?php
                    if( !isset($_SESSION["user"]) ) {
                        echo '</a>';
                    }
                ?>

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
                $counter = 1; // Create a counter for unique checkbox IDs
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
                $counter = 1; // Create a counter to number each step
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
    </div>
</div>