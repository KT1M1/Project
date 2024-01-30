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
        $img_path = image_uploader($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], $_FILES["image"]["size"]);

        $allergen = isset($_POST["allergen"]) ? $_POST["allergen"] : [];

        upload_recipe(
            $_POST["name"],                      //food name
            $img_path,                          //image url
            $_POST["description"],              //description
            $_POST["category"],                 //category ids
            $_POST["portion"],                  //portion
            $_POST["time"],                      //time min
            $allergen,                          //allergen ids
            $_POST["ingredient_name"],          //ingredient names
            $_POST["ingredient_quantity"],      //quantities
            $_POST["ingredient_unit"],          //unit_ids
            $_POST["step"],                    //steps
            date("Y-m-d"),                      //upload date
            $_SESSION['user']['id']             //user_id
        );
    }
?>


<link rel="stylesheet" href="../client/assets/css/upload.css">

<form method="post" enctype="multipart/form-data">

    <div class="container recipe-body">

        <div class="divider-container">
            <h2 class="divider">Recept Feltöltése</h2>
            <hr>
        </div>

        <div class="recipe-name">
            <div class="tooltip">?
                <span class="tooltiptext">max 50 karakter, egyedi elnevezés</span>
            </div>
            <h2>Recept neve:</h2>
            <input type="text" id="nev" name="name" placeholder="Bolognai Spagetti Egyszerűen" required>
        </div>

        <div class="row">

            <!-- The Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Képfeltöltés</h2>
                    <p>Kötelező képet feltölteni!</p>
                    <p>Csak saját készítésű képeket lehet feltölteni! <br> Nem fogadunk el fotókat, amelyek szerzői joga
                        más
                        tulajdonában áll. A feltöltött kép ténylegesen az adott recept elkészítésének lépéseit és
                        összetevőit
                        tükrözze.</p>
                    <h2>Tipp:</h2>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <p>
                                A feltöltött kép neve, kiterjesztéssel együtt, max 100 karakteres lehet.<br>
                                Max 1 MB fájlméretnyi képet tölts fel.<br>
                                Csak .jpg, .jpeg, vagy .png kiterjesztésű képeket fogadunk el.<br>
                                Ajánlott képfelbontás: 1000x800 pixel.<br>
                                Fekvő tájolású fotót tölts fel, felülről lefele fotózva. Ügyelj rá, hogy az étel a kép
                                középpontjában legyenek.
                            </p>
                        </div>
                        <div class="col-md-6 col-sm-12 how-img-div">
                            <img class="img-fluid" src="../client/assets/img/howtopic.jpg" alt="How To Picture">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 recipe-detail">
                <div id="drop-container" onclick="triggerFileInput()">
                    <img id="upload-icon" src="/client/assets/img/photo.png" alt="Upload Icon">
                    <p>Kattints ide a kép feltöltéséhez</p>
                </div>
                <input type="file" id="file-input" name="image" accept="image/*" onchange="displayImage(this)" required>
                <div class="modal-Btn-div">
                    <button id="modalBtn">Képfeltöltési segédlet</button>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 recipe-detail">
                <div>
                    <textarea name="description" id="description" placeholder="Ide írhatsz egy max 300 karakteres leírást a receptedről." maxlength="300"></textarea>
                    <div id="charCount">0/300</div>
                </div>
            </div>

        </div>

        <div class="divider-container">
            <h2 class="divider-left">Kategória</h2>
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
                    <select name="category[]">
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

            <div class="col-md-3 col-sm-12">
                <div class="allergen-div">
                    <h3>Allergént tartalmaz:</h3>
                    <div>
                        <?php
                            foreach($allergens as $allergen) {
                                echo '
                                    <input type="checkbox" id="allergen_' . $allergen["id"] . '" name="allergen[]" value="' . $allergen["id"] . '">
                                    <label for="allergen_' . $allergen["id"] . '" class="allergen-lbl">' . ucfirst($allergen["name"]) . '</label>
                                ';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12 portion-col">
                <div class="portion-div">
                    <label for="hozzavalo_adag">Hozzávalók</label>
                    <input type="number" id="hozzavalo_adag" name="portion" placeholder="4" min="1" required>
                    <label for="hozzavalo_adag">adaghoz</label>
                </div>

                <div>
                    <label for="ido">Elkészítési idő:</label>
                    <input type="number" id="ido" name="time" min="1" placeholder="40" required>
                    <label for="ido">perc</label>
                </div>
            </div>
        </div>

        <div class="divider-container">
            <h2 class="divider-left">Hozzávalók</h2>
            <hr>
        </div>

        <div class="ingredient-container">
            <div class="hozzavalo-div">
                <div>
                    <label class="hozzavalo-lbl">Hozzávaló:</label>
                    <input type="text" class="hozzavalo" id="ingredient_name" name="ingredient_name[]"
                        placeholder="spagetti tészta" required>
                    <div></div>
                </div>

                <label class="hozzavalo-lbl">Mennyiség:</label>
                <input type="number" class="hozzavalo" name="ingredient_quantity[]" min="1" placeholder="500" required>

                <select class="hozzavalo hozzavalo-lbl" name="ingredient_unit[]">
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
            <h2 class="divider-left">Elkészítés</h2>
            <hr>
        </div>

        <div class="step-container">
            <div class="lepes-div">
                <input type="text" class="lepes" name="step[]"
                    placeholder="Főzzük meg a spagetti tésztát a csomagoláson szereplő utasítások szerint sós vízben (általában 8-12 perc.)"
                    required>
            </div>
            <div class="lepes-div">
                <input type="text" class="lepes" name="step[]"
                    placeholder="Eközben egy nagy serpenyőben hevíts olajat közepes lángon. Add hozzá a hagymát, fokhagymát, sárgarépát, párold 5-7 percig, amíg megpuhulnak."
                    required>
            </div>
        </div>
        <!-- Új lépés mezők hozzáadása gomb -->
        <button type="button" class="add-btn" onclick="addStep()">Lépés hozzáadás</button>

        <div class="submit-div">
            <input class="add-btn" type="submit" value="Recept feltöltése">
        </div>

    </div>

    <input type="hidden" name="upload" value="1">
</form>

<script>
    categories = <?php echo json_encode($cat_hierarchy); ?>;

    units_template = `<select class="hozzavalo hozzavalo-lbl" name="ingredient_unit[]">
                    <option selected="true" disabled="disabled">Mértékegység:</option>
                    <?php
                    foreach ($units as $unit) {
                        echo '<option value="' . $unit['id'] . '">' . $unit['name'] . '</option>';
                    }       
                    ?>
                </select>`;
</script>
<script src="/client/assets/js/upload.js"></script>