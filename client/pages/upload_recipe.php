<?php
    require_once("./server/recipe.php");

    $main_cats = get_main_categories();
    $sub_cats = get_sub_categories();
    $other_cats = get_other_categories();
    $other_cat_types = get_other_category_types();

    $cat_hierarchy = format_main_sub_cat_hierarchy($main_cats, $sub_cats);

    $allergens = get_allergens();

    $units = get_units();

    if(isset($_POST["upload"]) && $_POST["upload"] == "1") {
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
?>


<link rel="stylesheet" href="./client/assets/css/upload.css">

<form action="" method="post">

<div class="container recipe-body">

    <div class="divider-container">
        <h2 class="divider">Recept Feltöltése</h2>
        <hr>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-12 recipe-name">
                <label for="nev">Recept neve:</label>
                <input type="text" id="nev" name="nev" placeholder="Bolognai spagetti" required>
        </div>

        <div class="col-md-6 col-sm-12"></div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div id="drop-container" onclick="triggerFileInput()">
                <img id="upload-icon" src="./client/assets/img/photo.png" alt="Upload Icon">
                <p>Húzd ide vagy kattints a kép feltöltéséhez</p>
                <input type="file" id="file-input" accept="image/*" onchange="displayImage(this)">
                </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div>
                <textarea name="short-desc" id="short-desc" placeholder="Ide írhatsz egy max 300 karakteres leírást a receptedről." maxlength="300"></textarea>
            </div>
        </div>
        
    </div>

    <div class="divider-container">
        <h2 class="divider">Kategória</h2>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">

            <div class="selectContainer">
                <div id="main-category"></div>
                <div id="sub-category"></div>
            </div>

            <?php

                foreach ($other_cat_types as $type) {
                    echo '
                    <select name="category_' . $type["id"] . '">
                        <option selected="true" disabled="disabled">' . $type["name"] . '</option>';

                    foreach ($other_cats as $cat) {
                        if($cat["category_type_id"] == $type["id"]) {
                            echo '<option value="' . $cat['id'] . '">' . $cat['name'] . '</option>';
                        }
                    }
                    echo '</select>';
                }

            ?>
        </div>

        <div class="col-md-6 col-sm-12">
            <div>
                <label for="hozzavalo_adag">Hozzávalók</label>
                <input type="number" id="hozzavalo_adag" name="hozzavalo_adag[]" placeholder="4" min="1" required>
                <label for="hozzavalo_adag">adaghoz</label>
            </div>

            <div>
                <label for="ido">Elkészítési idő:</label>
                <input type="number" id="ido" name="ido" min="1" placeholder="40" required>
                <label for="ido">perc</label>
            </div>
        </div>
    </div>

    <div class="allergen-container">
        <h2>Allergént tartalmaz:</h2>
            <?php
                foreach($allergens as $allergen) {
                    echo '
                        <input type="checkbox" id="allergen_' . $allergen["id"] . '" name="allergen[]" value="' . $allergen["id"] . '">
                        <label for="allergen_' . $allergen["id"] . '" class="allergen-lbl">' . ucfirst($allergen["name"]) . '</label>
                    ';
                }
            ?>
    </div>


    <div class="divider-container">
        <h2 class="divider">Hozzávalók</h2>
        <hr>
    </div>

        <div class="ingredient-container">
            <div class="hozzavalo-div">
                <label class="hozzavalo-lbl">Hozzávaló:</label>
                <input type="text" class="hozzavalo" name="hozzavalo_nev[]" placeholder="spagetti tészta" required>
                
                <label class="hozzavalo-lbl">Mennyiség:</label>
                <input type="number" class="hozzavalo" name="hozzavalo_mennyiseg[]" min="1" placeholder="500" required>
                
                <select class="hozzavalo hozzavalo-lbl" name="hozzavalo_mertekegyseg[]">
                    <option selected="true" disabled="disabled">Mértékegység:</option>
                    <?php
                    foreach ($units as $unit) {
                        echo '<option value="' . $unit['id'] . '">' . $unit['name'] . '</option>';
                    }       
                    ?>
                </select>

                <button type="button" class="remove-btn">x</button>
            </div>
        </div>
        <!-- Új hozzávaló mezők hozzáadása gomb -->
        <button type="button" class="add-btn" onclick="addIngredient()">Hozzávaló hozzáadás</button>


    <div class="divider-container">
        <h2 class="divider">Elkészítés</h2>
        <hr>
    </div>

    <div class="step-container">
        <div class="lepes-div">
            <input type="text" class="lepes" name="lepes[]" placeholder="Főzzük meg a spagetti tésztát a csomagoláson szereplő utasítások szerint sós vízben (általában 8-12 perc.)" required>
        </div>
        <div class="lepes-div">
            <input type="text" class="lepes" name="lepes[]" placeholder="Eközben egy nagy serpenyőben hevíts olajat közepes lángon. Add hozzá a hagymát, fokhagymát, sárgarépát, párold 5-7 percig, amíg megpuhulnak." required>
        </div>
    </div>
    <!-- Új lépés mezők hozzáadása gomb -->
    <button type="button" class="add-btn" onclick="addStep()">Lépés hozzáadás</button>
        
   <input type="submit" value="Recept feltöltése">
</div>

<input type="hidden" name="upload" value="1">
</form>

<script>
    categories = <?php echo json_encode($cat_hierarchy); ?>;

    units_template = `<select class="hozzavalo hozzavalo-lbl" name="hozzavalo_mertekegyseg[]">
                    <option selected="true" disabled="disabled">Mértékegység:</option>
                    <?php
                    foreach ($units as $unit) {
                        echo '<option value="' . $unit['id'] . '">' . $unit['name'] . '</option>';
                    }       
                    ?>
                </select>`;
</script>
<script src="./client/assets/js/upload.js"></script>

